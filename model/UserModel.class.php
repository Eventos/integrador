<?php
/**
* Evento que controla a parte do Usuario
*/
class UserModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_COOKIE['name'])){
			return true;
		}else{
			die('você não está logado!');
		}
	}

	function logout(){
		unset($_COOKIE['name']);
		unset($_COOKIE['email']);
		App::redirect(App::getUrl());
	}
}