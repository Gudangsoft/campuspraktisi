<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    /**
     * Boot the translatable trait
     */
    protected static function bootTranslatable()
    {
        // Add translatable attributes to appends
        static::retrieved(function ($model) {
            if (isset($model->translatable)) {
                foreach ($model->translatable as $attr) {
                    $model->append($attr . '_translated');
                }
            }
        });
    }
    
    /**
     * Get translation for current locale or fallback
     *
     * @param string|null $locale
     * @return mixed
     */
    public function translate(?string $locale = null)
    {
        $locale = $locale ?: App::getLocale();
        
        // Try to get translation for requested locale
        $translation = $this->translations()->where('locale', $locale)->first();
        
        // If not found, try fallback locale
        if (!$translation) {
            $fallbackLocale = config('app.fallback_locale');
            $translation = $this->translations()->where('locale', $fallbackLocale)->first();
        }
        
        // If still not found, return first available translation
        if (!$translation) {
            $translation = $this->translations()->first();
        }
        
        return $translation;
    }
    
    /**
     * Get translated attribute
     *
     * @param string $key
     * @param string|null $locale
     * @return mixed
     */
    public function getTranslatedAttribute(string $key, ?string $locale = null)
    {
        $translation = $this->translate($locale);
        return $translation ? $translation->$key : null;
    }
    
    /**
     * Magic getter for translated attributes
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        // Check if attribute exists in translation
        $translatableAttributes = $this->translatable ?? [];
        
        if (in_array($key, $translatableAttributes)) {
            // Try to get from translation first
            $translated = $this->getTranslatedAttribute($key);
            
            // If no translation, fallback to parent (original column)
            if ($translated === null) {
                return parent::__get($key);
            }
            
            return $translated;
        }
        
        // Fall back to parent __get
        return parent::__get($key);
    }
    
    /**
     * Get all translations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTranslations()
    {
        return $this->translations;
    }
    
    /**
     * Check if translation exists for locale
     *
     * @param string $locale
     * @return bool
     */
    public function hasTranslation(string $locale): bool
    {
        return $this->translations()->where('locale', $locale)->exists();
    }
}
