<?php

class AbteilungTable extends BaseTable {

    public $table = 'Abteilung';
    private $id;
    private $Login;
    private $kuerzel;
    private $abteilung;
    private $Abteilungsleiter;
    private $Fachvorgesetzer;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setKuerzel($row->kuerzel);
            $this->setAbteilung($row->abteilung);
            $this->setAbteilungsleiter($row->Abteilungsleiter);
            $this->setFachvorgesetzer($row->Fachvorgesetzer);
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

    public function getAbteilung() {
        return $this->abteilung;
    }

    public function setAbteilung($abteilung) {
        $this->abteilung = $abteilung;
    }

    public function getAbteilungsleiter() {
        return $this->Abteilungsleiter;
    }

    public function setAbteilungsleiter($Abteilungsleiter) {
        $this->Abteilungsleiter = new Person((int) $Abteilungsleiter);
    }

    public function getFachvorgesetzer() {
        return $this->Fachvorgesetzer;
    }

    public function setFachvorgesetzer($Fachvorgesetzer) {
        $this->Fachvorgesetzer = new Person((int) $Fachvorgesetzer);
    }

    public function fetchAll() {

        $data = array();
        $mysqli = $this->select("Login = $this->Login ORDER BY abteilung ASC");

        while ($row = $mysqli->fetch_object()) {
            $abteilung = new Abteilung();
            $abteilung->setId($row->id);
            $abteilung->setLogin($row->Login);
            $abteilung->setKuerzel($row->kuerzel);
            $abteilung->setAbteilung($row->abteilung);
            $abteilung->setAbteilungsleiter($row->Abteilungsleiter);
            $abteilung->setFachvorgesetzer($row->Fachvorgesetzer);
            $data[] = $abteilung;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->Login)) {
            return $this->logNullField($table, 'Login');
        } elseif (is_null($this->kuerzel)) {
            return $this->logNullField($table, 'kuerzel');
        } elseif (is_null($this->abteilung)) {
            return $this->logNullField($table, 'abteilung');
        } elseif (is_null($this->Abteilungsleiter)) {
            return $this->logNullField($table, 'Abteilungsleiter');
        } elseif (is_null($this->Fachvorgesetzer)) {
            return $this->logNullField($table, 'Fachvorgesetzer');
        }

        $data = array('kuerzel' => $this->kuerzel,
            'Login' => $this->Login,
            'abteilung' => $this->abteilung,
            'Abteilungsleiter' => $this->Abteilungsleiter->id,
            'Fachvorgesetzer' => $this->Fachvorgesetzer->id);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            return $this->update($data, "id = $this->id");
        }
    }

}

?>
