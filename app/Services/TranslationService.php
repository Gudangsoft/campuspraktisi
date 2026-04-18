<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate text using Google Translate (free via stichoza/google-translate-php)
     *
     * @param string $text
     * @param string $targetLang
     * @param string $sourceLang
     * @return string
     */
    public function translate(string $text, string $targetLang = 'en', string $sourceLang = 'id'): string
    {
        if (empty($text)) {
            return $text;
        }
        
        // Check cache first
        $cacheKey = 'translation_' . md5($text . $targetLang . $sourceLang);
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            // Use stichoza/google-translate-php package
            if (class_exists('\Stichoza\GoogleTranslate\GoogleTranslate')) {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate();
                $tr->setSource($sourceLang);
                $tr->setTarget($targetLang);
                
                $translated = $tr->translate($text);
                
                // Cache for 30 days
                Cache::put($cacheKey, $translated, now()->addDays(30));
                
                return $translated;
            }
            
            // Fallback: Use simple HTTP request to Google Translate
            return $this->translateViaHttp($text, $targetLang, $sourceLang);
            
        } catch (\Exception $e) {
            Log::error('Translation error', [
                'text' => substr($text, 0, 100),
                'target' => $targetLang,
                'error' => $e->getMessage()
            ]);
            
            // Return original text on error
            return $text;
        }
    }
    
    /**
     * Fallback translation via HTTP request
     */
    protected function translateViaHttp(string $text, string $targetLang, string $sourceLang): string
    {
        try {
            $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$sourceLang}&tl={$targetLang}&dt=t&q=" . urlencode($text);
            
            $response = @file_get_contents($url);
            
            if ($response) {
                $data = json_decode($response, true);
                
                if (isset($data[0][0][0])) {
                    return $data[0][0][0];
                }
            }
        } catch (\Exception $e) {
            Log::error('HTTP translation error', ['error' => $e->getMessage()]);
        }
        
        return $text;
    }
    
    /**
     * Translate HTML content (preserve tags)
     *
     * @param string $html
     * @param string $targetLang
     * @param string $sourceLang
     * @return string
     */
    public function translateHtml(string $html, string $targetLang = 'en', string $sourceLang = 'id'): string
    {
        // Strip HTML tags
        $text = strip_tags($html);
        
        // Translate plain text
        $translated = $this->translate($text, $targetLang, $sourceLang);
        
        // Wrap in paragraph if original had HTML
        if ($html !== $text && !empty($translated)) {
            return '<p>' . nl2br(htmlspecialchars($translated)) . '</p>';
        }
        
        return $translated;
    }
    
    /**
     * Auto-create translation for a model
     *
     * @param mixed $model
     * @param string $targetLang
     * @return bool
     */
    public function autoTranslateModel($model, string $targetLang = 'en'): bool
    {
        try {
            $translationClass = get_class($model) . 'Translation';
            
            if (!class_exists($translationClass)) {
                return false;
            }
            
            // Check if translation already exists
            $exists = $translationClass::where('news_id', $model->id)
                                      ->where('locale', $targetLang)
                                      ->exists();
            
            if ($exists) {
                return true; // Already translated
            }
            
            // Get original values
            $attributes = $model->getAttributes();
            
            // Translate fields
            $translated = [
                'news_id' => $model->id,
                'locale' => $targetLang,
                'title' => $this->translate($attributes['title'] ?? '', $targetLang),
                'slug' => ($attributes['slug'] ?? '') . '-' . $targetLang,
                'excerpt' => $this->translate($attributes['excerpt'] ?? '', $targetLang),
                'content' => $this->translateHtml($attributes['content'] ?? '', $targetLang),
            ];
            
            // Create translation
            $translationClass::create($translated);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Auto translate model error', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
