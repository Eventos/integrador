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

	function logginUser($email , $password, $type = null, $id=null){

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
			if($type == 'inscricao')
				App::redirect('inscricao');
			elseif($type == 'execute')
				App::redirect('inscricao/execute/'.$id);
			else
				App::redirect('user/index');

		}
		else{
			Flash::setmessage('danger','Dados do login Invalidos');
			if($type == 'inscricao')
				App::redirect('login/verify/user');
			elseif($type == 'execute')
				App::redirect();
			else
				App::redirect('inscricao');

		}
	}
}
?>