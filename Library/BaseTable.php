<?php

abstract class BaseTable extends BaseModel {

    public abstract function save();
    
    public function logNullField($table,$field){
    //Tu ganz wichtige dinge.
        echo '!!!!!!!FEHLOHR!!!!!!!';
        return -1;
        
    }

}

?>
