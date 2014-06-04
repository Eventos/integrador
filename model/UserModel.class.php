<?php
/**
* Evento que controla a parte do Usuario
*/
class UserModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_SESSION['name'])){
			return true;
		}else{
			die('você não está logado!');
		}
	}

	function logout(){
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		App::redirect(App::getUrl());
	}
}