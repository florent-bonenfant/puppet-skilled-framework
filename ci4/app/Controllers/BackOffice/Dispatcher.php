<?php

namespace App\Controllers\BackOffice;

class Dispatcher extends \App\Controllers\BaseController
{
    public function handle(...$pathParts)
    {
        $path = implode('/', array_map(static fn ($part): string => trim((string) $part, '/'), $pathParts));
        if ($path === '' && function_exists('service')) {
            $uri = (string) service('uri')->getPath();
            if (str_starts_with($uri, 'backoffice/')) {
                $path = substr($uri, strlen('backoffice/'));
            } elseif ($uri === 'backoffice') {
                $path = '';
            }
        }

        $path = trim($path, '/');
        $segments = $path === '' ? [] : array_values(array_filter(explode('/', $path), static fn ($s) => $s !== ''));

        [$file, $class, $method, $params] = $this->resolveController($segments);

        if (!is_file($file)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('backoffice/' . $path);
        }

        require_once $file;

        if (!class_exists($class)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('backoffice/' . $path);
        }

        $controller = new $class();

        if (method_exists($controller, '_remap')) {
            return $controller->_remap($method, $params);
        }

        if (!method_exists($controller, $method)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('backoffice/' . $path);
        }

        return call_user_func_array([$controller, $method], $params);
    }

    /**
     * @param array<int,string> $segments
     * @return array{0:string,1:string,2:string,3:array<int,string>}
     */
    private function resolveController(array $segments): array
    {
        $base = realpath(ROOTPATH . 'app/Controllers/BackOffice');
        if ($base === false) {
            throw new \RuntimeException('BackOffice controllers directory not found.');
        }

        if ($segments === []) {
            $segments = ['customer', 'index'];
        }

        for ($i = count($segments); $i >= 1; $i--) {
            $controllerParts = array_slice($segments, 0, $i);
            $method = $segments[$i] ?? 'index';
            $params = array_slice($segments, $i + 1);

            $resolved = $this->resolvePath($base, $controllerParts);
            if ($resolved === null) {
                continue;
            }

            [$file, $class] = $resolved;
            return [$file, $class, $method, $params];
        }

        $resolved = $this->resolvePath($base, [$segments[0]]);
        if ($resolved !== null) {
            [$file, $class] = $resolved;
            return [$file, $class, 'index', array_slice($segments, 1)];
        }

        $first = $segments[0] ?? 'Customer';
        $file = $base . '/' . ucfirst($first) . '.php';
        $class = 'App\\Controllers\\BackOffice\\' . ucfirst($first);
        return [$file, $class, 'index', array_slice($segments, 1)];
    }

    /**
     * @param array<int,string> $parts
     * @return array{0:string,1:string}|null
     */
    private function resolvePath(string $base, array $parts): ?array
    {
        $dir = $base;
        $ns = ['App', 'Controllers', 'BackOffice'];

        $last = array_pop($parts);
        foreach ($parts as $part) {
            $matched = $this->matchEntry($dir, $part, true);
            if ($matched === null) {
                return null;
            }
            $dir .= '/' . $matched;
            $ns[] = ucfirst($matched);
        }

        $matchedFile = $this->matchEntry($dir, (string) $last, false);
        if ($matchedFile === null) {
            return null;
        }

        $file = $dir . '/' . $matchedFile;
        $className = pathinfo($matchedFile, PATHINFO_FILENAME);
        $class = implode('\\', $ns) . '\\' . $className;

        return [$file, $class];
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
