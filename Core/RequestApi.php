<?php

/**
 * PHP Version 7.1
 *
 * @category Core_Functions
 * @package  Core
 * @author   Frank Leal <franklealorg@gmail.com>
 */
namespace Core;

class RequestApi
{
    private $_Controller;
    private $_Method;
    private $_Args;

    /**
     * Contructor method for Request class
     */
    public function __construct()
    {
        $route = filter_input(INPUT_GET, 'route', FILTER_SANITIZE_URL);
        $route = explode('/', $route);
        $this->_Controller = array_shift($route);
        $this->_Method = array_shift($route);
        $this->_Args = $this->isRequest() !== 'GET' ? json_decode(file_get_contents("php://input")) : $route;
    }
    /**
     * Return controller for this request
     *
     * @return string Controller name
     */
    public function getController()
    {
        return $this->_Controller;
    }

    /**
     * Return method for this request
     *
     * @return string method name
     */
    public function getMethod()
    {
        return $this->_Method;
    }
    /**
     * Return all the params passed for a method
     *
     * @return string Arguments for the call
     */
    public function getArgs()
    {
        return $this->_Args;
    }

    /**
     * Return request type for this request
     *
     * @param string|void $method Request
     *
     * @return string Request type
     */
    public function isRequest($method = false)
    {
        if ($method) {
            return $_SERVER['REQUEST_METHOD'] == $method;
        } else {
            return $_SERVER['REQUEST_METHOD'];
        }
    }
}

?>