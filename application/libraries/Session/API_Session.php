<?php

defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Session\APP_CI_Session;
use \Globalis\PuppetSkilled\Session\APP_CI_SessionWrapper;

require BASEPATH . 'libraries' . DIRECTORY_SEPARATOR . 'Session' . DIRECTORY_SEPARATOR . 'Session.php';

/**
 * Surcharge de la classe session pour la gestion des session par API
 */
class API_Session extends APP_CI_Session
{
    /**
     * Class constructor
     *
     * @param   array   $params Configuration parameters
     * @return  void
     */
    public function __construct(array $params = array())
    {
        // No sessions under CLI
        if (is_cli()) {
            log_message('debug', 'Session: Initialization under CLI aborted.');
            return;
        } elseif ((bool) ini_get('session.auto_start')) {
            log_message('error', 'Session: session.auto_start is enabled in php.ini. Aborting.');
            return;
        } elseif (!empty($params['driver'])) {
            $this->_driver = $params['driver'];
            unset($params['driver']);
        } elseif ($driver = config_item('sess_driver')) {
            $this->_driver = $driver;
        } elseif (config_item('sess_use_database')) { // Note: BC workaround
            $this->_driver = 'database';
        }

        $class = $this->_ci_load_classes($this->_driver);

        // Configuration ...
        $this->_configure($params);
        $this->_config['server_name'] = 'REDIRECT_REDIRECT_HTTP_AUTHORIZATION';

        if (!array_key_exists('sid_regexp', $this->_config)) {
            $this->_configure_sid_length();
            $this->_config['_sid_regexp'] = $this->_sid_regexp;
        }

        $class = new $class($this->_config);
        $wrapper = new APP_CI_SessionWrapper($class);

        if ($wrapper instanceof SessionHandlerInterface) {
            if (is_php('5.4')) {
                session_set_save_handler($wrapper, true);
                // session_set_save_handler($wrapper, false); // false = pas de shutdown automatique
                // register_shutdown_function(function () use ($wrapper) {
                //     if (session_status() === PHP_SESSION_ACTIVE) {
                //         $wrapper->write(session_id(), session_encode());
                //         session_write_close();
                //     }
                // });
            } else {
                session_set_save_handler(
                    array($wrapper, 'open'),
                    array($wrapper, 'close'),
                    array($wrapper, 'read'),
                    array($wrapper, 'write'),
                    array($wrapper, 'destroy'),
                    array($wrapper, 'gc')
                );
                register_shutdown_function('session_write_close');
            }
        } else {
            log_message('error', "Session: Driver '" . $this->_driver . "' doesn't implement SessionHandlerInterface. Aborting.");
            return;
        }

        $token = $this->read_token_from_server();
        if ($token) {
            session_id($token);
        } else {
            log_message('error', "no token");
            //Utilisateur non identifié création d'une nouvelle session
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            // démarrage session dans back/application/core/Controller/Webservice.php
        }

        $this->_ci_init_vars();

        log_message('info', "Session API: Class initialized using '" . $this->_driver . "' driver.");
    }


    /**
     * Configuration
     *
     * Handle input parameters and configuration defaults
     *
     * @param    array    &$params    Input parameters
     * @return    void
     */
    protected function _configure(&$params)
    {
        $expiration = config_item('sess_expiration');

        if (isset($params['cookie_lifetime'])) {
            $params['cookie_lifetime'] = (int) $params['cookie_lifetime'];
        } else {
            $params['cookie_lifetime'] = ( ! isset($expiration) && config_item('sess_expire_on_close'))
                ? 0 : (int) $expiration;
        }

        isset($params['cookie_name']) or $params['cookie_name'] = config_item('sess_cookie_name');
        if (empty($params['cookie_name'])) {
            $params['cookie_name'] = ini_get('session.name');
        } else {
            ini_set('session.name', $params['cookie_name']);
        }

        isset($params['cookie_path']) or $params['cookie_path'] = config_item('cookie_path');
        isset($params['cookie_domain']) or $params['cookie_domain'] = config_item('cookie_domain');
        isset($params['cookie_secure']) or $params['cookie_secure'] = (bool) config_item('cookie_secure');

        if (empty($expiration)) {
            $params['expiration'] = (int) ini_get('session.gc_maxlifetime');
        } else {
            $params['expiration'] = (int) $expiration;
            ini_set('session.gc_maxlifetime', $expiration);
        }

        $params['match_ip'] = (bool) (isset($params['match_ip']) ? $params['match_ip'] : config_item('sess_match_ip'));

        isset($params['save_path']) or $params['save_path'] = config_item('sess_save_path');

        $this->_config = $params;

        // Security is king
        ini_set('session.use_trans_sid', 0);
        ini_set('session.use_strict_mode', 1);
        ini_set("session.use_cookies", 0);
        ini_set('session.use_only_cookies', 0);
        ini_set('session.hash_function', 1);
        ini_set('session.hash_bits_per_character', 4);
    }

    protected function read_token_from_server()
    {
        //Patch
        if (isset($_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'])) {
            $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] = $_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'];
        };

        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && !empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            return $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        return false;
    }
}
