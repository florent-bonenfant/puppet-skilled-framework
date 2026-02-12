<?php

namespace App\Controllers;

use Globalis\PuppetSkilled\Core\Application;

class LegacyDispatcher extends BaseController
{
    public function handle(string $path = '')
    {
        $path = trim($path, '/');
        $segments = $path === '' ? [] : array_values(array_filter(explode('/', $path), static fn ($s) => $s !== ''));

        [$file, $class, $method, $params, $directory] = $this->resolveController($segments);

        if (!is_file($file)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($path);
        }

        require_once $file;

        if (!class_exists($class)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($path);
        }

        $controller = new $class();

        $app = Application::getInstance();
        if ($app->CI && isset($app->CI->router)) {
            $app->CI->router->class = strtolower($class);
            $app->CI->router->method = strtolower($method);
            $app->CI->router->directory = $directory;
            if (isset($app->CI->uri)) {
                $app->CI->uri->segments = $segments;
                $app->CI->uri->rsegments = [strtolower($class), strtolower($method)];
                $app->CI->uri->uri_string = implode('/', $segments);
            }
        }

        if (method_exists($controller, '_remap')) {
            return $controller->_remap($method, $params);
        }

        if (!method_exists($controller, $method)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($path);
        }

        return call_user_func_array([$controller, $method], $params);
    }

    /**
     * @param array<int,string> $segments
     * @return array{0:string,1:string,2:string,3:array<int,string>,4:string}
     */
    private function resolveController(array $segments): array
    {
        $base = realpath(ROOTPATH . '../application/controllers');
        if ($base === false) {
            throw \RuntimeException('Legacy controllers directory not found.');
        }

        if ($segments === []) {
            $segments = ['authentication', 'login'];
        }

        for ($i = count($segments); $i >= 1; $i--) {
            $controllerParts = array_slice($segments, 0, $i);
            $method = $segments[$i] ?? 'index';
            $params = array_slice($segments, $i + 1);

            $resolved = $this->resolvePath($base, $controllerParts);
            if ($resolved === null) {
                continue;
            }

            [$file, $class, $directory] = $resolved;
            return [$file, $class, $method, $params, $directory];
        }

        // fallback: first segment as controller, default method index
        $resolved = $this->resolvePath($base, [$segments[0]]);
        if ($resolved !== null) {
            [$file, $class, $directory] = $resolved;
            return [$file, $class, 'index', array_slice($segments, 1), $directory];
        }

        $first = $segments[0] ?? 'home';
        return [$base . '/' . $first . '.php', ucfirst($first), 'index', array_slice($segments, 1), ''];
    }

    /**
     * @param array<int,string> $parts
     * @return array{0:string,1:string,2:string}|null
     */
    private function resolvePath(string $base, array $parts): ?array
    {
        $dir = $base;
        $directory = [];

        // directory parts + final controller file part
        $last = array_pop($parts);
        foreach ($parts as $part) {
            $matched = $this->matchEntry($dir, $part, true);
            if ($matched === null) {
                return null;
            }
            $dir .= '/' . $matched;
            $directory[] = $matched;
        }

        $matchedFile = $this->matchEntry($dir, (string) $last, false);
        if ($matchedFile === null) {
            return null;
        }

        $file = $dir . '/' . $matchedFile;
        $class = pathinfo($matchedFile, PATHINFO_FILENAME);
        $directoryStr = empty($directory) ? '' : strtolower(implode('/', $directory)) . '/';

        return [$file, $class, $directoryStr];
    }

    private function matchEntry(string $dir, string $segment, bool $directory): ?string
    {
        if (!is_dir($dir)) {
            return null;
        }

        $target = strtolower($segment);
        $entries = scandir($dir) ?: [];

        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $full = $dir . '/' . $entry;
            if ($directory && !is_dir($full)) {
                continue;
            }
            if (!$directory && !is_file($full)) {
                continue;
            }

            $name = $directory ? $entry : pathinfo($entry, PATHINFO_FILENAME);
            if (strtolower($name) === $target) {
                return $entry;
            }
        }

        return null;
    }
}
