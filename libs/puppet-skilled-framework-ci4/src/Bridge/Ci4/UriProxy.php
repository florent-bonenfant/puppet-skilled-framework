<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\IncomingRequest;

class UriProxy
{
    /**
     * @var array<int,string>
     */
    public array $segments = [];

    /**
     * @var array<int,string>
     */
    public array $rsegments = [];
    public string $uri_string = '';

    private IncomingRequest $request;

    public function __construct(IncomingRequest $request)
    {
        $this->request = $request;
        $this->segments = $request->getUri()->getSegments();
        $this->uri_string = trim($request->getUri()->getPath(), '/');

        $controller = $this->segments[0] ?? 'home';
        $method = $this->segments[1] ?? 'index';
        $this->rsegments = [$controller, $method];
    }

    public function uri_string(): string
    {
        return $this->uri_string;
    }
}
