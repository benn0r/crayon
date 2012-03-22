<?php

class SchuleTable extends BaseTable {

    public $table = 'Schule';
    private $id;
    private $Berufsbild;
    private $Schulausbildung;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setBerufsbild($row->Berufsbild);
            $this->setSchulausbildung($row->Schulausbildung);
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getBerufsbild() {
        return $this->Berufsbilder;
    }

    public function setBerufsbild($Berufsbild) {
        $this->Berufsbilder = new Berufsbild((int) $Berufsbild);
    }

    public function getSchulausbildung() {
        return $this->Schulausbildung;
    }

    public function setSchulausbildung($Schulausbildung) {
        $this->Schulausbildung = new Schulausbildung((int) $Schulausbildung);
    }

    public function save() {

        if (is_null($this->Berufsbild)) {
            return $this->logNullField($table, 'Berufsbild');
        } elseif (is_null($this->Schulausbildung)) {
            return $this->logNullField($table, 'Schulausbildung');
        }

        $data = array('Berufsbild' => $this->Berufsbild,
            'Schulausbildung' => $this->Schulausbildung);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>