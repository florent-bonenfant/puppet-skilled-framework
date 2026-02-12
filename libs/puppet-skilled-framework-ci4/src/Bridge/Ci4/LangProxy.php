<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

class LangProxy
{
    private string $subdirectory = '';

    public function addSubdirectory(string $path): void
    {
        $this->subdirectory = trim($path, '/');
    }

    public function line(string $key): string
    {
        return lang($key);
    }

    public function subdirectory(): string
    {
        return $this->subdirectory;
    }
}
