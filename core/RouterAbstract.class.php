<?php
/**
* Class que faz o roteamento da aplicação
*/
class RouterAbstract
{
	
	private $controller = '';
	private $action = '';
	private $params = array();
	private $routes = array();

	function __construct($url)
	{
		$params = explode('/', $url) ? explode('/', $url) : null;
		if($params != null){
			switch (count($params)) {
				case 1:
					$this->controller = $params[0];
					break;
				case 2:
					$this->controller = $params[0];
					$this->action = $params[1];
					break;
				default:
					$this->controller = $params[0];
					$this->action = $params[1];
					unset($params[0]);
					unset($params[1]);
					foreach ($params as $param) {
						$this->params[] = $param;
					}
					break;
			}
		}
	}

	function setRoutes(){
		return array();
	}
}