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
			return false;
		}
	}

	function getAdmSession(){
		$emailAdm = $_SESSION['adm']['email'];
		$query = $this->db->query("SELECT id_administrador, nome FROM administrador WHERE email = '$emailAdm'");
		$data = iterator_to_array($query);
		return array('id' => $data[0]['id_administrador'], 'name' => $data[0]['nome']);
	}

	function logout(){
		unset($_SESSION['adm']);
		App::redirect(App::getUrl());
	}

	function getIdUserEvento($id_evento){
		$query = $this->db->query("SELECT id_administrador FROM evento WHERE id_evento = '$id_evento'");
		$id = $query->fetch(PDO::FETCH_NUM);
		if(isset($id[0])){
			return $id[0];
		}
		return false;
	}
	
	function verifyMsg($email){
		$query = $this->db->query("SELECT id_administrador FROM administrador WHERE email = '$email'");
		$id = $query->fetch(PDO::FETCH_NUM);
		if(isset($id[0])){
			$query = $this->db->query("SELECT id_contato FROM contato WHERE id_administrador = '$id[0]' and resposta = 'n'");
			$qnt_msg = count($query->fetchAll(PDO::FETCH_NUM));
			//Flash::setMessage('warning','Você tem '.$qnt_msg.' Mensagens não lidas');
			return $qnt_msg;
		}else{
			return false;
		}
	}

	function getMsg($id_admin,$id_contact=null){
		try{
			if($id_contact===null)
				$query = $this->db->query("SELECT * FROM contato WHERE id_administrador = '$id_admin' and resposta = 'n'");	
			else
				$query = $this->db->query("SELECT * FROM contato WHERE id_administrador = '$id_admin' and id_contato = '$id_contact' and resposta = 'n'");	

		}catch(Exception $e){
			return false;
		}
		$data = $query->fetchAll(PDO::FETCH_NUM);
		return $data;
	}

	function getAllEmailsAdm(){
		$query = $this->db->query("SELECT email FROM administrador");
		$emails = $query->fetchAll(PDO::FETCH_ASSOC);
		return $emails;
	}
}