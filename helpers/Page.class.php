<?php
/**
* Helper de funções de páginas
*/
class Page
{
	//exemplo: ('icons/icone.png', 'title="inserindo um ícone seta"');
	//insere na página: <img src="URL_BASE/assets/images/icons/icone.png" title="inserindo um icone seta">
	static function addImage($file, $options = null){
		$file_url = URL_BASE.'assets/images/'.$file;
		$file = SITE_ROOT.'assets/images/'.$file;
		if(file_exists($file)){
			echo '<img src="'.$file_url.'" '.$options.'>';
		}
	}

	//exemplo: ('js', 'Jquery/jquery.js'); insere URL_BASE/assets/js/Jquery/jquery.js
	static function addStyleElement($type, $file){
		$file_url = URL_BASE.'assets/'.$type.'/'.$file;
		$file = SITE_ROOT.'assets/'.$type.'/'.$file;
		if(file_exists($file)){
			if($type == 'js'){
				echo '<script type="text/javascript" src="'.$file_url.'"></script>';
			}elseif($type == 'css'){
				echo '<link href='.$file_url.' rel="stylesheet" type="text/css" media="all" />';
			}
		}
	}
}