<?php

class mysql_Adapter {

    private $mysqli = null;
    protected $host = null;
    protected $username = null;
    protected $password = null;
    protected $dbname = null;


    public function getDbAdapter() {
        return $this->mysqli;
    }

    public function __construct($host, $username, $password, $dbname) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    protected function _connect() {
        $mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($mysqli->connect_error) {
            throw new Exception($mysqli->connect_error);
        }
        $this->mysqli = $mysqli;
        $this->mysqli->query('SET NAMES "utf8"');
    }

    public function update($table, $data, $where = '') {

        if ($this->mysqli === null) {
            $this->_connect();
        }

        if (!is_string($table)) {
            trigger_error('$table must be a string', E_USER_ERROR);
        }

        if (!is_array($data)) {
            trigger_error('$data must be an array', E_USER_ERROR);
        }

        $query = 'UPDATE `' . $table . '` SET ';

        $fields = array();
        foreach ($data as $name => $value) {
            $fields[] = '`' . $name . '` = ' . $this->enclose($value);
        }
        $query .= implode(', ', $fields);

        if ($where) {
            $query .= ' WHERE ' . $where;
        }

        if (!$return = $this->mysqli->query($query)) {
            throw new Exception($this->mysqli->error);
        }
        return $return;
    }

    public function delete($table, $where = '') {

        if ($this->mysqli === null) {
            $this->_connect();
        }

        if (!is_string($table)) {
            trigger_error('$table must be a string', E_USER_ERROR);
        }

        $query = 'DELETE FROM `' . $table . '`';

        if ($where) {
            $query .= ' WHERE ' . $where;
        }

        if (!$return = $this->mysqli->query($query)) {
            throw new Exception($this->mysqli->error);
        }
        return $return;
    }

    public function insert($table, $data) {

        if ($this->mysqli === null) {
            $this->_connect();
        }

        if (!is_string($table)) {
            trigger_error('$table must be a string', E_USER_ERROR);
        }

        if (!is_array($data)) {
            trigger_error('$data must be an array', E_USER_ERROR);
        }

        $query = 'INSERT INTO `' . $table . '` SET ';

        $fields = array();
        foreach ($data as $name => $value) {
            $fields[] = '`' . $name . '` = ' . $this->enclose($value);
        }
        $query .= implode(', ', $fields);

        if (!$return = $this->mysqli->query($query)) {
            throw new Exception($this->mysqli->error);
        }
        return $this->lastInsertId();
    }

    public function select($table, $where = '') {
        if ($this->mysqli === null) {
            $this->_connect();
        }

        $query = 'SELECT * FROM ' . $table;

        // Where
        if ($where) {
            $query .= ' WHERE ' . $where;
        }

        if (!$return = $this->mysqli->query($query)) {
            throw new Exception($this->mysqli->error);
        }
        return $return;
    }

    public function execute($sql) {
        if ($this->mysqli === null) {
            $this->_connect();
        }

        if (!$return = $this->mysqli->query($sql)) {
            throw new Exception($this->mysqli->error);
        }
        return $return;
    }

    public function lastInsertId() {
        if ($this->mysqli === null) {
            return null;
        }
        return $this->mysqli->insert_id;
    }

    public function enclose($value, $escape = true) {
        if ($this->mysqli === null) {
            $this->_connect();
        }

        switch (gettype($value)) {
            case 'string':
            default:
                if ($escape) {
                    return '"' . $this->mysqli->real_escape_string($value) . '"';
                } else {
                    return '"' . $value . '"';
                }
            case 'integer':
            case 'double':
                return $this->mysqli->real_escape_string($value);
            case 'object':
                if ($value instanceof Db_Expression) {
                    return $value->__toString();
                }
                return '"' . serialize($value) . '"';
        }

        throw new Exception('Invalid vartype ' . gettype($value));
    }

}

class Db_Expression{
    private $data;
    public function __construct($value) {
        $this->data = $value;
    }

    public function __toString() {
        return $this->data;
    }
}