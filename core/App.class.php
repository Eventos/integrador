<?php
/**
* Classe base da aplicação
*/
class App
{
	function __construct($root=null){
		$this->config($root);
		spl_autoload_register(array($this, 'autoloader'));
	}

	private function config($root=null){
		if($root){
			require_once($root.'config/config.php');
		}else{
			require_once('config/config.php');
		}		
	}

	function autoloader($class){
		$file = '';
		if(strpos($class, 'Model')){
			$file = SITE_ROOT.'model/'.$class.'.class.php';
		}elseif(strpos($class,'Controller')){
			$file = SITE_ROOT.'controller/'.$class.'.class.php';
		}elseif(strpos($class, 'Abstract')){
			$file = SITE_ROOT.'core/'.$class.'.class.php';
		}else{
			$file = SITE_ROOT.'helpers/'.$class.'.class.php';
		}

		if(file_exists($file)){
			require_once($file);
		}
	}

	static function ready(){
		App::start_session();
		Flash::getMessage();
	}

	static function getUrl($comp=null){
		if($comp != null){
			return URL_BASE.$comp;
		}
		return URL_BASE;
	}

	static function errorPage($msg = null){
		Flash::setMessage('danger',$msg);
		require_once(SITE_ROOT.'view/error.phtml');
		exit;
	}

	static function redirect($url){
		if(strpos($url, 'http://') === false){
			header('Location: '.URL_BASE.$url);
		}else{
			header("Location: $url");
		}
	}

	static function start_session(){
		if(!isset($_SESSION))
			SESSION_START();
	}

	static function cookie($valor){
		$time = time()+3600*24*30*12*5;
		if(!isset($_COOKIE["boas_vindas"])){
			setcookie('boas_vindas','0', $time);
		}else{
			unset($_COOKIE['boas_vindas']);
			setcookie('boas_vindas',$valor, $time);
		}
	}

	static function append($view){
		require_once(SITE_ROOT.'view/'.$view.'.phtml');
	}

	static function getHeaders(){
		$header = "MIME-Version: 1.0\n"; 
		$header .= "Content-type: text/html; charset=iso-8859-1\n"; 
		$header .= "From: eventosutfpr@yahoo.com\n";
		return $header;
	}

	static function send($to, $subject, $msg, $headers=true){
		if($headers == true){
			$headers = self::getHeaders();
		}
		$aux = true;
		$subject = htmlentities($subject, ENT_QUOTES,'UTF-8');
		if (is_array($to)){
			foreach ($to as $t) {
				$aux = mail($t, $subject, $msg, $headers)? true : false;		
				if($aux === false){
					Flash::setMessage('danger','Erro ao enviar email para'.$t.'!');
					App::redirect('admin/index');
					exit();
				}
			}
		}else{
			$aux =  mail($to, $subject, $msg, $headers); 
		}
		return $aux;
	}
}