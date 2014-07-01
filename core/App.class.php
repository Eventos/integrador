<?php
/**
* Classe base da aplicação
*/
class App
{
	function __construct(){
		$this->config();
		spl_autoload_register(array($this, 'autoloader'));
	}

	private function config(){
		require_once('config/config.php');
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
		/*Flash::setMessage('success','tudo bem');*/
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

	static function append($view){
		require_once(SITE_ROOT.'view/'.$view.'.phtml');
	}
}