<?php
/**
* Helper para Emails
*/
class Email
{
	static function sendMail($to, $subject, $message, $header=null){

		$state =  App::Send($to,$subject,$message, $header);
		
		if($state){
			Flash::setMessage('success','Email(s) enviado(s) com Sucesso');
			return true;
		}else{
			Flash::setMessage('danger','Erro ao enviar email(s)...');
			return false;
		}
	}
}