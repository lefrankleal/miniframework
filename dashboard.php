<?php

/**
 * This load all the system logic
 *
 * PHP Version 7.1
 *
 * @category Index_Loader
 * @package  None
 * @author   Frank Leal <franklealorg@gmail.com>
 * @link     none
 */

require_once 'settings.php';
require_once 'Core/Autoload.php';
require_once 'vendor/autoload.php';

Core\Autoload::register();
$request = new Core\Request();
$lang = new Core\Helpers\Languaje();

if (!isset($_SESSION['active_company']) && PAGE !== 'main') {
    define(PAGE, 'main');
}

/**
 * Using LANG functions
 */
$lang->register();
$lang->registerCustom('Menu');

require_once 'header.php';
if (file_exists('tpl/' . PAGE . '.php')) {
    include_once 'tpl/' . PAGE . '.php';
} else {
    include_once 'error_docs/404.php';
}
require_once 'footer.php';
