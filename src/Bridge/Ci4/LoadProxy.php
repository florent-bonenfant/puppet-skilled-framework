<?php

namespace Globalis\PuppetSkilled\Bridge\Ci4;

use Globalis\PuppetSkilled\Core\Application;

class LoadProxy
{
    private LegacyBridge $bridge;

    public function __construct(LegacyBridge $bridge)
    {
        $this->bridge = $bridge;
    }

    public function helper($helpers): self
    {
        $helpers = is_array($helpers) ? $helpers : [$helpers];
        foreach ($helpers as $helperName) {
            $helperName = (string) $helperName;
            $base = preg_replace('/_helper$/', '', $helperName);

            $legacyPaths = [
                defined('APPPATH') ? APPPATH . 'helpers/APP_' . $base . '_helper.php' : null,
                defined('APPPATH') ? APPPATH . 'Helpers/APP_' . $base . '_helper.php' : null,
                defined('ROOTPATH') ? ROOTPATH . '../application/helpers/APP_' . $base . '_helper.php' : null,
                defined('ROOTPATH') ? ROOTPATH . 'application/helpers/APP_' . $base . '_helper.php' : null,
            ];

            foreach ($legacyPaths as $path) {
                if ($path && is_file($path)) {
                    require_once $path;
                }
            }

            helper($base);
        }
        return $this;
    }

    public function language(string $file): self
    {
        $this->bridge->lang->load($file);
        return $this;
    }

    public function library(string $library, $params = null, ?string $alias = null): self
    {
        $name = strtolower($library);
        $service = null;

        if ($name === 'session' || $name === 'session/api_session' || $name === 'session/app_session') {
            $service = $this->bridge->session;
        } elseif ($name === 'email') {
            $service = service('email');
        } elseif ($name === 'user_agent') {
            $service = new UserAgentProxy($this->bridge->request);
        }

        if ($service === null) {
            $class = Application::className($library, 'Libraries');
            if (class_exists($class)) {
                $service = $params === null ? new $class() : new $class($params);
            }
        }

        if ($service !== null) {
            $property = $alias ?: basename(str_replace('\\', '/', $library));
            $property = lcfirst($property);
            $this->bridge->set($property, $service);

            // CI3 compatibility: `$this->load->library('user_agent')` exposes `$this->agent`.
            if ($name === 'user_agent') {
                $this->bridge->set('agent', $service);
            }
        }

        return $this;
    }

    public function config(string $file, bool $useSections = false): self
    {
        $this->bridge->config->load($file, $useSections);
        return $this;
    }

    public function database($params = '', bool $return = false)
    {
        $db = db_connect(is_string($params) ? ($params !== '' ? $params : null) : null);
        $this->bridge->set('db', $db);

        if ($return) {
            return $db;
        }

        return $this;
    }

    public function view(string $view, array $data = [], bool $return = false)
    {
        $content = view($view, $data);
        if ($return) {
            return $content;
        }

        $this->bridge->response->setBody($content);
        return $this;
    }
}
