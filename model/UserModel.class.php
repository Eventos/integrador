<?php
/**
* Evento que controla a parte do Usuario
*/
class UserModel extends ModelAbstract
{
	private $name;
	private $email;

	function isLogged($msg=null){
		if(isset($_SESSION['user']['name'])){
			return true;
		}else{
			if(!$msg == null){
				Flash::setMessage('danger', $msg);
			}
			return false;
		}
	}

	function logout(){
		unset($_SESSION['user']);
		App::redirect(App::getUrl());
	}

	function newAction($data) {

		$query = "INSERT INTO usuario (nome, cpf, data_nascimento, rg, email, id_cidade, senha, rua, bairro) VALUES (:nome, :cpf, :data_nascimento, :rg, :email, :id_cidade, :senha, :rua, :bairro)";
		$values = array(':nome' => $data['nome'],':cpf' => $data['cpf'],':data_nascimento' => $data['data_nascimento'],':rg' => $data['rg'],':email' => $data['email'],':id_cidade' => $data['cidade'],':senha' => $data['senha'],':rua' => $data['rua'],':bairro' => $data['bairro']);

		$prep = $this->db->prepare($query);
		$prep->execute($values);
		Flash::setMessage('success', 'Usuario Cadastrado com sucesso!');
		App::redirect('login/verify/user');
		exit;
	}
}