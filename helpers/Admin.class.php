<?php
/**
* Helper para Administrador
*/
class Admin
{
	static function getId ($email){
		$id = new AdminModel();
		$id->getIdUserEvento($id_evento);
	}

	static function getMsg(){
		$msg = new AdminModel();
		$data = $msg->getAdmSession();
		return $msg->getMsg($data['id']);
	}

}