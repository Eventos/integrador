<?php
/**
* Helper para Emails
*/
class Email
{
	static function sendMail($to, $subject, $message, $header=null){

		$state =  App::Send($to,$subject,$message, true);
		
		if($state){
			Flash::setMessage('success','Email(s) enviado(s) com Sucesso');
			return true;
		}else{
			Flash::setMessage('danger','Erro ao enviar email(s)...');
			return false;
		}
	}

	static function newsletter($email,$name,$message){
		if($message == null){
			$block = new Blocos();
			$message = $block->writer('novo_cadastro'); 
		}
		App::send($email, 'Bem Vindo ao Eventos UTFPR', $message, true);
		App::cookie(1);
	}
}