<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\IncomingRequest;

class InputProxy
{
    private IncomingRequest $request;

    public function __construct(IncomingRequest $request)
    {
        $this->request = $request;
    }

    public function post(?string $key = null, $filter = null)
    {
        return $this->request->getPost($key, $filter);
    }

    public function get(?string $key = null, $filter = null)
    {
        return $this->request->getGet($key, $filter);
    }

    public function method(bool $upper = false): string
    {
        $method = $this->request->getMethod();
        return $upper ? strtoupper($method) : strtolower($method);
    }

    public function is_ajax_request(): bool
    {
        return $this->request->isAJAX();
    }

    public function raw_input_stream(): string
    {
        return (string) $this->request->getBody();
    }
}
