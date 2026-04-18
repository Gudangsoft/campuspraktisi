<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentGenerator
{
    protected $apiKey;
    protected $model = 'gpt-3.5-turbo';
    
    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
    }
    
    /**
     * Generate article content based on prompt
     * 
     * @param string $prompt User's content prompt
     * @param int $maxLength Maximum characters (500 default)
     * @return array ['success' => bool, 'content' => string, 'message' => string]
     */
    public function generateContent(string $prompt, int $maxLength = 500): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'content' => '',
                'message' => 'OpenAI API key belum dikonfigurasi. Silakan tambahkan OPENAI_API_KEY di file .env'
            ];
        }
        
        if (empty($prompt)) {
            return [
                'success' => false,
                'content' => '',
                'message' => 'Prompt tidak boleh kosong'
            ];
        }
        
        try {
            // Calculate max tokens (roughly 1 token = 4 characters)
            $maxTokens = intval($maxLength / 4);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah asisten penulisan artikel profesional. Tulis artikel dalam bahasa Indonesia yang mudah dipahami, informatif, dan menarik.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $maxTokens,
                'temperature' => 0.7,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['choices'][0]['message']['content'])) {
                    $content = trim($data['choices'][0]['message']['content']);
                    
                    return [
                        'success' => true,
                        'content' => $content,
                        'message' => 'Konten berhasil di-generate',
                        'tokens_used' => $data['usage']['total_tokens'] ?? 0
                    ];
                }
            }
            
            // Handle API errors
            $errorMessage = 'Gagal generate konten';
            if ($response->status() == 401) {
                $errorMessage = 'API key tidak valid';
            } elseif ($response->status() == 429) {
                $errorMessage = 'Rate limit exceeded. Silakan coba lagi nanti';
            }
            
            Log::error('OpenAI API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [
                'success' => false,
                'content' => '',
                'message' => $errorMessage
            ];
            
        } catch (\Exception $e) {
            Log::error('AI Content Generator Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'content' => '',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }
}
