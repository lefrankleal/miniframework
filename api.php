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
require_once 'Core/Helpers/HttpResponse.php';
require_once 'vendor/autoload.php';

Core\Autoload::register();
$request = new Core\RequestApi();
$http = new Core\Helpers\HttpResponse();
new Core\AuthController($request);

$Controller = $request->getController() . 'Controller';
$route = ROOT . "Controller" . DS . $Controller . ".php";
if (is_readable($route)) {
    include_once $route;
    $use = "Controller\\" . $Controller;
    $Controller = new $use($request);
    if ($request->isRequest() === 'GET') {
        $rs = call_user_func(array($Controller, $request->getMethod()));
    } else {
        $rs = call_user_func_array(array($Controller, $request->getMethod()), array($request->getArgs()));
    }
    $http->response($rs);
}
