<?php
/**
* Admin index controller
*/
class AdminController extends ControllerAbstract
{
	function indexAction($params){
		$admin = new AdminModel();
		$admin->isLogged();
	}

	function testeAction($params){
		App::redirect('admin/teste1');
	}

	function teste1Action($params){
		echo 'teste1';
	}
}