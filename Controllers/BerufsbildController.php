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

    public function addAction() {
        $person = new Person();
        $this->leiter = $person->fetchAll(7);
        $this->view();
    }

    public function createAction() {

        $berufsbild = new Berufsbild();
        $berufsbild->setBerufsbild($_POST['txtBerufsbild']);
        $berufsbild->setKuerzel($_POST['txtKuerzel']);
        $berufsbild->setDauer($_POST['txtDauer']);
        $berufsbild->setBerufsbildner($_POST['ddlBerufsbildner']);
        
        $berufsbild->save();
        header('Location: ?controller=berufsbild&action=index');
    }

}

?>
