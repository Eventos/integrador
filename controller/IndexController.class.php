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
	public function loginAction($params){
		$this->render('login');
	}
	public function logarAction($params){
		$var = $_POST;
		var_dump($var);
	}
}