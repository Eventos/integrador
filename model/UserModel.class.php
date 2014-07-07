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

	function user_letter($name, $email){
		try{
			$query = "INSERT INTO newsletter (nome, email) VALUES (:nome, :email)";
			$values = array(':nome' => $name,':email' => $email);

			$prep = $this->db->prepare($query);
			$prep->execute($values);
		}
		catch(PDOException $erro)
		{
			return false;
		}
		return true;
	}

	function getUserByEmail($email){
		$query = "SELECT * FROM usuario WHERE email = :email";
		$values = array(':email' => $email);
		$prep = $this->db->prepare($query);
		$prep->execute($values);
		$dataUser = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $dataUser[0];
	}

	function getUserById($id){
		$query = "SELECT * FROM usuario WHERE id_usuario = :id";
		$values = array(':id' => $id);
		$prep = $this->db->prepare($query);
		$prep->execute($values);
		$dataUser = $prep->fetch(PDO::FETCH_ASSOC);
		return $dataUser;
	}
}