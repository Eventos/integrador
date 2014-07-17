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
			App::redirect('user/eventos');
		}else{
			App::errorPage('Erro');
		}
	}

	function inscricaoAction($params){
		if(count($params) == 0){
			$user = new UserModel();
			$this->render('user/user_inscricao');
		}elseif(count($params) == 1 && $params[0] == 'post'){
			$inscricao = new UserModel();
			$inscricao->newAction($_POST);
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$user = new UserModel();
		$user->logout();
	}

	function eventosAction($params){
		$params = User::listarEventosInscritos();
		$this->render('user/eventos', $params, 'user');
	}
}