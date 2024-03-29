<?php

class AbteilungController extends BaseController {

    public $abteilungen = array();
    public $abteilung;
    public $leiter = array();

    public function indexAction() {
        $abteilung = new Abteilung();
        $this->abteilungen = $abteilung->fetchAll();
        $this->view();
    }

    public function editAction() {
        if (!isset($_GET['id'])) {
            throw new Exception('ID wurde nicht mitgegeben.');
        }

        $this->abteilung = new Abteilung((int) $_GET['id']);
        
        if (!$this->abteilung->idToLogin($this->abteilung)) {
            throw new Exception('ID gehört nicht zu Login');
        }
        
        $person = new Person();
        $this->leiter = $person->fetchAll(7);
        
        $this->view();
    }
    
    public function addAction(){
        $person = new Person();
        $this->leiter = $person->fetchAll(7);
        $this->view();
    }
    
    public function createAction(){
        
        $abteilung = new Abteilung();
        $abteilung->setAbteilung($_POST['txtAbteilung']);
        $abteilung->setKuerzel($_POST['txtKuerzel']);
        $abteilung->setFachvorgesetzter((int)$_POST['ddlFachvorgesetzter']);
        $abteilung->setAbteilungsleiter((int)$_POST['ddlAbteilungsleiter']);
        
        $abteilung->save();
        header('Location: ?controller=abteilung&action=index');
        
    }

}

?>
