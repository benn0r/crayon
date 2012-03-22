<?php

function __autoload($name){
    require_once $name.'.php';
}

set_include_path(get_include_path(). PATH_SEPARATOR . 'Controllers' .
        PATH_SEPARATOR .'Library' . PATH_SEPARATOR . 'Models' .
        PATH_SEPARATOR . 'Configuration' . PATH_SEPARATOR . 'Models/Tables');

session_start();

if (!$_GET['controller'])
{
    header('Location: index.php?controller=abteilung&action=index');
}

$ctrl = ucfirst($_GET['controller']) . 'Controller';
$action = $_GET['action'] . 'Action';
$_SESSION['LOGIN'] = 1;

require_once 'Controllers/' . $ctrl . '.php';

$obj = new $ctrl();
$obj->arguments = $_GET;
$obj->$action();


die(); //R.I.P

?>
