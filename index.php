<?php
ini_set('display_errors', 0);
require('core/App.class.php');
$app = new App();
$app->ready();
$router = new RouterAbstract ($_SERVER['REQUEST_URI']);

