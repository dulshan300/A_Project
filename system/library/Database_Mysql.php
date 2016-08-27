<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package        CodeDlab
 * @author        CodeDlab Dev A.G.D.Madusanka.
 * @copyright    Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since        Version 1.0
 *
 */
class Database_Mysql
{

    /**
     * Connection holds MySQLi resource
     */
    private $connection;

    /**
     * Query to perform
     */
    private $query;

    /**
     * Result holds data retrieved from server
     */
    private $result;

    /**
     * Create new connection to database
     */

    private $setting = [];

    public function __construct($setting = [])
    {
        $this->setting = $setting;
        $this->connect();
    }

    /*
     * used to connect to the database
     * @return boolean
     */

    /**
     * @throws Exception
     */
    public function connect()
    {
        //connection parameters
        

        $host     = $this->setting['host'];
        $user     = $this->setting['username'];
        $password = $this->setting['password'];
        $db       = $this->setting['dbname'];

        $port   = null;
        $socket = null;

        $this->connection = new mysqli($host, $user, $password);
        if (mysqli_connect_error()) {
            throw new Exception(mysqli_connect_error());
        } else {
            $this->connection->select_db($db);
            if ($this->connection->error) {
                throw new Exception($this->connection->error);
            }
        }
    }

    /**
     * Get a array of result
     * @param String $query
     */
    public function execute_query($query)
    {
        $this->result = $this->connection->query($query);

        if (!empty($this->result) && $this->result->num_rows > 0) {
            $rows = array();
            while ($row = $this->result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        }

        return false;
    }

    public function query_to_object($query)
    {
        $this->result = $this->connection->query($query);
        if (!empty($this->result) && $this->result->num_rows > 0) {
            $rows = array();
            while ($row = $this->result->fetch_object()) {
                $rows[] = $row;
            }

            return $rows;
        }

        return false;
    }

    /**
     * @return int
     */
    public function num_rows()
    {
        return $this->result->num_rows;
    }

    /**
     * Enter description here ...
     * @param String $query
     * @return bool
     */
    public function execute_update($query)
    {
        $this->connection->query($query);
        return $this->connection->affected_rows;
    }

    /*
     * insert a single record
     */

    /**
     * Add a single record and get affected rows count as a return
     * @param String $table
     * @param array $values
     * @return bool
     */
    public function insert_Record($table, $valus)
    {
        $field_array = array_keys($valus);
        $data_raw    = array_values($valus);
        $data_array  = array();

        foreach ($data_raw as $val) {
            $data_array[] = $this->clean($val);
        }

        $fld_string  = "(" . implode(", ", $field_array) . ")";
        $data_string = "('" . implode("', '", $data_array) . "')";

        $sql = "INSERT INTO $table $fld_string VALUES $data_string";

        return $this->execute_update($sql);

    }

    /**
     * @param $table
     * @param $key
     * @param $key_value
     * @param $value
     * @return bool
     */
    public function update_record($table, $key, $key_value, $value)
    {
        try {
            $sql       = 'UPDATE ' . $table . ' set ';
            $value_set = "";
            foreach ($value as $field => $data) {
                $data = $this->clean($data);
                $value_set .= $field . '="' . $data . '",';
            }
            $last      = strrpos($value_set, ",");
            $value_set = substr($value_set, 0, $last);
            $sql .= $value_set . " WHERE $key=" . '"' . $key_value . '"';
            $this->execute_update($sql);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @return bool
     */
    public function delete_record($table, $column, $value)
    {
        $sql = "DELETE FROM $table WHERE $column = '$value'";
        return $this->execute_update($sql);
    }

    /**
     * @param $table
     * @param $key
     * @return bool
     */
    public function last_id($table, $key)
    {
        $sql = "SELECT $key FROM $table ORDER BY $key DESC LIMIT 1";
        $res = $this->execute_query($sql);
        if ($res) {
            $data = array_shift($res);
            return $data[$key];
        } else {
            return false;
        }
    }

    /* (non-PHPdoc)
     * @see system/library/Database_Library::disconnect()
     */

    /**
     * @return bool
     */
    public function disconnect()
    {
        $this->connection->close();
        return true;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Enter description here ...
     * @param Object $data
     */
    public function clean($data)
    {
        return $this->connection->escape_string($data);
    }

}
