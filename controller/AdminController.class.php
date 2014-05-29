<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function indexAction($params){
		$admin = new $params['model'];
		echo 'index';
	}

	function testeAction($params){
		var_dump($params);
		echo 'teste';
	}
}