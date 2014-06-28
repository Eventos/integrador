<?php
/**
* Evento que controla a parte do Usuario
*/
class UserModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_SESSION['user']['name'])){
			return true;
		}else{
			Flash::setMessage('danger', 'Ops, algo incorreto! Parece que voce não está logado');
			App::redirect('login/verify/user');
			return false;
		}
	}

	function logout(){
		unset($_SESSION['user']);
		App::redirect(App::getUrl());
	}
}