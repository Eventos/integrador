<?php
/**
* Helper de funções de páginas
*/
class Page
{
	static function urlImage($file){
		$file_url = URL_BASE.'assets/images/'.$file;
		$file = SITE_ROOT.'assets/images/'.$file;
		if(file_exists($file)){
			return $file_url;
		}
	}
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

	static function addSliderElement($type, $file){
		$file_url = URL_BASE.'assets/Carousel/'.$type.'/'.$file;
		$file = SITE_ROOT.'assets/Carousel/'.$type.'/'.$file;
		if(file_exists($file)){
			if($type == 'js'){
				echo '<script type="text/javascript" src="'.$file_url.'"></script>';
			}elseif($type == 'css'){
				echo '<link href='.$file_url.' rel="stylesheet" type="text/css" media="all" />';
			}
		}
	}

	static function addThinElement($type, $file){
		$file_url = URL_BASE.'assets/thin/'.$type.'/'.$file;
		$file = SITE_ROOT.'assets/thin/'.$type.'/'.$file;
		if(file_exists($file)){
			if($type == 'js'){
				echo '<script type="text/javascript" src="'.$file_url.'"></script>';
			}elseif($type == 'css'){
				echo '<link href='.$file_url.' rel="stylesheet" type="text/css" media="all" />';
			}
		}
	}

	static function addTinymceElement($type, $file){
		$file_url = URL_BASE.'assets/tinymce/'.$file;
		$file = SITE_ROOT.'assets/tinymce/'.$file;
		if(file_exists($file)){
			if($type == 'js'){
				echo '<script type="text/javascript" src="'.$file_url.'"></script>';
			}elseif($type == 'css'){
				echo '<link href='.$file_url.' rel="stylesheet" type="text/css" media="all" />';
			}
		}
	}
}