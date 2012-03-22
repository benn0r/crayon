<?php

class PersonController extends BaseController {

    public $personen = array();
    public $person;

    public function indexAction() {
        if (!isset($_GET['type'])) {
            throw new Exception('Type wurde nicht mitgegeben');
        }
        $type = (int) $_GET['type'];

        $person = new Person();

        switch ($type) {
            case 1:
                $this->personen = $person->fetchAll($type);
                break;
            case 2:
                $this->personen = $person->fetchAll($type);
                break;
            case 3:
                $this->personen = $person->fetchAll($type);
                break;
            case 4:
                $this->personen = $person->fetchAll($type);
                break;
            case 5:
                $this->personen = $person->fetchAll($type);
                break;
            case 6:
                $this->personen = $person->fetchAll($type);
                break;
            default:
                throw new Exception('Personen Typ nicht gefunden');
        }
        
        $this->view();
    }

    public function editAction() {
        $this->person = new Person($_GET['id']);
        $this->view();
    }

}

?>
