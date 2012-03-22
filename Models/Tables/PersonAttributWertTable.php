<?php

class PersonAttributWertTable extends BaseTable {

    public $table = 'Person_Attribut_Wert';
    private $id;
    private $Person;
    private $Attribut;
    private $wert;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setPerson($row->Person);
            $this->setAttribut($row->Attribut);
            $this->setWert($row->wert);
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getPerson() {
        return $this->Person;
    }

    public function setPerson($Person) {
        $this->Person = new Person((int) $Person);
    }

    public function getAttribut() {
        return $this->Attribut;
    }

    public function setAttribut($Attribut) {
        $this->Attribut = new PersonAttribut((int) $Attribut);
    }

    public function getWert() {
        return $this->wert;
    }

    public function setWert($wert) {
        $this->wert = $wert;
    }

    public function save() {

        if (is_null($this->Person)) {
            return $this->logNullField($table, 'Person');
        } elseif (is_null($this->Attribut)) {
            return $this->logNullField($table, 'Attribut');
        } elseif (is_null($this->wert)) {
            return $this->logNullField($table, 'wert');
        }

        $data = array('Person' => $this->Person,
            'Attribut' => $this->Attribut,
            'wert' => $thise->wert);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }


}

?>
