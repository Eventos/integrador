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

	function eventosAction($params){
		if(count($params) == 0){
			die('Listar eventos');
		}elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 1){
			if($params[0] == 'new'){
				$paramsView = Evento::newHelper();
				$this->render('admin/inserir_eventos', $paramsView);
			}
		}elseif(isset($params[0]) && $params[0] == 'media' && count($params) == 2
				&& isset($params[1])){
			die('a');
		}
	}
}