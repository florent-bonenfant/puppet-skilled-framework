<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\RequestInterface;

class InputProxy
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function post(?string $key = null, $filter = null)
    {
        if (!method_exists($this->request, 'getPost')) {
            return null;
        }
        return $this->request->getPost($key, $filter);
    }

    public function get(?string $key = null, $filter = null)
    {
        if (!method_exists($this->request, 'getGet')) {
            return null;
        }
        return $this->request->getGet($key, $filter);
    }

    public function method(bool $upper = false): string
    {
        $method = $this->request->getMethod();
        return $upper ? strtoupper($method) : strtolower($method);
    }

    public function is_ajax_request(): bool
    {
        if (!method_exists($this->request, 'isAJAX')) {
            return false;
        }
        return $this->request->isAJAX();
    }

    public function raw_input_stream(): string
    {
        if (!method_exists($this->request, 'getBody')) {
            return '';
        }
        return (string) $this->request->getBody();
    }
}
