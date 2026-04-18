<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ setting('site_name', 'Campus') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-header img {
            max-height: 80px;
            max-width: 200px;
            object-fit: contain;
            background: white;
            padding: 10px;
            border-radius: 10px;
        }
        .login-header h4 {
            margin: 0;
            font-weight: 600;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            width: 100%;
            font-weight: 600;
            color: white;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .captcha-box {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            box-shadow: 0 4px 10px rgba(240, 147, 251, 0.3);
        }
        .captcha-icon {
            color: #667eea;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            @if(setting('site_logo'))
                <div class="mb-3">
                    <img src="{{ asset('storage/'.setting('site_logo')) }}" 
                         alt="{{ setting('site_name', 'Campus') }}">
                </div>
            @else
                <i class="fas fa-graduation-cap fa-3x mb-3"></i>
            @endif
            <h4>{{ setting('site_name', 'Campus') }}</h4>
            <p class="mb-0">Login Admin Panel</p>
        </div>
        <div class="login-body">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">Email / Username</label>
                    <input type="text" 
                           class="form-control @error('login') is-invalid @enderror" 
                           id="login" 
                           name="login" 
                           value="{{ old('login') }}" 
                           required 
                           autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CAPTCHA -->
                <div class="mb-3">
                    <label for="captcha" class="form-label">
                        <i class="fas fa-shield-alt captcha-icon me-2"></i>Verifikasi Keamanan
                    </label>
                    <div class="captcha-box">
                        <i class="fas fa-calculator me-2"></i>
                        {{ session('captcha_num1', 0) }} + {{ session('captcha_num2', 0) }} = ?
                    </div>
                    <input type="number" 
                           class="form-control @error('captcha') is-invalid @enderror" 
                           id="captcha" 
                           name="captcha" 
                           placeholder="Masukkan hasil penjumlahan"
                           required>
                    @error('captcha')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-info-circle me-1"></i>Hitung hasil penjumlahan di atas untuk verifikasi
                    </small>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        Ingat Saya
                    </label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Lupa Password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Clear captcha input on page load if there's an error
        @if($errors->has('captcha'))
        document.getElementById('captcha').value = '';
        document.getElementById('captcha').focus();
        @endif
    </script>
</body>
</html>
