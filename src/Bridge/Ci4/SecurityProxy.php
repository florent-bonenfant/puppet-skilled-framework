<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

class SecurityProxy
{
    public function get_random_bytes(int $length): string
    {
        return random_bytes($length);
    }

    public function get_csrf_hash(): string
    {
        $security = service('security');
        return method_exists($security, 'getHash') ? $security->getHash() : '';
    }

    public function get_csrf_token_name(): string
    {
        $security = service('security');
        return method_exists($security, 'getTokenName') ? $security->getTokenName() : 'csrf_token';
    }

    public function csrf_verify(): void
    {
        // CI4 CSRF validation is filter-driven. Keep compatibility no-op.
    }

    /**
     * CI3 compatibility for Security::sanitize_filename().
     */
    public function sanitize_filename(string $str, bool $relativePath = false): string
    {
        $security = service('security');
        if (method_exists($security, 'sanitizeFilename')) {
            /** @phpstan-ignore-next-line */
            return (string) $security->sanitizeFilename($str, $relativePath);
        }

        // Conservative fallback if security service API differs.
        $cleaned = preg_replace('/[^A-Za-z0-9._\-\/\\\\]/', '', $str);
        if (!is_string($cleaned)) {
            return '';
        }
        if (!$relativePath) {
            $cleaned = str_replace(['../', '..\\'], '', $cleaned);
        }
        return $cleaned;
    }
}
