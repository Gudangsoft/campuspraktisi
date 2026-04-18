<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    public function generate(Request $request)
    {
        try {
            $prompt = $request->input('prompt');
            $action = $request->input('action');
            $currentContent = $request->input('current_content', '');

            // Build the AI prompt based on action
            $systemPrompt = $this->buildSystemPrompt($action, $currentContent);
            $userPrompt = $this->buildUserPrompt($prompt, $action, $currentContent);

            // Check if OpenAI API key is configured
            $apiKey = env('OPENAI_API_KEY');
            
            if (!$apiKey) {
                // Fallback to demo/mock content if no API key
                return $this->generateMockContent($prompt, $action, $currentContent);
            }

            // Call OpenAI API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userPrompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $generatedContent = $data['choices'][0]['message']['content'] ?? '';

                // Format content as HTML
                $formattedContent = $this->formatAsHtml($generatedContent);

                return response()->json([
                    'success' => true,
                    'content' => $formattedContent,
                ]);
            } else {
                Log::error('OpenAI API Error', ['response' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'API Error: ' . $response->status(),
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('AI Generation Error', ['error' => $e->getMessage()]);
            
            // Fallback to mock content on error
            return $this->generateMockContent($prompt, $action, $currentContent);
        }
    }

    private function buildSystemPrompt($action, $currentContent)
    {
        $basePrompt = "Anda adalah asisten penulisan profesional untuk konten berita kampus. ";
        
        switch ($action) {
            case 'generate':
                return $basePrompt . "Tulis konten berita yang informatif, menarik, dan profesional dalam Bahasa Indonesia. Gunakan format HTML sederhana dengan paragraf (<p>) dan heading jika diperlukan.";
            
            case 'continue':
                return $basePrompt . "Lanjutkan penulisan konten yang sudah ada dengan gaya dan konteks yang konsisten. Konten saat ini: " . substr($currentContent, 0, 500);
            
            case 'rewrite':
                return $basePrompt . "Tulis ulang konten berikut dengan lebih baik, lebih menarik, dan lebih profesional. Perbaiki tata bahasa dan struktur kalimat.";
            
            case 'expand':
                return $basePrompt . "Kembangkan konten berikut menjadi lebih detail dan komprehensif. Tambahkan informasi yang relevan dan contoh jika perlu.";
            
            case 'summarize':
                return $basePrompt . "Buat ringkasan singkat dan padat dari konten berikut. Fokus pada poin-poin penting.";
            
            default:
                return $basePrompt . "Bantu menulis konten berita kampus yang berkualitas.";
        }
    }

    private function buildUserPrompt($prompt, $action, $currentContent)
    {
        if (in_array($action, ['continue', 'rewrite', 'expand', 'summarize']) && !empty($currentContent)) {
            return $prompt . "\n\nKonten yang ada:\n" . $currentContent;
        }
        
        return $prompt;
    }

    private function formatAsHtml($content)
    {
        // Convert plain text to HTML if needed
        if (strpos($content, '<p>') === false && strpos($content, '<h') === false) {
            // Split by double line breaks to create paragraphs
            $paragraphs = preg_split('/\n\s*\n/', trim($content));
            $html = '';
            foreach ($paragraphs as $para) {
                $para = trim($para);
                if (!empty($para)) {
                    // Check if it's a title/heading (short, capitalized)
                    if (strlen($para) < 100 && preg_match('/^[A-Z]/', $para) && !preg_match('/[.!?]$/', $para)) {
                        $html .= '<h3>' . $para . '</h3>';
                    } else {
                        $html .= '<p>' . nl2br($para) . '</p>';
                    }
                }
            }
            return $html;
        }
        
        return $content;
    }

    private function generateMockContent($prompt, $action, $currentContent)
    {
        // Generate mock content when API is not available
        $mockContents = [
            'generate' => '<h3>Kampus Mengadakan Seminar Teknologi</h3><p>Kampus mengadakan seminar teknologi yang dihadiri oleh ratusan mahasiswa dan dosen. Acara ini menampilkan pembicara ahli dari berbagai bidang teknologi informasi.</p><p>Seminar berlangsung selama dua hari dengan berbagai sesi workshop dan diskusi panel. Para peserta mendapatkan wawasan berharga tentang perkembangan teknologi terkini.</p>',
            
            'continue' => '<p>Acara dilanjutkan dengan sesi tanya jawab yang sangat interaktif. Para peserta antusias mengajukan pertanyaan kepada narasumber. Diskusi berlangsung hangat dan produktif hingga sore hari.</p>',
            
            'rewrite' => '<p>Konten ini telah ditulis ulang dengan struktur yang lebih baik dan bahasa yang lebih profesional. Informasi disajikan secara sistematis dan mudah dipahami oleh pembaca.</p>',
            
            'expand' => '<p>Konten yang telah dikembangkan ini mencakup lebih banyak detail dan informasi pendukung. Setiap poin dijelaskan secara komprehensif dengan contoh-contoh konkret yang relevan. Pembahasan diperdalam untuk memberikan pemahaman yang lebih baik kepada pembaca.</p>',
            
            'summarize' => '<p><strong>Ringkasan:</strong> Kampus mengadakan kegiatan seminar teknologi dengan antusiasme tinggi dari peserta. Acara berlangsung sukses dengan berbagai sesi pembelajaran dan diskusi yang produktif.</p>',
        ];

        $content = $mockContents[$action] ?? $mockContents['generate'];

        return response()->json([
            'success' => true,
            'content' => $content,
            'note' => 'Demo mode - Configure OPENAI_API_KEY in .env for real AI generation'
        ]);
    }
}
