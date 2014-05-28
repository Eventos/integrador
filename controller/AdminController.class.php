<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function testeAction($params){
		if(!count($params)){
			$this->render('inserir_eventos');
		}
	}
}