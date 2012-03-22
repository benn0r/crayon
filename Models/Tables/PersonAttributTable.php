<?php

class PersonAttributTable extends BaseTable {

    public $table = 'Person_Attribut';
    private $id;
    private $attribut;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setAttribut($row->attribut);
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getAttribut() {
        return $this->attribut;
    }

    public function setAttribut($attribut) {
        $this->attribut = $attribut;
    }

    public function save() {

        if (is_null($this->attribut)) {
            return $this->logNullField($table, 'attribut');
        }

        $data = array('attribut' => $this->attribut);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
