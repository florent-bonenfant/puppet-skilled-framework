<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\IncomingRequest;

class RouterProxy
{
    public string $class = '';
    public string $method = '';
    public string $directory = '';
    public string $default_controller = 'home';

    private IncomingRequest $request;

    public function __construct(IncomingRequest $request, $router = null)
    {
        $this->request = $request;

        $controller = is_object($router) && method_exists($router, 'controllerName')
            ? (string) $router->controllerName()
            : '';

        $method = is_object($router) && method_exists($router, 'methodName')
            ? (string) $router->methodName()
            : '';

        if ($controller !== '') {
            $parts = explode('\\', trim($controller, '\\'));
            $this->class = strtolower((string) end($parts));
            array_pop($parts);
            $this->directory = empty($parts) ? '' : strtolower(implode('/', $parts)) . '/';
        } else {
            $segments = $request->getUri()->getSegments();
            $this->class = strtolower($segments[0] ?? 'home');
            $this->directory = '';
        }

        $this->method = strtolower($method !== '' ? $method : ($request->getUri()->getSegments()[1] ?? 'index'));
    }

    public function fetch_method(): string
    {
        return $this->method;
    }
}
