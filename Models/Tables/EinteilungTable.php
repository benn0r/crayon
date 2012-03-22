<?php

class EinteilungTable extends BaseTable {

    public $table = 'Einteilung';
    private $id;
    private $Login;
    private $Person;
    private $Abteilung;
    private $von_jahr;
    private $von_kalenderwoche;
    private $bis_jahr;
    private $bis_kalenderwoche;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setPerson($row->Person);
            $this->setAbteilung($row->Abteilung);
            $this->setVonJahr($row->von_jahr);
            $this->setVonKalenderwoche($row->von_kalenderwoche);
            $this->setBisJahr($row->bis_jahr);
            $this->setBisKalenderwoche($row->bis_kalenderwoche);
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

    public function getPerson() {
        return $this->Person;
    }

    public function setPerson($Person) {
        $this->Person = new Person((int) $Person);
    }

    public function getAbteilung() {
        return $this->Abteilung;
    }

    public function setAbteilung($Abteilung) {
        $this->Abteilung = new Abteilung((int) $Abteilung);
    }

    public function getVonJahr() {
        return $this->von_jahr;
    }

    public function setVonJahr($von_jahr) {
        $this->von_jahr = $von_jahr;
    }

    public function getVonKalenderwoche() {
        return $this->von_kalenderwoche;
    }

    public function setVonKalenderwoche($von_kalenderwoche) {
        $this->von_kalenderwoche = $von_kalenderwoche;
    }

    public function getBisJahr() {
        return $this->bis_jahr;
    }

    public function setBisJahr($bis_jahr) {
        $this->bis_jahr = $bis_jahr;
    }

    public function getBisKalenderwoche() {
        return $this->bis_kalenderwoche;
    }

    public function setBisKalenderwoche($bis_kalenderwoche) {
        $this->bis_kalenderwoche = $bis_kalenderwoche;
    }


    public function fetchAll() {

        $data = array();
        $mysqli = $this->select("Login = $this->Login");

        while ($row = $mysqli->fetch_object()) {
            $einteilung = new Einteilung();
            $einteilung->setId($row->id);
            $einteilung->setLogin($row->Login);
            $einteilung->setPerson($row->Person);
            $einteilung->setAbteilung($row->Abteilung);
            $einteilung->setVonJahr($row->von_jahr);
            $einteilung->setVonKalenderwoche($row->von_kalenderwoche);
            $einteilung->setBisJahr($row->bis_jahr);
            $einteilung->setBisKalenderwoche($row->bis_kalenderwoche);
            $data[] = $einteilung;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->Login)) {
            return $this->logNullField($this->table, 'Login');
        } elseif (is_null($this->Person)) {
            return $this->logNullField($this->table, 'Person');
        } elseif (is_null($this->Abteilung)) {
            return $this->logNullField($this->table, 'Abteilung');
        } elseif (is_null($this->von_jahr)) {
            return $this->logNullField($this->table, 'von_jahr');
        } elseif (is_null($this->von_kalenderwoche)) {
            return $this->logNullField($this->table, 'von_kalenderwoche');
        } elseif (is_null($this->bis_jahr)) {
            return $this->logNullField($this->table, 'bis_jahr');
        } elseif (is_null($this->bis_kalenderwoche)) {
            return $this->logNullField($this->table, 'bis_kalenderwoche');
        }

        $data = array('Login' => $this->Login,
            'Person' => $this->Person,
            'Abteilung' => $this->Abteilung,
            'von_jahr' => $this->von_jahr,
            'von_kalenderwoche' => $this->von_kalenderwoche,
            'bis_jahr' => $this->bis_jahr,
            'bis_kalenderwoche' => $this->bis_kalenderwoche);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
