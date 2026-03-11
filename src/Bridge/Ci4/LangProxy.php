<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

class LangProxy
{
    private string $subdirectory = '';

    /**
     * @var array<string,bool>
     */
    private array $loaded = [];

    /**
     * @var array<string,string>
     */
    private array $lines = [];

    /**
     * @var array<string,bool>
     */
    private array $resolving = [];

    public function addSubdirectory(string $path): void
    {
        $this->subdirectory = trim($path, '/');
    }

    public function line(string $key): string
    {
        if (array_key_exists($key, $this->lines)) {
            return $this->lines[$key];
        }

        $this->autoloadKeyFamily($key);

        if (array_key_exists($key, $this->lines)) {
            return $this->lines[$key];
        }

        if (isset($this->resolving[$key])) {
            return $key;
        }

        if (function_exists('service')) {
            try {
                $this->resolving[$key] = true;
                $value = service('language')->getLine($key);
                unset($this->resolving[$key]);
                if (is_string($value) && $value !== $key) {
                    return $value;
                }
            } catch (\Throwable $e) {
                unset($this->resolving[$key]);
                // Fallback below.
            }
        }

        return $key;
    }

    /**
     * CI3-compatible load API.
     *
     * In CI4 there is no direct equivalent "load" on the language service for
     * legacy files, so we prewarm known files and keep a no-op-compatible
     * return value.
     *
     * @param string $file
     * @return bool
     */
    public function load(string $file): bool
    {
        $file = trim($file, '/');
        if ($file === '') {
            return true;
        }

        $candidates = [];
        if ($this->subdirectory !== '') {
            $candidates[] = $this->subdirectory . '/' . $file;
        }
        $candidates[] = $file;

        $loaded = false;
        foreach ($candidates as $key) {
            if (isset($this->loaded[$key])) {
                $loaded = true;
                continue;
            }

            $loaded = $this->loadLegacyLanguageFile($key) || $loaded;

            try {
                // Keep CI4 warm-up too for files already migrated to CI4 format.
                lang($key . '._bootstrap_probe_');
            } catch (\Throwable $e) {
                // Ignore: legacy loading is the primary path here.
            }

            $this->loaded[$key] = true;
        }

        return $loaded;
    }

    public function subdirectory(): string
    {
        return $this->subdirectory;
    }

    private function loadLegacyLanguageFile(string $key): bool
    {
        $language = 'french';
        try {
            if (function_exists('get_instance')) {
                $ci = get_instance();
                $language = (string) (($ci->config->item('language') ?: 'french'));
            }
        } catch (\Throwable $e) {
            $language = 'french';
        }

        $languageCandidates = $this->resolveLanguageCandidates($language);

        $relative = $key . '_lang.php';
        $paths = [];
        foreach ($languageCandidates as $candidate) {
            if (defined('APPPATH')) {
                $paths[] = APPPATH . 'Language/' . $candidate . '/' . $relative;
                $paths[] = APPPATH . 'language/' . $candidate . '/' . $relative;
            }
        }

        foreach ($paths as $path) {
            if (!$path || !is_file($path)) {
                continue;
            }

            $lang = [];
            include $path;
            if (!is_array($lang) || $lang === []) {
                continue;
            }

            foreach ($lang as $lineKey => $value) {
                if (is_string($lineKey) && (is_string($value) || is_numeric($value))) {
                    $this->lines[$lineKey] = (string) $value;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @return list<string>
     */
    private function resolveLanguageCandidates(string $language): array
    {
        $normalized = strtolower(trim($language));
        if ($normalized === '') {
            $normalized = 'french';
        }

        if ($normalized === 'en') {
            return ['en', 'english'];
        }

        if ($normalized === 'english') {
            return ['english', 'en'];
        }

        if ($normalized === 'fr') {
            return ['fr', 'french'];
        }

        if ($normalized === 'french') {
            return ['french', 'fr'];
        }

        return [$normalized];
    }

    private function autoloadKeyFamily(string $key): void
    {
        if (!str_contains($key, '_')) {
            return;
        }

        // Project-specific convention: navigation_* keys live in navigation/navigation_default_lang.php
        if (str_starts_with($key, 'navigation_')) {
            $this->load('navigation/navigation_default');
            return;
        }

        $prefix = strstr($key, '_', true);
        if ($prefix !== false && $prefix !== '') {
            $this->load($prefix);
        }
    }
}
