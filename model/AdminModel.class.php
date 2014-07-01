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
		$nameAdm = $_SESSION['adm']['name'];
		$query = $this->db->query("SELECT id_administrador, nome FROM administrador WHERE nome = '$nameAdm'");
		$data = iterator_to_array($query);
		return array('id' => $data[0]['id_administrador'], 'name' => $data[0]['nome']);
	}

	function logout(){
		unset($_SESSION['adm']);
		App::redirect(App::getUrl());
	}
}