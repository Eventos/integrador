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
			App::redirect(App::getUrl().'index/login/admin');
		}
	}

	function logout(){
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		App::redirect(App::getUrl());
	}
}