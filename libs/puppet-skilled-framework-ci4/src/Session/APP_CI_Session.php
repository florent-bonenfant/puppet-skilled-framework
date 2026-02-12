<?php

namespace Globalis\PuppetSkilled\Session;

use UnexpectedValueException;

if (class_exists(\CodeIgniter\CodeIgniter::class)) {
    class APP_CI_Session
    {
        public function __construct(array $params = [])
        {
        }

        public function userdata(?string $key = null)
        {
            $session = service('session');
            return $key === null ? $session->get() : $session->get($key);
        }

        public function set_userdata($data, $value = null): void
        {
            $session = service('session');
            if (is_array($data)) {
                $session->set($data);
                return;
            }
            $session->set($data, $value);
        }

        public function has_userdata(string $key): bool
        {
            return service('session')->has($key);
        }

        public function all_userdata(): array
        {
            return service('session')->get();
        }

        public function mark_as_flash(string $key): void
        {
            service('session')->markAsFlashdata($key);
        }

        public function sess_destroy(): void
        {
            service('session')->destroy();
        }
    }

    return;
}

require_once BASEPATH . 'libraries/Session/Session.php';

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter puppet Session Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Sessions
 * @author        Andrey Andreev
 * @link        https://codeigniter.com/userguide3/libraries/sessions.html
 */
class APP_CI_Session extends \CI_Session
{
    /**
     * CI Load Classes
     *
     * An internal method to load all possible dependency and extension
     * classes. It kind of emulates the CI_Driver library, but is
     * self-sufficient.
     *
     * @param    string    $driver    Driver name
     * @return    string    Driver class name
     */
    protected function _ci_load_classes($driver)
    {
        // PHP 5.4 compatibility
        interface_exists('SessionHandlerInterface', false) or require_once BASEPATH . 'libraries/Session/SessionHandlerInterface.php';
        // PHP 7 compatibility
        interface_exists('SessionUpdateTimestampHandlerInterface', false) or require_once BASEPATH . 'libraries/Session/SessionUpdateTimestampHandlerInterface.php';

        require_once 'SessionHandlerInterface.php';
        $wrapper = is_php('8.0') ? 'PHP8SessionWrapper' : 'OldSessionWrapper';
        require_once BASEPATH . 'libraries/Session/' . $wrapper . '.php';

        $prefix = config_item('subclass_prefix');

        if (!class_exists('CI_Session_driver', false)) {
            require_once
            file_exists(APPPATH . 'libraries/Session/Session_driver.php')
            ? APPPATH . 'libraries/Session/Session_driver.php'
            : BASEPATH . 'libraries/Session/Session_driver.php'
            ;

            if (file_exists($file_path = APPPATH . 'libraries/Session/' . $prefix . 'Session_driver.php')) {
                require_once $file_path;
            }
        }

        $class = 'Session_' . $driver . '_driver';
        // Allow custom drivers without the CI_ or MY_ prefix
        if (!class_exists($class, false) && file_exists($file_path = APPPATH . 'libraries/Session/drivers/' . $class . '.php')) {
            require_once $file_path;
            if (class_exists($class, false)) {
                return $class;
            }
        }

        if (!class_exists('CI_' . $class, false)) {
            if (file_exists($file_path = APPPATH . 'libraries/Session/drivers/' . $class . '.php') or file_exists($file_path = BASEPATH . 'libraries/Session/drivers/' . $class . '.php')) {
                require_once $file_path;
            }

            if (!class_exists('CI_' . $class, false) && !class_exists($class, false)) {
                throw new UnexpectedValueException("Session: Configured driver '" . $driver . "' was not found. Aborting.");
            }
        }

        if (!class_exists($prefix . $class, false) && file_exists($file_path = APPPATH . 'libraries/Session/drivers/' . $prefix . $class . '.php')) {
            require_once $file_path;
            if (class_exists($prefix . $class, false)) {
                return $prefix . $class;
            }

            log_message('debug', 'Session: ' . $prefix . $class . ".php found but it doesn't declare class " . $prefix . $class . '.');
        }

        return 'CI_' . $class;
    }

 	/**
	 * Configure session ID length
	 *
	 * To make life easier, we used to force SHA-1 and 4 bits per
	 * character on everyone. And of course, someone was unhappy.
	 *
	 * Then PHP 7.1 broke backwards-compatibility because ext/session
	 * is such a mess that nobody wants to touch it with a pole stick,
	 * and the one guy who does, nobody has the energy to argue with.
	 *
	 * So we were forced to make changes, and OF COURSE something was
	 * going to break and now we have this pile of shit. -- Narf
	 *
	 *
	 * Adaptation PHP 8.1
	 * @return	void
	 */
    protected function _configure_sid_length()
    {
        if (PHP_VERSION_ID < 70100) {
            // Legacy (<7.1): ensure at least 160-bit strength via session.hash_function
            $hash_function = ini_get('session.hash_function');

            if (ctype_digit($hash_function)) {
                if ($hash_function !== '1') {
                    ini_set('session.hash_function', '1');
                }
                $bits = 160;
            } elseif (!in_array($hash_function, hash_algos(), true)) {
                ini_set('session.hash_function', '1');
                $bits = 160;
            } else {
                $bits = strlen(hash($hash_function, 'dummy', false)) * 4;
                if ($bits < 160) {
                    ini_set('session.hash_function', '1');
                    $bits = 160;
                }
            }

            $bits_per_character = (int) ini_get('session.hash_bits_per_character');
            if ($bits_per_character !== 4 && $bits_per_character !== 5 && $bits_per_character !== 6) {
                // Sensible default for old PHP; CI historically expects 4/5/6.
                $bits_per_character = 4;
                ini_set('session.hash_bits_per_character', '4');
            }

            $sid_length = (int) ceil($bits / $bits_per_character);
        } else {
            // PHP >= 7.1: Force hex SIDs to match CI3 validation and prevent "deleted" cookie behavior.
            $bits_per_character = (int) ini_get('session.sid_bits_per_character');
            $sid_length = (int) ini_get('session.sid_length');

            // Force hex alphabet
            if ($bits_per_character !== 4) {
                $bits_per_character = 4;
                ini_set('session.sid_bits_per_character', '4');
            }

            // Force a sane default length (PHP default varies; CI validation issues show up with non-hex alphabets)
            if ($sid_length < 32) {
                $sid_length = 32;
                ini_set('session.sid_length', (string) $sid_length);
            }

            // Ensure at least 160 bits of entropy (bump length if needed)
            $bits = $sid_length * $bits_per_character;
            if ($bits < 160) {
                $sid_length += (int) ceil((160 - $bits) / $bits_per_character);
                ini_set('session.sid_length', (string) $sid_length);
            }
        }

        // Known possible values: 4, 5, 6
        switch ($bits_per_character) {
            case 4:
                $this->_sid_regexp = '[0-9a-f]';
                break;
            case 5:
                $this->_sid_regexp = '[0-9a-v]';
                break;
            case 6:
                $this->_sid_regexp = '[0-9a-zA-Z,-]';
                break;
            default:
                $this->_sid_regexp = '[0-9a-f]';
                $bits_per_character = 4;
                ini_set('session.sid_bits_per_character', '4');
                break;
        }

        $this->_sid_regexp .= '{' . $sid_length . '}';
    }

}
