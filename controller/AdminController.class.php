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
			$this->render('admin/area_restrita');
		}else{
			App::errorPage('Erro');
		}
	}

	function logoutAction($params){
		$admin = new AdminModel();
		$admin->logout();
	}

	function eventosAction($params){

		if(count($params) == 0)
		{
			die('Listar eventos');
		}
		elseif(isset($params[0]) && $params[0] == 'new' && count($params) == 1)
		{
				$paramsView = Evento::newHelper();
				$this->render('admin/inserir_eventos', $paramsView);


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
		elseif(isset($params[0]) && $params[0] == 'edit')
		{
			echo 'bla';
			exit();
		}
		else
		{
			$this->render('error');
			exit();
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
			$this->render('error');
			exit();
		}
	}

	function blocosAction($params){
		if(count($params) == 0){
			die('list');
		}
		if(count($params) == 1 && $params[0] == 'edit'){
			die('edit');
		}
		if(count($params)==1 && $params[0] == 'new'){
			$this->render('admin/inserir_bloco');
			exit();
		}
		else{
			$this->render('error');
			exit();
		}
	}
}