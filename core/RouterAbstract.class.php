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
		if($params != null){
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
				$this->controller = $params[0];
				$this->action = 'index';
				break;
			case 2:
				$this->controller = $params[0];
				$this->action = $params[1];
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
		$call = new $controller;
		$action .= 'Action';
		$call->$action();
	}
}