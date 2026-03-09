<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use Config\App as AppConfig;
use Config\Autoload as Ci4AutoloadConfig;
use Config\Cookie as CookieConfig;
use Config\Legacy as LegacyConfig;
use Config\Security as SecurityConfig;
use Config\Session as SessionConfig;

class ConfigProxy
{
    /**
     * @var array<string,mixed>
     */
    private array $items = [];

    /**
     * @var array<string,array<string,mixed>>
     */
    private array $sections = [];

    /**
     * @var array<string,bool>
     */
    private array $loadedFiles = [];

    /**
     * @var array<string,bool>
     */
    private array $loggedLegacyHits = [];

    /**
     * @var array<string,bool>
     */
    private array $loggedUnknownKeys = [];
    public function __construct()
    {
        // Load legacy defaults early so config_item() works even when
        // controllers/helpers query values before explicit load() calls.
        $this->load('config');
        $this->load('site_settings', true);
        $this->load('email', true);
        $this->logMissingRequiredKeys();
    }

    public function load(string $file, bool $useSections = false): bool
    {
        if (isset($this->loadedFiles[$file])) {
            return true;
        }

        $loaded = $this->loadMappedCi4File($file);
        if ($loaded === null) {
            $loaded = $this->loadLegacyFile($file);
        }
        if ($loaded === null) {
            return false;
        }

        if ($useSections) {
            $this->sections[$file] = $loaded;
        }

        $this->items = array_merge($this->items, $loaded);
        $this->loadedFiles[$file] = true;
        return true;
    }

    public function item(string $key, ?string $section = null)
    {
        if ($section !== null) {
            if (!isset($this->sections[$section])) {
                $this->load($section, true);
            }

            if (isset($this->sections[$section]) && array_key_exists($key, $this->sections[$section])) {
                return $this->sections[$section][$key];
            }
            if (isset($this->items[$section]) && is_array($this->items[$section]) && array_key_exists($key, $this->items[$section])) {
                return $this->items[$section][$key];
            }
        }

        $legacyValue = $this->readLegacyConfig($key);
        if ($legacyValue !== null) {
            $this->logLegacyHit($key);
            return $legacyValue;
        }

        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        $envValue = $this->readEnv($key);
        if ($envValue !== null) {
            return $envValue;
        }

        $ci4Value = $this->readCi4Config($key);
        if ($ci4Value !== null) {
            return $ci4Value;
        }

        $this->logUnknownKey($key);
        return null;
    }

    private function readLegacyConfig(string $key)
    {
        if (!function_exists('config') || !class_exists(LegacyConfig::class)) {
            return null;
        }

        /** @var LegacyConfig $legacy */
        $legacy = config(LegacyConfig::class);
        if (method_exists($legacy, 'hasItem') && $legacy->hasItem($key)) {
            return $legacy->getItem($key);
        }

        return null;
    }

    private function logLegacyHit(string $key): void
    {
        if ($this->isFalseyEnv('bridge.log_reads', true)) {
            return;
        }

        if (isset($this->loggedLegacyHits[$key])) {
            return;
        }

        $this->loggedLegacyHits[$key] = true;
        if (function_exists('log_message')) {
            log_message('debug', '[LegacyConfig] key resolved via Config\\Legacy: {key}', ['key' => $key]);
        }
    }

    private function logUnknownKey(string $key): void
    {
        if (!$this->isDebugMode()) {
            return;
        }

        if ($this->isFalseyEnv('bridge.log_unknown_keys', true)) {
            return;
        }

        if (isset($this->loggedUnknownKeys[$key])) {
            return;
        }

        $this->loggedUnknownKeys[$key] = true;
        if (function_exists('log_message')) {
            log_message('debug', '[LegacyConfig] unknown key requested: {key}', ['key' => $key]);
        }
    }

