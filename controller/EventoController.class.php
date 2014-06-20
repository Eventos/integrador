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
			$this->render('evento/evento');
			exit;
		}else{
			App::errorPage();
		}
	}
	
}