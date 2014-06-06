<?php
/**
* Evento que controla a parte de administração do sistema
*/
class AdminModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_SESSION['name'])){
			return true;
		}else{
			var_dump($_SESSION); exit;
			Flash::setMessage('danger', 'Ops, algo incorreto!');
			App::redirect(App::getUrl().'login/verify/admin');
		}
	}

	function logout(){
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		App::redirect(App::getUrl());
	}
}