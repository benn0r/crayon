<?php

class LoginTable extends BaseTable {

    public $table = 'Login';
    private $id;
    private $Kunde;
    private $admin;
    private $Person;

    public function __construct($id = null) {
        if (!is_null($id)) {

            $this->setId($id);
            $mysqli = $this->select("id = $this->id");

            $row = $mysqli->fetch_object();
            $this->setKunde($row->Kunde);
            $this->setAdmin($row->admin);
            $this->setPerson($row->Person);
        }
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = (int) $id;
    }

    public function getKunde() {
        return $this->Kunde;
    }

    public function setKunde($Kunde) {
        $this->kunde = $Kunde; //iiiirgendwann, von Kunde nehmen, buildby unso.
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    public function getPerson() {
        return $this->Person;
    }

    public function setPerson($Person) {
        $this->Person = new Person((int) $Person);
    }

    public function fetchAll() {

        $data = array();
        $mysqli = $this->select();

        while ($row = $mysqli->fetch_object()) {
            $login = new Login();
            $login->setId($row->id);
            $login->setAdmin($row->admin);
            $login->setPerson($row->Person);
            $data[] = $login;
        }

        return $data;
    }

    public function save() {

        if (is_null($this->admin)) {
            return $this->logNullField($this->table, 'admin');
        } elseif (is_null($this->Person)) {
            return $this->logNullField($this->table, 'Person');
        }

        $data = array('admin' => $this->admin,
            'Person' => $this->Person);

        if (is_null($this->id)) {
            return $this->insert($data);
        } else {
            $this->update($data, "id = $this->id");
        }
    }


}

?>
