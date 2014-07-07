<?php 
/**
* Controla as mensagens Flash
*/
class Flash
{
	static function setMessage($type, $message){
		if(!isset($_SESSION['messages'])){
			$_SESSION['messages'] = array();
			$_SESSION['messages'][0] = '<div class="alert alert-'.$type.'">'.$message.'</div>';
		}else{
			$key = count($_SESSION['messages']);
			$_SESSION['messages'][$key] = '<div class="alert alert-'.$type.'">'.$message.'</div>';
		}
	}

	static function getMessage(){
		if(isset($_SESSION['messages'])){
			foreach ($_SESSION['messages'] as $message) {
				echo $message;
			}
			unset($_SESSION['messages']);
		}
	}
}