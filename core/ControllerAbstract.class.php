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
		if(strpos($view, 'evento') !== false && strpos($view , 'admin') === false){
			require_once(SITE_ROOT.'view/evento/header.phtml');
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			require_once(SITE_ROOT.'view/evento/footer.phtml');
		}
		elseif(strpos($view, 'admin') !== false && strpos($view, 'login') === false){
			require_once(SITE_ROOT.'view/admin/head.phtml');
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			require_once(SITE_ROOT.'view/admin/footer.phtml');
			
		}else{
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			
		}
	}
}