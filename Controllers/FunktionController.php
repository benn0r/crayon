<?php

class FunktionController extends BaseController{

    public $funktionen = array();

    public function indexAction(){
        $funktion = new Funktion();
        $this->funktionen = $funktion->fetchAll();
        $this->view();
    }
    
}

?>
