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
				$this->render('user/list_inscricao');
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
			if($inscricao->islogged()){
				$paramsview['id_evento'] = $params[0];
				$this->render('user/inscricao',$paramsview);
			}
			else{
				$type = Array('inscricao'=>'execute','id_inscricao'=>$params[0]);
				$this->render('login_user',$type);
			}
		}elseif(count($params)==2){
			
		}else{
			App::errorPage();
		}
	}

	function paymentAction($params){
		$inscricao = new InscricaoModel();
		$inscricao->inscricao($_POST);
		exit;
	}
}