<?php
/**
* Evento que controla a parte de administração do sistema
*/
class AdminModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_SESSION['adm']['name'])){
			return true;
		}else{
			Flash::setMessage('danger', 'Ops, algo incorreto! Parece que voce não está logado');
			App::redirect('login/verify/admin');
			return false;
		}
	}

	function logout(){
		unset($_SESSION['adm']);
		App::redirect(App::getUrl());
	}
}