<?php

class BerufsbildController extends BaseController {

    public $berufsbilder = array();
    public $berufsbild;
    public $leiter = array();

    public function indexAction() {
        $berufsbild = new Berufsbild();
        $this->berufsbilder = $berufsbild->fetchAll();
        $this->view();
    }

    public function editAction() {
        if (!isset($_GET['id'])) {
            throw new Exception('ID wurde nicht mitgegeben.');
        }

        $this->berufsbild = new Berufsbild((int) $_GET['id']);

        if (!$this->berufsbild->idToLogin($this->berufsbild)) {
            throw new Exception('ID gehört nicht zu Login');
        }
        
        $person = new Person();
        $this->leiter = $person->fetchAll(7);
        $this->view();
    }

}

?>
