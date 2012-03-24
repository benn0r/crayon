<?php

class AbteilungTable extends BaseTable {

    public $table = 'Abteilung';
    private $id;
    private $Login;
    private $kuerzel;
    private $abteilung;
    private $Abteilungsleiter;
    private $Fachvorgesetzter;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setKuerzel($row->kuerzel);
            $this->setAbteilung($row->abteilung);
            $this->setAbteilungsleiter($row->Abteilungsleiter);
            $this->setFachvorgesetzter($row->Fachvorgesetzter);
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

    public function setAbteilungsleiter($abteilungsleiter) {
        $this->Abteilungsleiter = new Person((int) $abteilungsleiter);
    }

    public function getFachvorgesetzter() {
        return $this->Fachvorgesetzter;
    }

    public function setFachvorgesetzter($fachvorgesetzter) {
        $this->Fachvorgesetzter = new Person((int) $fachvorgesetzter);
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
            $abteilung->setFachvorgesetzter($row->Fachvorgesetzter);
            $data[] = $abteilung;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->Login)) {
            return $this->logNullField($this->table, 'Login');
        } elseif (is_null($this->kuerzel)) {
            return $this->logNullField($this->table, 'kuerzel');
        } elseif (is_null($this->abteilung)) {
            return $this->logNullField($this->table, 'abteilung');
        } elseif (is_null($this->Abteilungsleiter)) {
            return $this->logNullField($this->table, 'Abteilungsleiter');
        } elseif (is_null($this->Fachvorgesetzter)) {
            return $this->logNullField($this->table, 'Fachvorgesetzter');
        }

        $data = array('kuerzel' => $this->kuerzel,
            'Login' => $this->Login,
            'abteilung' => $this->abteilung,
            'Abteilungsleiter' => $this->Abteilungsleiter->getId(),
            'Fachvorgesetzter' => $this->Fachvorgesetzter->getId());

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            return $this->update($data, "id = $this->id");
        }
    }

}

?>
