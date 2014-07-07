<?php
/**
* Helper para Emails
*/
class Email
{
	static function sendMail($to, $subject, $message, $header=null){

		return $state =  App::Send($to,$subject,$message, $header);
		
		if($state){
			Flash::getMessage('success','Email(s) enviado(s) com Sucesso');
		}else{
			Flash::setMessage('danger','Erro ao enviar email(s)...');
		}
		App::redirect('admin/index');
		exit;
	}
}