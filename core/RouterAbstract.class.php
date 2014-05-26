<?php
/**
* Class que faz o roteamento da aplicação
*/
class RouterAbstract
{
	
	private $controller = '';
	private $action = '';
	private $params = array();

	function __construct($url)
	{
		$params = explode('/', $url) ? explode('/', $url) : null;
		unset($params[0]); unset($params[1]);
		
		if($params != null && !empty($params[2]) && $params[2] != ''){
			$this->calcRoutes($params);
		}else{
			$this->controller = 'index';
			$this->action = 'index';
		}

		$this->call($this->controller, $this->action, $this->params);
	}

	private function calcRoutes($params){
		switch (count($params)) {
			case 1:
				$this->controller = $params[2];
				$this->action = 'index';
				break;
			case 2:
				$this->controller = $params[2];
				$this->action = $params[3];
				break;
			default:
				$this->controller = $params[2];
				$this->action = $params[3];
				unset($params[2]);
				unset($params[3]);
				foreach ($params as $param) {
					$this->params[] = $param;
				}
				break;
		}
	}

	private function call($controller, $action, $params){
		$controller = ucwords($controller).'Controller';
		if(file_exists(SITE_ROOT.'controller/'.ucwords($controller).'.class.php')){
			$call = new $controller;	
			$action .= 'Action';
			if(method_exists($call, $action)){
				$call->$action($this->params);
			}else{
				$this->errorPage();	
			}
		}else{
			$this->errorPage();
		}
	}

	private function errorPage(){
		//RENDERIZAR PAGINA NAO ENCONTRADA
		die("Ops, página não encontrada");
	}
}