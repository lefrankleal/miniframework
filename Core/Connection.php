<?php

/**
 * Connection class to the database
 *
 * PHP Version 7.1
 *
 * @package  Core
 * @author   Frank Leal <franklealorg@gmail.com>
 */
namespace Core;

class Connection
{
    protected $link;

    public function __construct()
    {
    }
    /**
     * Start MySqli conection
     *
     * @return mysqli
     */
    protected function getMySqli()
    {
        try {
            $conex = @new \mysqli(MYSQLHOST, MYSQLUSER, MYSQLPWD, MYSQLDBNAME);
            if ($conex->connect_error) {
                if ($conex->connect_error == 'php_network_getaddresses: getaddrinfo failed: Name or service not known') {
                    die('Error de conexión: ' . $conex->connect_error );
                } else {
                    die('Error de conexión: ' . $conex->connect_error);
                }
            }
            $conex->set_charset('utf8');
            $this->link = $conex;
        } catch (Exeption $e) {
            echo $e->getMessage();
        }
    }
}
?>