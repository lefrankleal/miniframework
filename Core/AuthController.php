<?php
namespace Core;

use Core\Router;
use Core\RequestApi;
use Controller\UserController;
use Core\Helpers\HttpResponse;

class AuthController extends Router
{
    private $_token;

    /**
     * Header token needed ['tokenized'] Array<String> that should contain <Controller Name>@<Function name>
     * Public Access no token needed ['public_pages'] Array<String> that should contain <Controller Name>@<Function name>
     */
    private $_routes = [
        'tokenized' => [],
        'public_pages' => [],
    ];
    /**
     * Undocumented function
     *
     * @param RequestApi $request
     */
    public function __construct($request)
    {
        $this->_token = apache_request_headers()['Authorization'];
        $access = $this->canAccess($request);
        if ($access == 'tokenized') {
            $this->validateToken();
        } elseif ($access == 'public_pages') {
        } else {
            $http = new HttpResponse();
            $http->response(['http_code' => 412, 'data' => ['message' => 'TOKEN_NOT_FOUND']]);
        }
    }

    /**
     * ValidateToken
     *
     * @param  string $token
     * @return redirect
     */
    public function validateToken()
    {
        $userController = new UserController;
        $request->token = $this->_token;
        $_SESSION['token'] = $this->_token;
        $userController->getUser($request);
    }

    public function logOut()
    {
        session_start();
        session_destroy();
        session_unset();
        header("Location: login.php");
        die();
    }

    private function canAccess(RequestApi $request)
    {
        if ($this->_token != 'Public-Access' && in_array($request->getController() . "@" . $request->getMethod(), $this->_routes['tokenized'])) {
            return 'tokenized';
        } elseif ($this->_token == 'Public-Access' && in_array($request->getController() . "@" . $request->getMethod(), $this->_routes['public_pages'])) {
            return 'public_pages';
        } else {
            return false;
        }
    }
}
