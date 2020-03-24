<?php

/**
 *
 * PHP Version 7.1
 *
 * @category System_Settings
 * @package  None
 * @author   Frank Leal <franklealorg@gmail.com>
 * @link     none
 */

define('MYSQLHOST', "localhost");
define('MYSQLUSER', "frank");
define('MYSQLPWD', "frank");
define('MYSQLDBNAME', "frank");

define('SYSTEMNAME', "Mini Framework");
/**
 * This param should be dev or prod
 */
define('ENV', 'dev');

ini_set('display_errors', false);
ini_set('memory_limit', '512M');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', 'http://' . $_SERVER['HTTP_HOST']);

isset($_REQUEST['lang']) && strlen(isset($_REQUEST['lang'])) > 0 ? define('LANG', $_REQUEST['lang']) : define(LANG, 'es');
isset($_REQUEST['p']) && strlen(isset($_REQUEST['p'])) > 0 ? define('PAGE', $_REQUEST['p']) : define(PAGE, 'main');

session_start();
