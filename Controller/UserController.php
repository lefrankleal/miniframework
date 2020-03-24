<?php
namespace Controller;

use Core\Helpers\Crypt;
use Model\UserModel;

/**
 * Example Controller
 */
class UserController extends UserModel
{
    private $_readable = ['id', 'name', 'last_name', 'token', 'email'];
    private $_response;
    private $_token;
    private $_uploads_folder = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser($request)
    {
        $data = $this->recoverUser($request);
        
        if (Crypt::comparePassword($request->password, $data[0]->password)) {
            if ($this->_getToken($data[0])) {
                $data[0]->token = $this->_token;
                session_start();
                $_SESSION['token'] = $this->_token;
                $this->_response = ['http_code' => 200, 'data' => $data, 'readable' => $this->_readable];
            } else {
                $this->_response = ['http_code' => 401, 'data' => ['message' => 'ERROR_GETTING_TOKEN']];
            }
        } else {
            $this->_response = ['http_code' => 401, 'data' => ['message' => 'LOGIN_ERROR_INVALID']];
        }
        return $this->_response;
    }

    private function _getToken($user)
    {
        $this->_token = Crypt::getToken($user->name . $user->password . $user->email);
        return $this->setToken($this->_token, $user);
    }

    public function getUser($request)
    {
        $data = $this->validateToken($request);
        if ($data) {
            return ['http_code' => 200, 'data' => ['user' => $data]];
        } else {
            session_start();
            session_unset();
            session_destroy();
            return ['http_code' => 401, 'data' => ['valid' => false, 'message' => 'INVALID_TOKEN']];
        }
    }

    public function validateUser($request)
    {

        $request->token = apache_request_headers()['Authorization'];
        $data = $this->validateToken($request);
        if ($data) {
            $_SESSION['active_company'] = $request->active_company;
            $_SESSION['token'] = apache_request_headers()['Authorization'];
            return ['http_code' => 200, 'data' => ['valid' => true]];
        } else {
            session_start();
            session_unset();
            session_destroy();
            return ['http_code' => 401, 'data' => ['valid' => false, 'message' => 'INVALID_TOKEN']];
        }
    }

    public function getUserByIdentification($request)
    {
        $data = $this->getUserbyIdentifications($request);
        if ($data) {
            $this->_response = ['http_code' => 200, 'data' => $data, 'readable' => $this->_readable];
        } else {
            $this->_response = ['http_code' => 412, 'data' => ['message' => 'NO_DATA_AVAILABLE']];
        }
        return $this->_response;
    }

    public function getUserByEmail($request)
    {
        $data = $this->getUserbyEmails($request);
        if ($data) {
            $this->_response = ['http_code' => 200, 'data' => $data, 'readable' => $this->_readable];
        } else {
            $this->_response = ['http_code' => 412, 'data' => ['message' => 'NO_DATA_AVAILABLE']];
        }
        return $this->_response;
    }

    public function createUser($request)
    {
        $validateIdentification = $this->getUserByIdentification($request);
        $validateEmail = $this->getUserByEmail($request);
        if ($validateIdentification["http_code"] == 200 or $validateEmail["http_code"] == 200) {
            $this->_response = ['http_code' => 412, 'data' => ['message' => 'GENERAL_NO_DATA_AVAILABLE']];
        } else {
            $data = $this->createUsers($request);
            if ($data) {
                $user = $this->getUserByIdentification($request);
                $this->_response = ['http_code' => 200, 'data' => ['message' => 'GENERAL_SUCCESS_CREATE_ITEM', 'user' => $user["data"][0]]];
            } else {
                $this->_response = ['http_code' => 412, 'data' => ['message' => 'NO_DATA_AVAILABLE']];
            }
        }
        return $this->_response;
    }

    /**
     * This function returns user's data searching by id
     * 
     * @param $request
     * @param $user_id
     * 
     * @return array
     */
    public function getUserById($request, $user_id)
    {
        $data = $this->getUserByIds($request, $user_id);
        if ($data) {
            $this->_response = ['http_code' => 200, 'data' => $data];
        } else {
            $this->_response = ['http_code' => 412, 'data' => ['message' => 'NO_DATA_AVAILABLE']];
        }
        return $this->_response;
    }

    public function getAllUserRole($request)
    {
        $userData = $this->getUser($request);
        $user = $userData['data'];
        $user_id = $user['user'][0]->id;
        $data = $this->getAllUserRoles($request, $user_id); 
        if ($data) {
            $this->_response = ['http_code' => 200, 'data' => $data];
        } else {
            $this->_response = ['http_code' => 412, 'data' => ['message' => 'NO_DATA_AVAILABLE']];
        }
        return $this->_response;
    }
}
