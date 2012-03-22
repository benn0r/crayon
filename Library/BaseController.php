<?php

class BaseController {

    public $arguments = array();

    public function view()
    {
        require_once 'Views/Layout.phtml';
    }
    
    

}

?>
