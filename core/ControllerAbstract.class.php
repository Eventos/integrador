<?php
/**
* Classe base para futuros controladores
*/
class ControllerAbstract
{
	public $db;

	function __construct(){
		$this->db = DbAbstract::openConnect();
	}

	function render($view, $params = null){
		if($params != null){
			extract($params);
		}
		require_once(SITE_ROOT.'view/'.$view.'.phtml');
	}
}