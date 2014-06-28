<?php
/**
* Inscricao index controller
*/
class InscricaoController extends ControllerAbstract
{
	function indexAction($params){
		if(count($params) <= 0){
			$inscricao = new UserModel();
			if($inscricao->islogged())
				$this->render('user/inscricao');
			else
				$this->render('login_user');
		}else{
			App::errorPage();
		}
	}

	function executeAction($params){
		
	}
}