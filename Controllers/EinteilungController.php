<?php

class EinteilungController extends BaseController {

    public $einteilungen = array();

    public function indexAction() {
        $einteilung = new Einteilung();
        $this->einteilungen = $einteilung->fetchAll();
        $this->view();
    }

    public function editAction() {
        if (!isset($_GET['id'])) {
            throw new Exception('ID wurde nicht mitgegeben.');
        }

        $einteilung = new Einteilung((int) $_GET['id']);

        if (!$einteilung->idToLogin($einteilung)) {
            throw new Exception('ID gehört nicht zu Login');
        }
        
        $this->einteilungen = $einteilung->fetchAll();
        $this->view();
    }

    public function deleteAction() {
        
    }

}

?>
