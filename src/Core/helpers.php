<?php
if (!function_exists('app')) {
    /**
     * Get the app instance.
     *
     * @return \Globalis\PuppetSkilled\Core\Application
     */
    function app()
    {
        return \Globalis\PuppetSkilled\Core\Application::getInstance();
    }
}

if (!function_exists('get_instance')) {
    /**
     * CI3 compatibility helper.
     *
     * @return mixed
     */
    function get_instance()
    {
        return app()->CI;
    }
}

if (!function_exists('config_item')) {
    /**
     * CI3 compatibility for config_item() in CI4.
     *
     * @param string $item
     * @return mixed|null
     */
    function config_item($item)
    {
        $app = app();
        if ($app && $app->config) {
            return $app->config->item($item);
        }
        return null;
    }
}

if (!function_exists('is_cli')) {
    function is_cli()
    {
        return PHP_SAPI === 'cli' || defined('STDIN');
    }
}

if (!function_exists('redirect')) {
    /**
     * CI3-like redirect helper.
     *
     * @param string $uri
     * @param string $method
     * @param int|null $code
     * @return never
     */
    function redirect($uri = '', $method = 'auto', $code = null)
    {
        $target = is_string($uri) ? $uri : '';
        if (function_exists('site_url') && $target !== '' && !preg_match('#^https?://#i', $target)) {
            $target = site_url($target);
        }

        $response = service('response');
        $response->redirect($target, 'auto', $code)->send();
        exit;
    }
}

if (!function_exists('lang')) {
    /**
     * CI3/CI4 compatible lang() helper.
     *
     * @param array<array-key, string|int|float> $args
     * @return array|string
     */
    function lang(string $line, array $args = [], ?string $locale = null)
    {
        // Legacy CI3 behavior for plain keys (no file prefix)
        if (strpos($line, '.') === false && function_exists('get_instance')) {
            try {
                $ci = get_instance();
                if ($ci && isset($ci->lang) && method_exists($ci->lang, 'line')) {
                    $legacy = $ci->lang->line($line);
                    if ($legacy !== '' && $legacy !== false && $legacy !== null) {
                        return $legacy;
                    }
                }
            } catch (\Throwable $e) {
                // Ignore and fallback to CI4 behavior below.
            }
        }

        if (!function_exists('service')) {
            return $line;
        }

        $language = service('language');
        if ($locale !== null) {
            $language->setLocale($locale);
        }

        return $language->getLine($line, $args);
    }
}

if (!function_exists('get_mimes')) {
    /**
     * CI3-compatible global get_mimes() used by legacy Upload library.
     *
     * @return array<string, string|array<int, string>>
     */
    function get_mimes(): array
    {
        static $mimes;

        if (is_array($mimes)) {
            return $mimes;
        }

        if (class_exists(\Config\Mimes::class) && isset(\Config\Mimes::$mimes) && is_array(\Config\Mimes::$mimes)) {
            $mimes = \Config\Mimes::$mimes;
            return $mimes;
        }

        $mimes = [];
        return $mimes;
    }
}

if (!function_exists('bootstrap_api_session_token')) {
    /**
     * CI3-style API auth bridge: map Authorization token to session cookie
     * before CI4 session initialization.
     */
    function bootstrap_api_session_token(): void
    {
        if (PHP_SAPI === 'cli') {
            return;
        }

        $requestUri = (string) ($_SERVER['REQUEST_URI'] ?? '');
        $path = strtolower(trim((string) parse_url($requestUri, PHP_URL_PATH), '/'));
        $isApiRequest = $path !== '' && preg_match('#(^|/)webservice(/|$)#', $path) === 1;
        if (!$isApiRequest) {
            return;
        }

        $header = null;
        $serverCandidates = [
            'HTTP_AUTHORIZATION',
            'REDIRECT_HTTP_AUTHORIZATION',
            'REDIRECT_REDIRECT_HTTP_AUTHORIZATION',
            'Authorization',
            'AUTHORIZATION',
        ];

        foreach ($serverCandidates as $key) {
            if (!empty($_SERVER[$key])) {
                $header = trim((string) $_SERVER[$key]);
                break;
            }
        }

        if (($header === null || $header === '') && function_exists('getallheaders')) {
            $headers = getallheaders();
            foreach (['Authorization', 'AUTHORIZATION'] as $key) {
                if (!empty($headers[$key])) {
                    $header = trim((string) $headers[$key]);
                    break;
                }
            }
        }

        if ($header === null || $header === '') {
            return;
        }

        $token = preg_match('/^Bearer\s+(.+)$/i', $header, $matches) === 1
            ? trim($matches[1])
            : trim($header);

        // Legacy session IDs are hexadecimal; reject clearly invalid tokens.
        if ($token === '' || preg_match('/^[a-f0-9]{32,128}$/i', $token) !== 1) {
            return;
        }

        $cookieNames = array_unique(array_filter([
            (string) (getenv('session.cookieName') ?: ''),
            $_ENV['session.cookieName'] ?? null,
            'dilip',
            'ci_session',
        ]));

        foreach ($cookieNames as $cookieName) {
            $_COOKIE[(string) $cookieName] = $token;
        }
    }
}

