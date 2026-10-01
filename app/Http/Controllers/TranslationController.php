<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TranslationController extends Controller
{
    /**
     * Translate text or array of texts via dictionary with free translation API fallback.
     */
    public function translate(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'nullable|string',
            'texts' => 'nullable|array',
            'texts.*' => 'string',
            'source' => 'nullable|string|max:10',
            'target' => 'nullable|string|max:10',
        ]);

        $source = strtolower(trim((string) $request->input('source', 'en')));
        $target = strtolower(trim((string) $request->input('target', 'sw')));

        // Standardize language codes
        if ($source === 'swahili') {
            $source = 'sw';
        }
        if ($source === 'english') {
            $source = 'en';
        }
        if ($target === 'swahili') {
            $target = 'sw';
        }
        if ($target === 'english') {
            $target = 'en';
        }

        // Handle batch translation
        if ($request->has('texts') && is_array($request->input('texts'))) {
            $results = [];
            foreach ($request->input('texts') as $item) {
                $results[$item] = $this->translateSingle((string) $item, $source, $target);
            }

            return response()->json([
                'success' => true,
                'source' => $source,
                'target' => $target,
                'translations' => $results,
            ]);
        }

        // Handle single text
        $text = (string) $request->input('text', '');
        $translated = $this->translateSingle($text, $source, $target);

        return response()->json([
            'success' => true,
            'source' => $source,
            'target' => $target,
            'original' => $text,
            'translated' => $translated,
        ]);
    }

    /**
     * Return entire translation dictionary for a given locale.
     */
    public function getDictionary(string $locale): JsonResponse
    {
        $locale = in_array(strtolower(trim($locale)), ['sw', 'en'], true) ? strtolower(trim($locale)) : 'sw';
        $path = base_path("lang/{$locale}.json");

        $dictionary = [];
        if (File::exists($path)) {
            $dictionary = json_decode((string) File::get($path), true) ?: [];
        }

        return response()->json([
            'success' => true,
            'locale' => $locale,
            'count' => count($dictionary),
            'dictionary' => $dictionary,
        ]);
    }

    /**
     * Translate single text string using Dictionary -> Cache -> Free API -> Original fallback.
     */
    protected function translateSingle(string $text, string $source, string $target): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }

        // Skip translation for numbers, prices, currency, or pure alphanumeric SKU/order codes (e.g. #INV-001, 10023)
        if (preg_match('/^(\+|-)?(TSh|TSH|tsh|Tsh|\$|€|£)?\s*[0-9,\.]+(\s*%)?$/', $text)
            || preg_match('/^#[A-Za-z0-9\-_]+$/', $text)
            || (preg_match('/^[A-Z0-9\-_]{4,}$/i', $text) && preg_match('/[0-9]/', $text))) {
            return $text;
        }

        // Check local dictionary file first
        $localDictionary = $this->loadDictionary($target);
        $lookupKey = strtolower($text);

        foreach ($localDictionary as $k => $v) {
            if (strtolower(trim((string) $k)) === $lookupKey) {
                return (string) $v;
            }
        }

        // Reverse lookup if translating from Swahili back to English
        if ($target === 'en') {
            $swDictionary = $this->loadDictionary('sw');
            foreach ($swDictionary as $k => $v) {
                if (strtolower(trim((string) $v)) === $lookupKey) {
                    return (string) $k;
                }
            }
        }

        // Check persistent cache
        $cacheKey = "bilingual_trans_{$source}_{$target}_".md5($text);
        if (Cache::has($cacheKey)) {
            return (string) Cache::get($cacheKey);
        }

        // Attempt Free External Translation API (MyMemory Translation Service with 2s timeout)
        try {
            $langpair = "{$source}|{$target}";
            $apiUrl = 'https://api.mymemory.translated.net/get';

            $response = Http::timeout(2.5)->get($apiUrl, [
                'q' => $text,
                'langpair' => $langpair,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $translatedText = $data['responseData']['translatedText'] ?? null;

                if ($translatedText && is_string($translatedText) && ! str_contains($translatedText, 'MYMEMORY WARNING')) {
                    $cleaned = html_entity_decode($translatedText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    Cache::put($cacheKey, $cleaned, now()->addDays(30));

                    return $cleaned;
                }
            }
        } catch (\Throwable) {
            // Graceful fallback when network/external service is unavailable or slow
        }

        // Return original if translation could not be found
        return $text;
    }

    /**
     * Load locale dictionary from json file.
     *
     * @return array<string, string>
     */
    protected function loadDictionary(string $locale): array
    {
        static $cachedDictionaries = [];

        if (isset($cachedDictionaries[$locale])) {
            return $cachedDictionaries[$locale];
        }

        $path = base_path("lang/{$locale}.json");
        if (File::exists($path)) {
            $data = json_decode((string) File::get($path), true);
            $cachedDictionaries[$locale] = is_array($data) ? $data : [];
        } else {
            $cachedDictionaries[$locale] = [];
        }

        return $cachedDictionaries[$locale];
    }
}
