<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

class LegacyBridge
{
    public LoadProxy $load;
    public InputProxy $input;
    public OutputProxy $output;
    public RouterProxy $router;
    public SessionProxy $session;
    public ConfigProxy $config;
    public SecurityProxy $security;
    public LangProxy $lang;
    public $request;
    public $response;
    public UriProxy $uri;

    /**
     * @var array<string,mixed>
     */
    private array $services = [];

    public function __construct()
    {
        $this->request = service('request');
        $this->response = service('response');
        $this->uri = new UriProxy($this->request);

        $this->input = new InputProxy($this->request);
        $this->output = new OutputProxy($this->response);
        $this->router = new RouterProxy($this->request, service('router'));
        $this->session = new SessionProxy(service('session'));
        $this->config = new ConfigProxy();
        $this->security = new SecurityProxy();
        $this->lang = new LangProxy();
        $this->load = new LoadProxy($this);

        $this->set('request', $this->request);
        $this->set('response', $this->response);
        $this->set('uri', $this->uri);
        $this->set('input', $this->input);
        $this->set('output', $this->output);
        $this->set('router', $this->router);
        $this->set('session', $this->session);
        $this->set('config', $this->config);
        $this->set('security', $this->security);
        $this->set('lang', $this->lang);
        $this->set('load', $this->load);

        // Lazy bootstrap: initialize app services once the CI4 runtime is ready.
        if (defined('APPPATH')) {
            $bootstrapFile = APPPATH . 'Libraries/PuppetSkilledCi4Bootstrap.php';
            if (is_file($bootstrapFile)) {
                require_once $bootstrapFile;
                if (class_exists(\App\Libraries\PuppetSkilledCi4Bootstrap::class)) {
                    \App\Libraries\PuppetSkilledCi4Bootstrap::boot();
                }
            }
        }
    }

    public function set(string $name, $value): void
    {
        $this->services[$name] = $value;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    public function __get(string $name)
    {
        return $this->services[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }
}
