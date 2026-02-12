<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\IncomingRequest;

class UserAgentProxy
{
    private IncomingRequest $request;

    public function __construct(IncomingRequest $request)
    {
        $this->request = $request;
    }

    public function referrer(): string
    {
        $value = $this->request->getHeaderLine('referer');
        return $value ?: '';
    }

    public function languages(): array
    {
        $accept = $this->request->getHeaderLine('accept-language');
        if ($accept === '') {
            return [];
        }

        $langs = [];
        foreach (explode(',', $accept) as $part) {
            $lang = strtolower(trim(explode(';', $part)[0]));
            if ($lang !== '') {
                $langs[] = $lang;
                if (str_contains($lang, '-')) {
                    $langs[] = explode('-', $lang)[0];
                }
            }
        }

        return array_values(array_unique($langs));
    }
}
