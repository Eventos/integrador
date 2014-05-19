<?php
ini_set('display_errors', 1);
require('core/App.php');
$app = new App();
Page::addStyleElement('css', 'bootstrap.css');
/*Page::addImage('erico.jpg', 'style="width: 100px;"');
*/$app->ready();
$app->renderTemplate('/index','');
