<?php

class FunktionTable extends BaseTable {

    public $table = 'Funktion';
    private $id;
    private $funktion;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setFunktion($row->funktion);
        } else {
            $this->setLogin($_SESSION['LOGIN']);
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getFunktion() {
        return $this->funktion;
    }

    public function setFunktion($funktion) {
        $this->funktion = $funktion;
    }

    public function fetchAll() {

        $data = array();
        $mysqli = $this->select("Login = $this->Login");

        while ($row = $mysqli->fetch_object()) {
            $funktion = new Funktion();
            $funktion->setId($row->id);
            $funktion->setFunktion($row->funktion);
            $data[] = $funktion;
        }

        return $data;
    }

    public function save() {


        if (is_null($this->funktion)) {
            return $this->logNullField($this->table, 'funktion');
        }

        $data = array('funktion' => $this->funktion);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
