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
			$_SESSION['adm']['email'] = $data['email'];
			$_SESSION['adm']['name']  = $data['name'];
			Flash::setmessage('success','Bem Vindo'.$_SESSION['adm']['name']);
			App::redirect('admin/index');
		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			App::redirect('login/verify/admin');
		}

	}

	function logginUser($email , $password, $inscricao = null){

		$query = $this->db->query("SELECT email , senha, nome FROM usuario WHERE email= '$email' AND senha= '$password' ");
		$data = array();
		foreach($query as $result) {
			$data['email'] = $result['email'];
			$data['password'] = $result['senha'];
			$data['name'] = $result['nome'];
		}
		if (count($data) >= 2){
			$_SESSION['user']['email'] = $data['email'];
			$_SESSION['user']['name']  = $data['name'];
			Flash::setmessage('success','Bem vindo'.$_SESSION['user']['name']);
			if($inscricao == null)
				App::redirect('user/index');
			else
				App::redirect('inscricao');

		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			if($inscricao == null)
				App::redirect('login/verify/user');
			else
				App::redirect('inscricao');

		}
	}
}
?>