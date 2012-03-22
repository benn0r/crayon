<?php

class BaseModel {

    public function insert($data) {
        if ($this->mysqli === null) {
            $this->connect();
        }
        return $this->mysqli->insert($this->table, $data);
    }

    public function update($data, $where) {
        if ($this->mysqli === null) {
            $this->connect();
        }
        if (!$return = $this->mysqli->update($this->table, $data, $where)) {
            new Exception($this->_mysqli->error);
        }
        return $return;
    }

    public function delete($where) {
        if ($this->mysqli === null) {
            $this->connect();
        }
        if (!$return = $this->mysqli->delete($this->table, $where)) {
            new Exception($this->_mysqli->error);
        }
        return $return;
    }

    public function select($where) {
        if ($this->mysqli === null) {
            $this->connect();
        }

        if (!$return = $this->mysqli->select($this->table, $where)) {
            new Exception($this->_mysqli->error);
        }
        return $return;
    }

    public function execute($sql) {
        if ($this->mysqli === null) {
            $this->connect();
        }
        if (!$return = $this->mysqli->execute($sql)) {
            new Exception($this->_mysqli->error);
        }
        return $return;
    }

    private function connect() {
        $this->mysqli = new mysql_Adapter(Configuration::DB_HOST, Configuration::DB_USER, Configuration::DB_PASSWORT, Configuration::DB_NAME);
    }

    public function idToLogin($model)
    {
        if ($model->getLogin() != $_SESSION['LOGIN'])
        {
            return false;
        } else {
            return true;
        }

    }

}

?>
