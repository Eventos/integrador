<?php
ini_set('display_errors', 1);
require('core/App.class.php');
$app = new App();
//die(var_dump($_GET['r']));
$router = new RouterAbstract($_SERVER['REQUEST_URI']);
