<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function testeAction($params){
		if(!count($params)){
			$this->render('area_admin');
		}
	}
}