<?php

class SchulausbildungController extends BaseController {

    public $schulausbildungen = array();
    public $schulausbildung;
    public $leiter = array();
    
    public function indexAction() {
        if (!isset($_GET['type'])) {
            throw new Exception('Type wurde nicht mitgegeben');
        }
        $type = (int) $_GET['type'];

        $schulausbildung = new Schulausbildung();

        switch ($type) {
            case 1:
                $this->schulausbildungen = $schulausbildung->fetchAll($type);
                break;
            case 2:
                $this->schulausbildungen = $schulausbildung->fetchAll($type);
                break;
            default:
                throw new Exception('Personen Typ nicht gefunden');
        }

        $this->view();
    }

    public function editAction() {
        if (!isset($_GET['id'])) {
            throw new Exception('ID wurde nicht mitgegeben.');
        }

        $this->schulausbildung = new Schulausbildung((int) $_GET['id']);

        if (!$this->schulausbildung->idToLogin($this->schulausbildung)) {
            throw new Exception('ID gehört nicht zu Login');
        }
        
        $person = new Person();
        $this->leiter = $person->fetchAll(8);
        $this->view();
    }

}

?>