if (!function_exists('show_404')) {
    /**
     * CI3-like 404 helper.
     *
     * @param string $page
     * @param bool $logError
     * @return never
     */
    function show_404($page = '', $logError = true)
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($page ?: null);
    }
}

if (!function_exists('_stringify_attributes')) {
    /**
     * CI3-like attributes stringify helper.
     *
     * @param mixed $attributes
     * @param bool $js
     * @return string
     */
    function _stringify_attributes($attributes, $js = false)
    {
        if (empty($attributes)) {
            return '';
        }

        if (is_string($attributes)) {
            return ' ' . $attributes;
        }

        if (!is_array($attributes)) {
            return '';
        }

        $atts = '';
        foreach ($attributes as $key => $val) {
            $atts .= ($js ? $key . '=' . '"' . addslashes((string) $val) . '"' : ' ' . $key . '="' . html_escape($val) . '"');
        }

        return $atts;
    }
}

if (!function_exists('html_escape')) {
    /**
     * CI3 compatibility helper backed by CI4 esc().
     *
     * @param mixed $var
     * @param bool $double_encode
     * @return mixed
     */
    function html_escape($var, $double_encode = true)
    {
        if (is_array($var)) {
            return array_map(static function ($value) use ($double_encode) {
                return html_escape($value, $double_encode);
            }, $var);
        }

        if (is_object($var)) {
            return $var;
        }

        if (!is_scalar($var) && $var !== null) {
            return $var;
        }

        if (function_exists('esc')) {
            return esc((string) $var, 'html');
        }

        return htmlspecialchars((string) $var, ENT_QUOTES, 'UTF-8', (bool) $double_encode);
    }
}

if (!function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object  $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('class_uses_recursive')) {
    /**
     * Returns all traits used by a class, its subclasses and trait of their traits.
     *
     * @param  object|string  $class
     * @return array
     */
    function class_uses_recursive($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        $results = [];
        foreach (array_merge([$class => $class], class_parents($class)) as $class) {
            $results += trait_uses_recursive($class);
        }
        return array_unique($results);
    }
}

if (!function_exists('trait_uses_recursive')) {
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param  string  $trait
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait);
        foreach ($traits as $trait) {
            $traits += trait_uses_recursive($trait);
        }
        return $traits;
    }
}

if (!function_exists('array_get')) {
    function array_get(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        return $array;
    }
}

if (!function_exists('array_flatten')) {
    function array_flatten($array, $depth = INF)
    {
        return array_reduce($array, function ($result, $item) use ($depth) {
            if (!is_array($item)) {
                return array_merge($result, [$item]);
            } elseif ($depth === 1) {
                return array_merge($result, array_values($item));
            } else {
                return array_merge($result, array_flatten($item, $depth - 1));
            }
        }, []);
    }
}

if (!function_exists('array_set')) {
    function array_set($array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $keys = explode('.', $key);
        $baseArray = &$array;
        while (count($keys) > 1) {
            $key = array_shift($keys);
            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $baseArray;
    }
}

if (!function_exists('array_is_assoc')) {
    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @param  array  $array
     * @return bool
     */
    function array_is_assoc(array $array)
    {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }
}

if (!function_exists('array_pluck')) {
    function array_pluck($array, $value, $key = null)
    {
        $results = [];

        $value = is_string($value) ? explode('.', $value) : $value;
        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);
            // If the key is "null", we will just append the value to the array and keep
            // looping. Otherwise we will key the array using the value of the key we
            // received from the developer. Then we'll return the final array form.
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = data_get($item, $key);
                $results[$itemKey] = $itemValue;
            }
        }
        return $results;
    }
}
if (!function_exists('array_collapse')) {
    function array_collapse($array)
    {
        $results = [];
        foreach ($array as $values) {
            if (!is_array($values)) {
                continue;
            }
            $results = array_merge($results, $values);
        }
        return $results;
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed   $target
     * @param  string|array  $key
     * @param  mixed   $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }
        $key = is_array($key) ? $key : explode('.', $key);
        while (! is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if (!is_array($target)) {
                    return $default;
                }
                $result = array_pluck($target, $key);
                return in_array('*', $key) ? array_collapse($result) : $result;
            }
            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return $default;
            }
        }
        return $target;
    }
}

if (!function_exists('str_snake')) {
    function str_snake($value, $delimiter = '_')
    {
        $value = preg_replace('/\s+/u', '', $value);
        return mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
    }
}

if (!function_exists('str_studly')) {
    function str_studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return str_replace(' ', '', $value);
    }
}


if (!function_exists('str_camel')) {
    /**
     * Convert a value to camel case.
     *
     * @param  string  $value
     * @return string
     */
    function str_camel($value)
    {
        return lcfirst(str_studly($value));
    }
}
