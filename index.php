<?php
ini_set('display_errors', 1);
require('core/App.class.php');
$app = new App();
//die(var_dump($_GET['r']));
if($_GET['r']){
	$router = new RouterAbstract($_GET['r']);
}