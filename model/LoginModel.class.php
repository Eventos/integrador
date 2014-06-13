<?php

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
			$_SESSION['email'] = $data['email'];
			$_SESSION['name']  = $data['name'];
			Flash::setmessage('success','Bem Vindo'.$_SESSION['name']);
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
			$_SESSION['email'] = $data['email'];
			$_SESSION['name']  = $data['name'];
			Flash::setmessage('success','Bem vindo'.$_SESSION['name']);
			App::redirect('user/index');
		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			App::redirect('login/verify/user');
		}
	}
}
?>