<?php
/**
* Classe que controla a página home do site
*/
class IndexController extends ControllerAbstract
{	
	public function indexAction($params){
		$this->render('index');
	}

	public function testeAction($params){
		var_dump($params);
	}
}