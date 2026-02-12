<?php

namespace App\Libraries;

class PuppetSkilledLocalAutoloader
{
    private static bool $registered = false;

    public static function register(): void
    {
        if (self::$registered) {
            return;
        }
        self::$registered = true;

        $packageRoot = ROOTPATH . '../libs/puppet-skilled-framework-ci4/';
        $srcRoot = $packageRoot . 'src/';

        if (!is_dir($srcRoot)) {
            return;
        }

        spl_autoload_register(static function (string $class) use ($srcRoot): void {
            $prefix = 'Globalis\\PuppetSkilled\\';
            if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
                return;
            }

            $relative = substr($class, strlen($prefix));
            $file = $srcRoot . str_replace('\\', '/', $relative) . '.php';
            if (is_file($file)) {
                require_once $file;
            }
        }, true, true);

        $helpers = $srcRoot . 'Core/helpers.php';
        if (is_file($helpers)) {
            require_once $helpers;
        }

        // Preload critical classes so Composer's vendor copy cannot win.
        $critical = [
            'Core/Container.php',
            'Core/Application.php',
            'Service/Base.php',
            'Controller/Base.php',
            'Controller/Cli.php',
            'View/ViewVarsTrait.php',
            'View/Asset.php',
            'View/View.php',
        ];
        foreach ($critical as $rel) {
            $file = $srcRoot . $rel;
            if (is_file($file)) {
                require_once $file;
            }
        }
    }
}
