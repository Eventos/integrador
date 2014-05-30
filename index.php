<?php
ini_set('display_errors', 1);
require('core/App.class.php');
$app = new App();
$router = new RouterAbstract ($_SERVER['REQUEST_URI']);

