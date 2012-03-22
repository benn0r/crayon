<?php

class PersonTable extends BaseTable {

    public $table = 'Person';
    private $id;
    private $Login;
    private $Funktion;
    private $vorname;
    private $nachname;
    private $adresse;
    private $zusatzadresse;
    private $postleitzahl;
    private $ort;
    private $email;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setLogin($row->Login);
            $this->setFunktion($row->Funktion);
            $this->setVorname($row->vorname);
            $this->setNachname($row->nachname);
            $this->setAdresse($row->adresse);
            $this->setZusatzadresse($row->zusatzadresse);
            $this->setPostleitzahl($row->postleitzahl);
            $this->setOrt($row->ort);
            $this->setEmail($row->email);
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

    public function getFunktion() {
        return $this->Funktion;
    }

    public function setFunktion($Funktion) {
        $this->Funktion = new Funktion((int) $Funktion);
    }

    public function getName() {
        return $this->vorname . ' ' . $this->nachname;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    public function getNachname() {
        return $this->nachname;
    }

    public function setNachname($nachname) {
        $this->nachname = $nachname;
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function fetchAll($type) {

        $data = array();
        $where = "Login = $this->Login AND (";

        switch ($type) {
            case 1:
                $where.="Funktion = $type)";
                break;
            case 2:
                $where.="Funktion = $type)";

                break;
            case 3:
                $where.="Funktion = $type)";

                break;
            case 4:
                $where.="Funktion = $type)";

                break;
            case 5:
                $where.="Funktion = $type)";

                break;
            case 6:
                $where.="Funktion = $type)";

                break;
            case 7:
                $where.='Funktion = ' . Configuration::BERUFSBILDNER
                        . ' OR Funktion = ' . Configuration::FACHVORGESETZTER
                        . ' OR Funktion = ' . Configuration::ABTEILUNGSLEITER . ')';
                break;
            case 8:
                $where.='Funktion = ' . Configuration::SCHULLEITER
                        . ' OR Funktion = ' . Configuration::KURSLEITER . ')';
                break;
        }

        $mysqli = $this->select($where);

        while ($row = $mysqli->fetch_object()) {
            $person = new Person();
            $person->setId($row->id);
            $person->setLogin($row->Login);
            $person->setFunktion($row->Funktion);
            $person->setVorname($row->vorname);
            $person->setNachname($row->nachname);
            $person->setAdresse($row->adresse);
            $person->setZusatzadresse($row->zusatzadresse);
            $person->setPostleitzahl($row->postleitzahl);
            $person->setOrt($row->ort);
            $person->setEmail($row->email);
            $data[] = $person;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->Funktion)) {
            return $this->logNullField($table, 'Funktion');
        } elseif (is_null($this->Login)) {
            return $this->logNullField($table, 'Login');
        } elseif (is_null($this->vorname)) {
            return $this->logNullField($table, 'vorname');
        } elseif (is_null($this->nachname)) {
            return $this->logNullField($table, 'nachname');
        } elseif (is_null($this->adresse)) {
            return $this->logNullField($table, 'adresse');
        } elseif (is_null($this->zusatzadresse)) {
            return $this->logNullField($table, 'zusatzadresse');
        } elseif (is_null($this->postleitzahl)) {
            return $this->logNullField($table, 'postleitzahl');
        } elseif (is_null($this->ort)) {
            return $this->logNullField($table, 'ort');
        } elseif (is_null($this->email)) {
            return $this->logNullField($table, 'email');
        }

        $data = array('Funktion' => $this->Funktion,
            'vorname' => $this->vorname,
            'nachname' => $this->nachname,
            'adresse' => $this->adresse,
            'zusatzadresse' => $this->zusatzadresse,
            'postleitzahl' => $this->postleitzahl,
            'ort' => $this->ort,
            'email' => $this->email);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
