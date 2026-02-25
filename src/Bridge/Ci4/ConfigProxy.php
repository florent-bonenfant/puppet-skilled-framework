<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

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

    public function load(string $file, bool $useSections = false): bool
    {
        if (isset($this->loadedFiles[$file])) {
            return true;
        }

        $loaded = $this->loadLegacyFile($file);
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
            if (isset($this->sections[$section]) && array_key_exists($key, $this->sections[$section])) {
                return $this->sections[$section][$key];
            }
            if (isset($this->items[$section]) && is_array($this->items[$section]) && array_key_exists($key, $this->items[$section])) {
                return $this->items[$section][$key];
            }
        }

        return $this->items[$key] ?? null;
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
}
