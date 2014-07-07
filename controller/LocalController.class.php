<?php
/**
* Admin index controller
*/
class LocalController extends ControllerAbstract
{
	function ajaxAction($params){
		if(count($params) == 1){
			echo Local::getSelectCidades($params[0]);
			exit;
		}else{
			App::errorPage('Erro');
		}
	}
}