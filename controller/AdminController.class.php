<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function indexAction($params){
		if(count($params) == 0){
			$admin = new AdminModel();
			if($admin->isLogged()){
				$admin->verifyMsg($_SESSION['adm']['email']);
				$this->render('admin/area_restrita');
			}else{
				$this->render('admin/login_admin');
			}	
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$admin = new AdminModel();
		$admin->logout();
	}

	function subeventosAction($params){
		if(isset($params[0]) && count($params) == 1 && $params[0] == 'list'){
			$paramsView = Evento::newHelper();
			$this->render('admin/subeventos_list', $paramsView);
		}
		elseif(isset($params[0]) && count($params) == 2 && isset($params[1]) && $params[1] == 'new')
		{
			$paramsView = Evento::SubEventoNewHelper();
			$paramsView['id_evento'] = $params[0];
			$this->render('admin/inserir_subevento', $paramsView);
		}elseif(isset($params[0]) && count($params) == 3 && isset($params[1]) && $params[1] == 'new' && $params[2] == 'post')
		{
			$subevento = new SubeventoModel();
			$subevento->newAction($params[0], $_POST);
		}
		elseif(isset($params[0]) && $params[0] == 'media' && count($params) == 2
				&& isset($params[1]))
		{
			$paramsView = Evento::mediaHelper($params[1], 'subeventos');
			$this->render('admin/inserir_media', $paramsView);
		}
		elseif(isset($params[0]) && $params[0] == 'media' && count($params) == 3
				&& isset($params[1]) && $params[2] == 'post')
		{
			$evento = new SubeventoModel();
			$evento->insertMedia($params[1], $_POST, isset($_FILES) ? $_FILES : NULL);
		}
		elseif(isset($params[0]) && $params[0] == 'delete' && count($params) == 2 && isset($params[1]))
		{
			$evento = new SubeventoModel();
			$evento->deleteAction($params[1]);
		}
		else{
			App::errorPage();
		}
		exit();
	}

	function eventosAction($params){

		if(count($params) == 0)
		{
			$paramsView = Evento::newHelper();
			$this->render('admin/eventos_list', $paramsView);
		}

		elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 1)
		{
			$paramsView = Evento::newHelper();
			$this->render('admin/inserir_eventos', $paramsView);
		}
		elseif(isset($params[0]) && $params[0] == 'list' && count($params) == 1)
		{
			$paramsView = Evento::newHelper();
			$this->render('admin/eventos_list', $paramsView);
		}
		elseif(isset($params[0]) && $params[0] == 'media' && count($params) == 2
				&& isset($params[1]))
		{
			$paramsView = Evento::mediaHelper($params[1]);
			$this->render('admin/inserir_media', $paramsView);
		}
		elseif(isset($params[0]) && $params[0] == 'media' && count($params) == 3
				&& isset($params[1]) && $params[2] == 'post')
		{
			$evento = new EventoModel();
			$evento->insertMedia($params[1], $_POST, isset($_FILES) ? $_FILES : NULL);
		}
		elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 2 && isset($params[1]) && $params[1] == 'post')
		{
			$evento = new EventoModel();
			$evento->newAction($_POST);
		}
		elseif(isset($params[0]) && $params[0] == 'delete' && count($params) == 2 && isset($params[1]))
		{
			$evento = new EventoModel();
			$evento->deleteAction($params[1]);
		}
		else
		{
			App::errorPage();
		}
		exit;
}
	function palestrantesAction($params){
		if(count($params) == 0){
			die("Exibir palestrantes");
		}elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 1){
			if($params[0] == 'new'){
				$paramsView = Palestrante::newHelper();
				$this->render('admin/inserir_palestrante', $paramsView);
			}
		}elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 2 && $params[1] == 'post'){
			$palestrante = new PalestranteModel();
			if(isset($_POST['estados'])){
				unset($_POST['estados']);	
			}
			$palestrante->newAction($_POST);
		}else{
			App::errorPage();
		}
	}

	function blocosAction($params){
		if(count($params) == 0){
			$this->render('admin/listar_blocos');
			exit;
		}
		elseif(isset($params) && count($params) == 1 && $params[0] == 'edit'){
			die('edit');
		}
		elseif(isset($params) && count($params)== 1 && $params[0] == 'new'){
			$this->render('admin/inserir_bloco');
			exit();
		}
		elseif(isset($params) && count($params) == 2 && $params[0] == 'new' && $params[1] == 'post' ) {
			$block = new BlocosModel();
			$block->newAction($_POST);
		}
		else{
			App::errorPage();
		}
	}
}