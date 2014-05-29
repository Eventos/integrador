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

	static function errorPage($msg = null){
		//RENDERIZAR PAGINA NAO ENCONTRADA
		echo "Ops, página não encontrada<br>";
		print_r($msg); 
		exit;
	}

	static function redirect($url){
		if(strpos($url, 'http://')){
			$router = new RouterAbstract(FOLDER.$url);
		}else{
			header("Location: $url");
		}
	}
}