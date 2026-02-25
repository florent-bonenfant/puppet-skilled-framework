<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

class SessionProxy
{
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function userdata(?string $key = null)
    {
        if ($key === null) {
            return $this->session->get();
        }

        return $this->session->get($key);
    }

    public function set_userdata($data, $value = null): void
    {
        if (is_array($data)) {
            $this->session->set($data);
            return;
        }

        $this->session->set($data, $value);
    }

    public function all_userdata(): array
    {
        return $this->session->get();
    }

    public function mark_as_flash(string $key): void
    {
        $this->session->markAsFlashdata($key);
    }

    public function has_userdata(string $key): bool
    {
        return $this->session->has($key);
    }

    public function sess_destroy(): void
    {
        $this->session->destroy();
    }

    public function __get(string $name)
    {
        return $this->session->get($name);
    }

    public function __set(string $name, $value): void
    {
        $this->session->set($name, $value);
    }
}
