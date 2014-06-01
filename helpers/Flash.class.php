<?php 
/**
* Controla as mensagens Flash
*/
class Flash
{
	static function setMessage($type, $message){
		if(!isset($_COOKIE['messages'])){
			$_COOKIE['messages'] = array();
			$_COOKIE['messages'][0] = '<div class="alert alert-'.$type.'">'.$message.'</div>';
		}else{
			$key = count($finalMessage);
			$_COOKIE['messages'][$key] = '<div class="alert alert-'.$type.'">'.$message.'</div>';
		}
	}

	static function getMessage(){
		if(isset($_COOKIE['messages'])){
			foreach ($_COOKIE['messages'] as $message) {
				echo $message;
			}
			unset($_COOKIE['messages']);
		}
	}
}