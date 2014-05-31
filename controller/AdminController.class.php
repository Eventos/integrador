<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function indexAction($params){
		if(count($params) == 0){
			$admin = new AdminModel();
			$admin->isLogged();
			$this->render('admin/area_admin');
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$admin = new AdminModel();
		$admin->logout();
	}
}