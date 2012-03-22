<?php

class KursTable extends BaseTable {

    public $table = 'Kurs';
    private $id;
    private $Schulausbildung;
    private $Kurs;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->Schulausbildung = $row->Schulausbildung;
            $this->Kurs = $row->Kurs;
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getSchulausbildung() {
        return $this->Schulausbildung;
    }

    public function setSchulausbildung($Schulausbildung) {
        $this->Schulausbildung = new Schulausbildung((int) $Schulausbildung);
    }

    public function getKurs() {
        return $this->Kurs;
    }

    public function setKurs($Kurs) {
        $this->Kurs = new Schulausbildung((int) $Kurs);
    }

    public function save() {

        if (is_null($this->Schulausbildung)) {
            return $this->logNullField($table, 'Schulausbildung');
        } elseif (is_null($this->Kurs)) {
            return $this->logNullField($table, 'Kurs');
        }

        $data = array('Schulausbildung' => $this->Schulausbildung,
            'Kurs' => $this->Kurs);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }

}

?>
