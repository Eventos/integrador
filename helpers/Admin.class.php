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

	static function getMsg($id_contact=null){
		$msg = new AdminModel();
		$data = $msg->getAdmSession();
		return $msg->getMsg($data['id'],$id_contact);
	}

}