<?php
ini_set('display_errors', 1);
require('core/App.class.php');
$app = new App();
Page::addStyleElement('css', 'bootstrap.css');
$app->ready();
$app->renderTemplate('/index','');
