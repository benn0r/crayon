<?php

class SchulausbildungTable extends BaseTable {

    public $table = 'Schulausbildung';
    private $id;
    private $Login;
    private $name;
    private $adresse;
    private $zusatzadresse;
    private $postleitzahl;
    private $ort;
    private $Leiter;
    private $type;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setName($row->name);
            $this->setAdresse($row->adresse);
            $this->setZusatzadresse($row->zusatzadresse);
            $this->setPostleitzahl($row->postleitzahl);
            $this->setOrt($row->ort);
            $this->setLeiter($row->Leiter);
            $this->type = $this->getSchulausbildungType($this->id);
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

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getZusatzadresse() {
        return $this->zusatzadresse;
    }

    public function setZusatzadresse($zusatzadresse) {
        $this->zusatzadresse = $zusatzadresse;
    }

    public function getPostleitzahl() {
        return $this->postleitzahl;
    }

    public function setPostleitzahl($postleitzahl) {
        $this->postleitzahl = $postleitzahl;
    }

    public function getOrt() {
        return $this->ort;
    }

    public function setOrt($ort) {
        $this->ort = $ort;
    }

    public function getLeiter() {
        return $this->Leiter;
    }

    public function setLeiter($Leiter) {
        $this->Leiter = new Person((int) $Leiter);
    }

    public function getType() {
        return $this->type;
    }

    public function fetchAll($type) {

        $data = array();

        switch ($type) {
            case 1:
                $query = 'SELECT sa.* '
                        . 'FROM Schulausbildung sa '
                        . 'INNER JOIN Kurs ku ON ku.Kurs <> sa.ID '
                        . "WHERE sa.Login = $this->Login";
                break;
            case 2:
                $query = 'SELECT sa.* '
                        . 'FROM Schulausbildung sa '
                        . 'INNER JOIN Kurs ku ON ku.Kurs = sa.ID '
                        . "WHERE sa.Login = $this->Login";
                break;
        }

        $mysqli = $this->execute($query);
        while ($row = $mysqli->fetch_object()) {
            $schulausbildung = new Schulausbildung();
            $schulausbildung->setId($row->id);
            $schulausbildung->setLogin($row->Login);
            $schulausbildung->setName($row->name);
            $schulausbildung->setAdresse($row->adresse);
            $schulausbildung->setZusatzadresse($row->zusatzadresse);
            $schulausbildung->setPostleitzahl($row->postleitzahl);
            $schulausbildung->setOrt($row->ort);
            $schulausbildung->setLeiter($row->Leiter);
            $schulausbildung->type = $this->getSchulausbildungType($row->id);
            $data[] = $schulausbildung;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->name)) {
            return $this->logNullField($this->table, 'name');
        } elseif (is_null($this->Login)) {
            return $this->logNullField($this->table, 'login');
        } elseif (is_null($this->adresse)) {
            return $this->logNullField($this->table, 'adresse');
        } elseif (is_null($this->zusatzadresse)) {
            return $this->logNullField($this->table, 'zusatzadresse');
        } elseif (is_null($this->postleitzahl)) {
            return $this->logNullField($this->table, 'postleitzahl');
        } elseif (is_null($this->ort)) {
            return $this->logNullField($this->table, 'ort');
        } elseif (is_null($this->Leiter)) {
            return $this->logNullField($this->table, 'Leiter');
        }

        $data = array('name' => $this->name,
            'Login' => $this->Login,
            'adresse' => $this->adresse,
            'zusatzadresse' => $this->zusatzadresse,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'Leiter' => $this->Leiter->getId());

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

    private function getSchulausbildungType($id) {

        $kurs = new Kurs();
        $mysqli = $kurs->select("Kurs = $id");
        if($mysqli->num_rows > 0) {
            return false;
        }
        return true;
    }

}

?>
