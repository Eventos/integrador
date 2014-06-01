<?php
/*define('SEL_ADM', 
	'SELECT email , senha FROM administrador WHERE email=(:email) AND senha=(:senha)');
define('SEL_USR', 
	'SELECT email , senha FROM usuario WHERE email=(:email) AND senha=(:senha)');*/

class LoginModel extends ModelAbstract{
	
	function logginAdm($email , $senha){
		$query = $this->db->query("SELECT email , senha, nome FROM administrador WHERE email= '$email' AND senha= '$senha' ");
		$data = array();
		foreach($query as $result) {
			$data['email'] = $result['email'];
			$data['password'] = $result['senha'];
			$data['name'] = $result['nome'];
		}
		if (count($data) >= 2){
			session_start();
			$_COOKIE['email'] = $data['email'];
			$_COOKIE['name']  = $data['name'];

			Flash::setmessage('success','Bem Vindo'.$_COOKIE['name']);
			App::redirect('admin/index');
		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			App::redirect('login/verify/admin');
		}

	}

	function logginUser($email , $password){

		$query = $this->db->query("SELECT email , senha, nome FROM usuario WHERE email= '$email' AND senha= '$password' ");
		$data = array();
		foreach($query as $result) {
			$data['email'] = $result['email'];
			$data['password'] = $result['senha'];
			$data['name'] = $result['nome'];
		}
		if (count($data) >= 2){
			session_start();
			$_COOKIE['email'] = $data['email'];
			$_COOKIE['name']  = $data['name'];
			Flash::setmessage('success','Bem vindo'.$_COOKIE['name']);
			App::redirect('admin/index');
		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			App::redirect('login/verify/user');
		}
	}
}
?>