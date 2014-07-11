<?php
ini_set('display_errors', 1);
require('core/App.class.php');
$app = new App();
$app->ready();
if(!isset($_COOKIE['boas_vindas'])){
	$app->cookie('0');
}
$router = new RouterAbstract ($_SERVER['REQUEST_URI']);

