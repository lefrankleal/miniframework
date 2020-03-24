<?php

/**
 * PHP Version 7.1
 *
 * @category Core_Functions
 * @package  Core
 * @author   Frank Leal <franklealorg@gmail.com>
 */
namespace Core;

class Request
{
    private $_Keys;
    private $_Values;
    public $_Args;

    /**
     * Contructor method for Request class
     */
    public function __construct()
    {
        $this->_Args = new \stdClass();
        $params = filter_input(INPUT_GET, 'params', FILTER_SANITIZE_URL);
        $params = explode('/', $params);
        if (count($params) > 1) {
            array_walk(
                $params, function ($value, $index) {

                    if ($index % 2 == 0) {
                        $this->_Keys[] = $value;
                    } else {
                        $this->_Values[] = $value;
                    }
                }
            );
            $count = count($this->_Keys);
            for ($i=0; $i < $count; $i++) {
                $this->_Args->{$this->_Keys[$i]} = $this->_Values[$i];
            }
        }
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
     * @param string|boolean $method Request type or false to make it open
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