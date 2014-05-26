<?php
/**
* Classe base para futuros controladores
*/
class ControllerAbstract
{
	function render($view){
		require_once(SITE_ROOT.'view/'.$view.'.phtml');
	}
}