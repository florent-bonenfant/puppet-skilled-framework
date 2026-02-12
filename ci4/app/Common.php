<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (is_file(ROOTPATH . '../vendor/autoload.php')) {
    require_once ROOTPATH . '../vendor/autoload.php';
}

// Force-load local PuppetSkilled bridge after Composer deps are available.
$pskAutoloader = APPPATH . 'Libraries/PuppetSkilledLocalAutoloader.php';
if (is_file($pskAutoloader)) {
    require_once $pskAutoloader;
    \App\Libraries\PuppetSkilledLocalAutoloader::register();
}
