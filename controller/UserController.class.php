<?php
/**
* Usuario index controller
*/
class UserController extends ControllerAbstract
{
	function indexAction($params){
		if(count($params) == 0){
			$admin = new AdminModel();
			$admin->isLogged();
			$this->render('user/area_restrita');
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$admin = new AdminModel();
		$admin->logout();
	}
}