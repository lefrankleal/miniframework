<?php
namespace Core\Drivers;

use Core\Connection;


/**
 * MySqliDriver
 *
 * PHP Version 7.1
 *
 * @category MySqliDriver
 * @package  Core_Drivers
 * @author   Frank Leal <franklealorg@gmail.com>
 */
class MySqliDriver extends Connection
{
    protected $num_rows;
    protected $transac = 0;

    /**
     * Initialize Connection controller
     *
     * @return void
     */
    public function __construct()
    {
        parent::getMySqli();
    }

    /**
     * Take mysql query and return object
     *
     * @param string $q mysql query
     *
     * @return obejct
     */
    protected function loadObjectList($q)
    {
        $result = $this->link->query($q);
        if (!$result) {
            return false;
        } else {
            $this->num_rows = $result->num_rows;
            while ($row = ($result->fetch_object())) {
                $rs[] = $row;
            }
            $this->endResult($result);
            if ($this->num_rows >= 1) {
                return $rs;
            } else {
                return false;
            }
        }
    }
    /**
     * Recive a mysql query and execute it
     *
     * @param string $q mysql query
     *
     * @return mysqli_query
     */
    protected function dbquery($q)
    {
        $result = $this->link->query($q);
        $rs = $result;
        $this->endResult($result);
        return ($result);
    }
    /**
     * This add slashes for the string given
     *
     * @param string $vars string or empty if request should be scaped
     *
     * @return array
     */
    protected function dataRequest($vars = '')
    {
        if (is_array($vars)) {
            foreach ($vars as $key => $v) {
                if (is_string($v)) {
                    $vars[$key] = $this->link->real_escape_string($v);
                } else {
                    $vars[$key] = $v;
                }
            }
        } elseif (strlen($vars) > 0) {
            if (is_string($vars)) {
                $vars = $this->link->real_escape_string($vars);
            }
        } elseif (strlen($vars) < 1) {
            if (is_string($vars)) {
                $vars = NULL;
            }
        }
        return $vars;
    }
    /**
     * Transaction mysqli commit or rollback having in
     *
     * @return void
     */
    protected function transaction()
    {
        if ($this->transac < 1) {
            $query = $this->dbquery("COMMIT;");
        } else {
            $query = $this->dbquery("ROLLBACK;");
        }
        $this->transac = 0;
    }
    /**
     * Begin mysqli begin
     *
     * @return void
     */
    protected function begin()
    {
        $query = $this->dbquery("BEGIN;");
    }
    /**
     * Close conection
     *
     * @param mysqli_conecction $result conection
     *
     * @return void
     */
    protected function endResult($result)
    {
    }
    /**
     * Get Max $field from $table with condition $where
     *
     * @param string $field table key
     * @param string $table target table
     * @param string $where where sentence
     *
     * @return int next $field from $table
     */
    protected function getMax($field, $table, $where = '')
    {
        if (strlen($wh) > 0) {
            $where = "WHERE " . $wh;
        } else {
            $where = '';
        }
        $query = "SELECT MAX($field) AS cons FROM $table $where";
        $rs = $this->loadObjectList($query);
        if ($rs[0]->cons > 0) {
            $cons = $rs[0]->cons;
            $cons++;
        } else {
            $cons = 1;
        }

        return $cons;
    }
}
