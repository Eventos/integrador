<?php
/**
* Classe que controla a página home do site
*/
class EventoController extends ControllerAbstract
{	
	public function indexAction($params){

		if(count($params) == 0){
			$this->render('evento/listar_eventos');
			exit;
		}else{
			App::errorPage();
		}
	}

	public function viewAction($params){

		if(isset($params) && count($params) == 1){
			$this->render('evento/evento',$params);
			exit;
		}elseif(count($params)==2){
			$this->render('evento/subevento',$params);
			exit;
		}else{
			App::errorPage();
		}
	}
	public function mensagemAction(){

		if(isset($_POST)){
			$id_admin = new AdminModel();
			$data = array('name'=>$_POST['name'], 'email'=>$_POST['email'],'evento'=> $_POST['evento'], 'message'=> $_POST['mensagem'],'id_admin'=>$id_admin->getIdUserEvento($_POST['evento']));
			$msg = new EventoModel();
			if($msg->sendMsg($data)){
				Flash::setMessage('success','Mensagem Enviada com Sucesso!');
			}else{
				Flash::setMessage('danger','Erro ao Enviar Mensagem!');
			}
			header('location:'.App::getUrl().'index');
			exit();
		}else{
			Flash::setMessage('danger','Erro Ao enviar mensagem!');
			header('location:'.App::getUrl().'index');
			exit();
		}

	}
	
}