    private function logMissingRequiredKeys(): void
    {
        if ($this->isFalseyEnv('bridge.log_required_missing', true)) {
            return;
        }

        $required = $this->requiredKeys();
        if ($required === []) {
            return;
        }

        $missing = [];
        foreach ($required as $key) {
            if (!$this->isKnownKey($key)) {
                $missing[] = $key;
            }
        }

        if ($missing === [] || !function_exists('log_message')) {
            return;
        }

        log_message(
            'warning',
            '[LegacyConfig] required key(s) not mapped: {keys}',
            ['keys' => implode(', ', $missing)]
        );
    }

    /**
     * @return list<string>
     */
    private function requiredKeys(): array
    {
        $raw = env('bridge.required_keys', '');
        if (!is_string($raw) || trim($raw) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $raw)), static fn ($value) => $value !== ''));
    }

    private function isKnownKey(string $key): bool
    {
        if ($this->hasLegacyKey($key)) {
            return true;
        }

        if (array_key_exists($key, $this->items)) {
            return true;
        }

        if ($this->hasEnvCandidate($key)) {
            return true;
        }

        return $this->isCi4MappedKey($key);
    }

    private function hasLegacyKey(string $key): bool
    {
        if (!function_exists('config') || !class_exists(LegacyConfig::class)) {
            return false;
        }

        /** @var LegacyConfig $legacy */
        $legacy = config(LegacyConfig::class);
        return method_exists($legacy, 'hasItem') && $legacy->hasItem($key);
    }

    private function hasEnvCandidate(string $key): bool
    {
        $candidates = array_unique([
            $key,
            str_replace('.', '_', $key),
            strtoupper($key),
            strtoupper(str_replace('.', '_', $key)),
        ]);

        foreach ($candidates as $candidate) {
            if (getenv($candidate) !== false || isset($_ENV[$candidate])) {
                return true;
            }
        }

        return false;
    }

    private function isCi4MappedKey(string $key): bool
    {
        if ($key === 'base_url' || $key === 'charset' || $key === 'csrf_protection') {
            return true;
        }

        if (str_starts_with($key, 'cookie_')) {
            return in_array($key, ['cookie_domain', 'cookie_path', 'cookie_secure'], true);
        }

        if (str_starts_with($key, 'sess_')) {
            return in_array(
                $key,
                [
                    'sess_cookie_name',
                    'sess_expiration',
                    'sess_save_path',
                    'sess_match_ip',
                    'sess_time_to_update',
                    'sess_regenerate_destroy',
                ],
                true
            );
        }

        return false;
    }

    private function isDebugMode(): bool
    {
        $override = env('bridge.debug');
        if (is_bool($override)) {
            return $override;
        }
        if (is_string($override) && trim($override) !== '') {
            $normalized = strtolower(trim($override));
            if (in_array($normalized, ['1', 'true', 'on', 'yes'], true)) {
                return true;
            }
            if (in_array($normalized, ['0', 'false', 'off', 'no'], true)) {
                return false;
            }
        }

        $environment = env('CI_ENVIRONMENT', 'production');
        return is_string($environment) && strtolower(trim($environment)) !== 'production';
    }

    private function isFalseyEnv(string $key, bool $default): bool
    {
        $value = env($key, $default);
        if (is_bool($value)) {
            return $value === false;
        }

        if (is_string($value)) {
            return in_array(strtolower(trim($value)), ['0', 'false', 'off', 'no'], true);
        }

        return $value === 0 || $value === null;
    }

    public function site_url(string $uri = ''): string
    {
        return site_url($uri);
    }

    public function base_url(string $uri = ''): string
    {
        return base_url($uri);
    }

    public function set_item(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @return array<string,mixed>|null
     */
    private function loadLegacyFile(string $file): ?array
    {
        // Keep CI3 fallback only for autoload while that migration is pending.
        if ($file !== 'autoload') {
            return null;
        }

        $paths = [
            defined('APPPATH') ? APPPATH . 'config/' . $file . '.php' : null,
            defined('ROOTPATH') ? ROOTPATH . 'application/config/' . $file . '.php' : null,
            defined('ROOTPATH') ? ROOTPATH . '../application/config/' . $file . '.php' : null,
            defined('APPPATH') ? APPPATH . 'Config/' . $file . '.php' : null,
            defined('APPPATH') ? APPPATH . 'Config/' . ucfirst($file) . '.php' : null,
        ];

        foreach ($paths as $path) {
            if ($path === null || !is_file($path)) {
                continue;
            }

            $config = [];
            $autoload = [];
            include $path;
            if (is_array($config) && $config !== []) {
                return $config;
            }
            if (is_array($autoload) && $autoload !== []) {
                return $autoload;
            }
            return null;
        }

        return null;
    }

    /**
     * @return array<string,mixed>|null
     */
    private function loadMappedCi4File(string $file): ?array
    {
        if ($file === 'autoload') {
            return $this->buildAutoloadPayload();
        }

        if (function_exists('config') && class_exists(LegacyConfig::class)) {
            /** @var LegacyConfig $legacy */
            $legacy = config(LegacyConfig::class);
            if (method_exists($legacy, 'getFilePayload')) {
                return $legacy->getFilePayload($file);
            }
        }

        return null;
    }

    /**
     * Build a CI3-like autoload payload from CI4 Autoload config.
     *
     * @return array<string,mixed>
     */
    private function buildAutoloadPayload(): array
    {
        $helpers = [];

        if (function_exists('config') && class_exists(Ci4AutoloadConfig::class)) {
            /** @var Ci4AutoloadConfig $autoload */
            $autoload = config(Ci4AutoloadConfig::class);
            if (isset($autoload->helpers) && is_array($autoload->helpers)) {
                $helpers = array_values($autoload->helpers);
            }
        }

        return [
            'packages' => [],
            'libraries' => [],
            'drivers' => [],
            'helper' => $helpers,
            // Compatibility alias when legacy code expects plural naming.
            'helpers' => $helpers,
            'config' => [],
            'language' => [],
            'model' => [],
        ];
    }

    private function readEnv(string $key)
    {
        $candidates = array_unique([
            $key,
            str_replace('.', '_', $key),
            strtoupper($key),
            strtoupper(str_replace('.', '_', $key)),
        ]);

        foreach ($candidates as $candidate) {
            $value = getenv($candidate);
            if ($value === false && isset($_ENV[$candidate])) {
                $value = $_ENV[$candidate];
            }

            if ($value === false) {
                continue;
            }

            if (is_string($value)) {
                $normalized = strtolower(trim($value));
                if ($normalized === 'true') {
                    return true;
                }
                if ($normalized === 'false') {
                    return false;
                }
                if ($normalized === 'null') {
                    return null;
                }
            }

            return $value;
        }

        return null;
    }

    private function readCi4Config(string $key)
    {
        if (!function_exists('config')) {
            return null;
        }

        if ($key === 'base_url' || $key === 'charset') {
            $app = config(AppConfig::class);
            if ($key === 'base_url') {
                return $app->baseURL ?? null;
            }
            return $app->charset ?? null;
        }

        if (str_starts_with($key, 'cookie_')) {
            $cookie = config(CookieConfig::class);
            $map = [
                'cookie_domain' => 'domain',
                'cookie_path' => 'path',
                'cookie_secure' => 'secure',
            ];
            $prop = $map[$key] ?? null;
            return $prop !== null ? ($cookie->{$prop} ?? null) : null;
        }

        if ($key === 'csrf_protection') {
            $security = config(SecurityConfig::class);
            return !empty($security->csrfProtection);
        }

        if (str_starts_with($key, 'sess_')) {
            $session = config(SessionConfig::class);
            $map = [
                'sess_cookie_name' => 'cookieName',
                'sess_expiration' => 'expiration',
                'sess_save_path' => 'savePath',
                'sess_match_ip' => 'matchIP',
                'sess_time_to_update' => 'timeToUpdate',
                'sess_regenerate_destroy' => 'regenerateDestroy',
            ];
            $prop = $map[$key] ?? null;
            return $prop !== null ? ($session->{$prop} ?? null) : null;
        }

        return null;
    }
}
