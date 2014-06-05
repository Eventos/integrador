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

	/*static function renderTemplate($template, $vars){
		if(strpos($template, '.phtml') || strpos($template, '.php')){
			$file = SITE_ROOT.'view'.$template;
		}else{
			$file = SITE_ROOT.'view'.$template.'.phtml';
		}
		if(file_exists($file)){
			require_once($file);
		}
	}*/

	static function getUrl(){
		return URL_BASE;
	}

	static function errorPage($msg = null){
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
}