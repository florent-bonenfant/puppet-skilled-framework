<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use CodeIgniter\HTTP\ResponseInterface;

class OutputProxy
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function set_header(string $header)
    {
        $parts = explode(':', $header, 2);
        if (count($parts) === 2) {
            $this->response->setHeader(trim($parts[0]), trim($parts[1]));
        }

        return $this;
    }

    public function set_content_type(string $mime, ?string $charset = null)
    {
        $this->response->setContentType($mime, $charset ?: 'UTF-8');
        return $this;
    }

    public function set_status_header(int $code)
    {
        $this->response->setStatusCode($code);
        return $this;
    }

    public function set_output(string $output)
    {
        $this->response->setBody($output);
        return $this;
    }

    public function enable_profiler(bool $enabled = true)
    {
        return $this;
    }

    public function _display(): void
    {
        // Legacy webservices call _display() and then exit immediately.
        // In CI4 bridge mode we must send the response here, otherwise the body
        // is never flushed.
        $this->response->send();
    }
}
