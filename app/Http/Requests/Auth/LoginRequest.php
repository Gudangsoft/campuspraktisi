<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'numeric'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'captcha.required' => 'Jawaban CAPTCHA harus diisi.',
            'captcha.numeric' => 'Jawaban CAPTCHA harus berupa angka.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Validate CAPTCHA
        $this->validateCaptcha();

        $login = $this->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (! Auth::attempt([$fieldType => $login, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Validate CAPTCHA answer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCaptcha(): void
    {
        $captchaAnswer = session('captcha_answer');
        $userAnswer = $this->input('captcha');

        if (!$captchaAnswer || $userAnswer != $captchaAnswer) {
            // Regenerate CAPTCHA for next attempt
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            
            session([
                'captcha_num1' => $num1,
                'captcha_num2' => $num2,
                'captcha_answer' => $num1 + $num2
            ]);

            throw ValidationException::withMessages([
                'captcha' => 'Jawaban CAPTCHA salah. Silakan coba lagi.',
            ]);
        }

        // Clear CAPTCHA after successful validation
        session()->forget(['captcha_num1', 'captcha_num2', 'captcha_answer']);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}
