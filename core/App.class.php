<?php
/**
* Classe base da aplicação
*/
class App
{
	function __construct(){
		spl_autoload_register(array($this, 'autoloader'));	
		define('SITE_ROOT', '/var/www/projetoIntegrador/');
		define('URL_BASE', 'http://localhost/projetoIntegrador/');
		header('Content-Type: text/html; charset=utf-8');
	}

	function autoloader($class){
		$file = '';
		if(strpos($class, 'Model')){
			$file = SITE_ROOT.'model/'.$class.'.class.php';
		}elseif(strpos($class,'Controller')){
			$file = SITE_ROOT.'controller/'.$class.'.class.php';
		}else{
			$file = SITE_ROOT.'helpers/'.$class.'.class.php';
		}

		if(file_exists($file)){
			require_once($file);
		}
	}

	static function ready(){
		Flash::setMessage(null,null);
		Flash::getMessages();
	}

	static function renderTemplate($template, $vars){
		if(strpos($template, '.phtml') || strpos($template, '.php')){
			$file = SITE_ROOT.'view'.$template;
		}else{
			$file = SITE_ROOT.'view'.$template.'.phtml';
		}
		if(file_exists($file)){
			require_once($file);
		}
	}

	static function getUrl(){
		return URL_BASE;
	}
}