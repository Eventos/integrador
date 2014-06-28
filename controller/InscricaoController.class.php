<?php
/**
* Inscricao index controller
*/
class InscricaoController extends ControllerAbstract
{
	function indexAction($params){
		$info = array('type' => 'inscricao');
		if(count($params) <= 0){
			$inscricao = new UserModel();
			if($inscricao->islogged())
				$this->render('user/inscricao');
			else{
				$this->render('login_user', $info);
			}
		}else{
			App::errorPage();
		}
	}

	function executeAction($params){
		if(count($params) == 1){
			$inscricao = new UserModel();
			if($inscricao->islogged())
				$this->render('user/inscricao');
			else
				$this->render('login_user');
		}elseif(count($params)==2){
			
		}else{
			App::errorPage();
		}
	}
}