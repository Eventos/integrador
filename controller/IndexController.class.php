<?php
/**
* Classe que controla a página home do site
*/
class IndexController extends ControllerAbstract
{	
	public function indexAction($params){
		if(count($params) <= 1){
			if(isset($params[0]) && $params[0] == 'eventos'){
				die('Página que exibe os eventos');
			}elseif(isset($params[0]) && $params[0] == 'index' || isset($params[0]) && $params[0] == ''){
				$this->render('index');
			}elseif (count($params) == 0){
				$this->render('index');
			}else{
				App::errorPage('Action para index não encontrada');
			}
			
		}elseif(count($params) == 2){

		}else{
			App::errorPage();
		}
	}

	public function testeAction($params){
		/*var_dump($params);*/
	}
	
}