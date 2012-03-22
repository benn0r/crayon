<?php

class BerufsbildTable extends BaseTable {

    public $table = 'Berufsbild';
    private $id;
    private $Login;
    private $kuerzel;
    private $berufsbild;
    private $dauer;
    private $Berufsbildner;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setKuerzel($row->kuerzel);
            $this->setBerufsbild($row->berufsbild);
            $this->setDauer($row->dauer);
            $this->setBerufsbildner($row->Berufsbildner);
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

    public function getLogin() {
        return $this->Login;
    }

    private function setLogin($Login) {
        $this->Login = (int) $Login;
    }

    public function getKuerzel() {
        return $this->kuerzel;
    }

    public function setKuerzel($kuerzel) {
        $this->kuerzel = $kuerzel;
    }

    public function getBerufsbild() {
        return $this->berufsbild;
    }

    public function setBerufsbild($berufsbild) {
        $this->berufsbild = $berufsbild;
    }

    public function getDauer() {
        return $this->dauer;
    }

    public function setDauer($dauer) {
        $this->dauer = $dauer;
    }

    public function getBerufsbildner() {
        return $this->Berufsbildner;
    }

    public function setBerufsbildner($Berufsbildner) {
        $this->Berufsbildner = new Person($Berufsbildner);
    }

    public function fetchAll() {

        $data = array();
        $mysqli = $this->select("Login = $this->Login ORDER BY berufsbild ASC");

        while ($row = $mysqli->fetch_object()) {
            $berufsbild = new Berufsbild();
            $berufsbild->setId($row->id);
            $berufsbild->setLogin($row->Login);
            $berufsbild->setKuerzel($row->kuerzel);
            $berufsbild->setBerufsbild($row->berufsbild);
            $berufsbild->setDauer($row->dauer);
            $berufsbild->setBerufsbildner($row->Berufsbildner);
            $data[] = $berufsbild;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->kuerzel)) {
            return $this->logNullField($table, 'kürzel');
        } elseif (is_null($this->Login)) {
            return $this->logNullField($table, 'Login');
        } elseif (is_null($this->berufsbild)) {
            return $this->logNullField($table, 'berufsbild');
        } elseif (is_null($this->dauer)) {
            return $this->logNullField($table, 'dauer');
        } elseif (is_null($this->Berufsbildner)) {
            return $this->logNullField($table,'Berufsbildner');
        }

        $data = array('kuerzel' => $this->kuerzel,
            'Login' => $this->Login,
            'berufsbild' => $this->berufsbild,
            'dauer' => $this->dauer,
            'Berufsbildner' => $this->Berufsbildner->getId());

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
