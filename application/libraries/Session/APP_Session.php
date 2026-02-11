<?php

defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Session\APP_CI_Session;
use \Globalis\PuppetSkilled\Session\APP_CI_SessionWrapper;

/**
 * CodeIgniter puppet Session Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Sessions
 * @author        Andrey Andreev
 * @link        https://codeigniter.com/userguide3/libraries/sessions.html
 */
class APP_Session extends APP_CI_Session
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
        }
        // Note: BC workaround
        elseif (config_item('sess_use_database')) {
            log_message('debug', 'Session: "sess_driver" is empty; using BC fallback to "sess_use_database".');
            $this->_driver = 'database';
        }
        log_message('debug', 'TOP index.php use_cookies=' . ini_get('session.use_cookies') . ' only=' . ini_get('session.use_only_cookies') . ' name=' . ini_get('session.name'));

        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');

        log_message('debug', 'AFTER ini_set use_cookies=' . ini_get('session.use_cookies') . ' only=' . ini_get('session.use_only_cookies') . ' name=' . ini_get('session.name'));

        $class = $this->_ci_load_classes($this->_driver);

        // Configuration ...
        $this->_configure($params);
		log_message('error', 'CI sid_regexp='.$this->_sid_regexp);
        $this->_config['_sid_regexp'] = $this->_sid_regexp;

        $class = new $class($this->_config);
        $wrapper = new APP_CI_SessionWrapper($class);

        if ($wrapper instanceof SessionHandlerInterface) {
            if (is_php('5.4')) {
                session_set_save_handler($wrapper, true);
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

        // Sanitize the cookie, because apparently PHP doesn't do that for userspace handlers
        if (isset($_COOKIE[$this->_config['cookie_name']])
            && (
                !is_string($_COOKIE[$this->_config['cookie_name']])
                or !preg_match('#\A' . $this->_sid_regexp . '\z#', $_COOKIE[$this->_config['cookie_name']])
            )
        ) {
            unset($_COOKIE[$this->_config['cookie_name']]);
        }

        log_message('debug', 'ini session.use_cookies=' . ini_get('session.use_cookies') . ' session.name=' . ini_get('session.name'));

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        log_message('debug', 'PHP session_name=' . session_name() . ' session_id=' . session_id());
        log_message('debug', 'Cookies=' . json_encode(array_keys($_COOKIE)));
        $_SESSION['pingss'] = time();
        // log_message('info', "Session: before IF" . $_SERVER['HTTP_X_REQUESTED_WITH']);

        // Is session ID auto-regeneration configured? (ignoring ajax requests)
        if ((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
            && ($regenerate_time = config_item('sess_time_to_update')) > 0
        ) {
            // var_dump(config_item('sess_time_to_update'), $_SESSION, $_COOKIE[$this->_config['cookie_name']], session_id(), $_SERVER);
            log_message('info', "Session: HTTP_X_REQUESTED_WITH" . session_id() . json_encode($_COOKIE));

// var_dump(session_id());
            if (!isset($_SESSION['__ci_last_regenerate'])) {
                $_SESSION['__ci_last_regenerate'] = time();
            } elseif ($_SESSION['__ci_last_regenerate'] < (time() - $regenerate_time)) {
                $this->sess_regenerate((bool) config_item('sess_regenerate_destroy'));
            }
        }
        // Another work-around ... PHP doesn't seem to send the session cookie
        // unless it is being currently created or regenerated
        elseif (isset($_COOKIE[$this->_config['cookie_name']]) && $_COOKIE[$this->_config['cookie_name']] === session_id()) {
            $expires = empty($this->_config['cookie_lifetime']) ? 0 : time() + $this->_config['cookie_lifetime'];
            log_message('info', "Session: " . $_COOKIE[$this->_config['cookie_name']] === session_id());

            if (is_php('7.3')) {
                log_message('info', "Session: PHP73");
				try {

					setcookie(
						$this->_config['cookie_name'],
						session_id(),
						array(
							'expires' => $expires,
							'path' => $this->_config['cookie_path'],
							'domain' => $this->_config['cookie_domain'],
							'secure' => $this->_config['cookie_secure'],
							'httponly' => true,
							'samesite' => $this->_config['cookie_samesite'],
							)
						);
					}
					catch (\Exception $e) {
						var_dump($e);die;
					}
            } else {
                log_message('info', "Session: < PHP73");
                $header = 'Set-Cookie: ' . $this->_config['cookie_name'] . '=' . session_id();
                $header .= empty($expires) ? '' : '; Expires=' . gmdate('D, d-M-Y H:i:s T', $expires) . '; Max-Age=' . $this->_config['cookie_lifetime'];
                $header .= '; Path=' . $this->_config['cookie_path'];
                $header .= ($this->_config['cookie_domain'] !== '' ? '; Domain=' . $this->_config['cookie_domain'] : '');
                $header .= ($this->_config['cookie_secure'] ? '; Secure' : '') . '; HttpOnly; SameSite=' . $this->_config['cookie_samesite'];
                header($header);
            }

            if (!$this->_config['cookie_secure'] && $this->_config['cookie_samesite'] === 'None') {
                log_message('error', "Session: '" . $this->_config['cookie_name'] . "' cookie sent with SameSite=None, but without Secure attribute.'");
            }
        }

        $this->_ci_init_vars();

        log_message('info', "Session: Class initialized using '" . $this->_driver . "' driver.");
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
            $params['cookie_lifetime'] = (!isset($expiration) && config_item('sess_expire_on_close'))
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

        isset($params['cookie_samesite']) or $params['cookie_samesite'] = config_item('sess_samesite');
        if (!isset($params['cookie_samesite']) && is_php('7.3')) {
            $params['cookie_samesite'] = ini_get('session.cookie_samesite');
        }

        if (isset($params['cookie_samesite'])) {
            $params['cookie_samesite'] = ucfirst(strtolower($params['cookie_samesite']));
            in_array($params['cookie_samesite'], array('Lax', 'Strict', 'None'), true) or $params['cookie_samesite'] = 'Lax';
        } else {
            $params['cookie_samesite'] = 'Lax';
        }

        if (is_php('7.3')) {
            session_set_cookie_params(array(
                'lifetime' => $params['cookie_lifetime'],
                'path' => $params['cookie_path'],
                'domain' => $params['cookie_domain'],
                'secure' => $params['cookie_secure'],
                'httponly' => true,
                'samesite' => $params['cookie_samesite'],
            ));
        } else {
            session_set_cookie_params(
                $params['cookie_lifetime'],
                $params['cookie_path'] . '; SameSite=' . $params['cookie_samesite'],
                $params['cookie_domain'],
                $params['cookie_secure'],
                true// HttpOnly; Yes, this is intentional and not configurable for security reasons
            );
        }

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
        ini_set("session.use_cookies", 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.hash_function', 1);
        ini_set('session.hash_bits_per_character', 4);

        $this->_configure_sid_length();
    }
}
