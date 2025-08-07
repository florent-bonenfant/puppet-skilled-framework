<?php

namespace Globalis\PuppetSkilled\Session;

use UnexpectedValueException;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter puppet Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Andrey Andreev
 * @link		https://codeigniter.com/userguide3/libraries/sessions.html
 */
class CIPP_Session extends \CI_Session {

	/**
	 * CI Load Classes
	 *
	 * An internal method to load all possible dependency and extension
	 * classes. It kind of emulates the CI_Driver library, but is
	 * self-sufficient.
	 *
	 * @param	string	$driver	Driver name
	 * @return	string	Driver class name
	 */
	protected function _ci_load_classes($driver)
	{
		// PHP 5.4 compatibility
		interface_exists('SessionHandlerInterface', FALSE) OR require_once(BASEPATH.'libraries/Session/SessionHandlerInterface.php');
		// PHP 7 compatibility
		interface_exists('SessionUpdateTimestampHandlerInterface', FALSE) OR require_once(BASEPATH.'libraries/Session/SessionUpdateTimestampHandlerInterface.php');

		require_once('SessionDriverInterface.php');
		$wrapper = is_php('8.0') ? 'PHP8SessionWrapper' : 'OldSessionWrapper';
		require_once(BASEPATH.'libraries/Session/'.$wrapper.'.php');

		$prefix = config_item('subclass_prefix');

		if ( ! class_exists('CI_Session_driver', FALSE))
		{
			require_once(
				file_exists(APPPATH.'libraries/Session/Session_driver.php')
					? APPPATH.'libraries/Session/Session_driver.php'
					: BASEPATH.'libraries/Session/Session_driver.php'
			);

			if (file_exists($file_path = APPPATH.'libraries/Session/'.$prefix.'Session_driver.php'))
			{
				require_once($file_path);
			}
		}

		$class = 'Session_'.$driver.'_driver';
		// Allow custom drivers without the CI_ or MY_ prefix
		if ( ! class_exists($class, FALSE) && file_exists($file_path = APPPATH.'libraries/Session/drivers/'.$class.'.php'))
		{
			require_once($file_path);
			if (class_exists($class, FALSE))
			{
				return $class;
			}
		}

		if ( ! class_exists('CI_'.$class, FALSE))
		{
			if (file_exists($file_path = APPPATH.'libraries/Session/drivers/'.$class.'.php') OR file_exists($file_path = BASEPATH.'libraries/Session/drivers/'.$class.'.php'))
			{
				require_once($file_path);
			}

			if ( ! class_exists('CI_'.$class, FALSE) && ! class_exists($class, FALSE))
			{
				throw new UnexpectedValueException("Session: Configured driver '".$driver."' was not found. Aborting.");
			}
		}

		if ( ! class_exists($prefix.$class, FALSE) && file_exists($file_path = APPPATH.'libraries/Session/drivers/'.$prefix.$class.'.php'))
		{
			require_once($file_path);
			if (class_exists($prefix.$class, FALSE))
			{
				return $prefix.$class;
			}

			log_message('debug', 'Session: '.$prefix.$class.".php found but it doesn't declare class ".$prefix.$class.'.');
		}

		return 'CI_'.$class;
	}
}
