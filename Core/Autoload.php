<?php
namespace Core;

/**
 * Autoloads Classes
 *
 * @package Core
 */
class Autoload
{
    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register(
            function ($ClassName) {
                include_once str_replace('\\', '/', $ClassName . '.php');
            }
        );
    }
}