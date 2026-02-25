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
}
