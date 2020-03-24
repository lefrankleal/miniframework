<?php

/**
 *
 * PHP Version 7.1
 *
 * @category Index_Login
 * @package  None
 * @author   Frank Leal <franklealorg@gmail.com>
 * @link     none
 */
require_once 'settings.php';
require_once 'Core/Autoload.php';

Core\Autoload::register();
$request = new Core\Request();
new Core\AuthController($request->getController());

?>