<?php
/**
* Helper para eventos
*/
class User
{
	static function listarEventosInscritos(){
		$email_user = $_SESSION['user']['email'];
		$user = new UserModel();
		$user = $user->getUserByEmail($email_user);

		$inscricoes = new InscricaoModel();
		$inscricoes = $inscricoes->inscricoesPorUsuario($user['id_usuario']);
		
		return $inscricoes;
	}
}