<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function indexAction($params){
		$admin = new $params['model'];
		$admin->isLogged();
	}

	function testeAction($params){
		echo 'teste';
	}
}