<?php
/**
* Usuario index controller
*/
class UserController extends ControllerAbstract
{
	function indexAction($params){
		if(count($params) == 0){
			$user = new UserModel();
			$user->isLogged();
			$this->render('user/area_restrita');
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$user = new UserModel();
		$user->logout();
	}
}