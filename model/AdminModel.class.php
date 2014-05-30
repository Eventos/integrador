<?php
/**
* Evento que controla a parte de administração do sistema
*/
class AdminModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged(){
		if(isset($_SESSION['login'])){
			echo 'logado';
		}else{
			App::redirect('http://localhost/phpmyadmin');
		}
	}
	function Logged($post)
	{
		echo $post;
	}

}