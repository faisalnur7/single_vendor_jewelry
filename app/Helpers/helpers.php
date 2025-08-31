<?php
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

if (! function_exists('menuOpen')) {
    function menuOpen(array $routes): bool {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
}

if (! function_exists('translateText')) {
    function translateText($text, $targetLang = null)
    {
        $lang = $targetLang ?? session('lang', 'en');
        
        // Return original text if English or empty
        if ($lang === 'en' || empty(trim($text))) {
            return $text;
        }

        // Create cache key
        $cacheKey = 'translation_' . md5($text . '_' . $lang);
        
        // Try to get from cache first (cache for 24 hours)
        return Cache::remember($cacheKey, 86400, function () use ($text, $lang) {
            try {
                $tr = new GoogleTranslate($lang);
                $tr->setSource('en'); // Set source language explicitly
                return $tr->translate($text);
            } catch (\Throwable $e) {
                // Log error for debugging
                \Log::warning('Translation failed', [
                    'text' => $text,
                    'lang' => $lang,
                    'error' => $e->getMessage()
                ]);
                return $text; // Return original text on failure
            }
        });
    }
}


if (!function_exists('translateText')) {
    function translateText($text)
    {
        $lang = session('lang', 'en');
        
        if ($lang === 'en' || empty(trim($text))) {
            return $text;
        }

        $cacheKey = 'trans_' . md5($text . '_' . $lang);
        
        return Cache::remember($cacheKey, 86400, function () use ($text, $lang) {
            try {
                $tr = new GoogleTranslate($lang);
                $tr->setSource('en');
                return $tr->translate($text);
            } catch (\Exception $e) {
                \Log::warning('Translation failed: ' . $e->getMessage());
                return $text;
            }
        });
    }
}