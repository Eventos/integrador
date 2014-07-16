<?php
/**
* Classe que controla as medias do site
*/
class MediaController extends ControllerAbstract
{
	public function getHtmlImage($path){
		$html = '';
		foreach ($path as $link) {
			if(strlen($link['link']) < 2){
				$src_url = URL_BASE.$link;
				$src = SITE_ROOT.$link;	
			}else{
				$src_url = URL_BASE.$link['link'];
				$src = SITE_ROOT.$link['link'];	
			}

			if(file_exists($src)){
				$html.='<div class="wrap"><div class="col_1_of_3 span_1_of_3">';
		        $html.='<a class="fancybox-effects-d" href="'.$src_url.'" title="Evento" data-fancybox-group="gallery" >';
		        $html.=' <img src="'.$src_url.'" alt="Evento" width="250" height="250" style="box-shadow: 1px 3px 18px 7px rgb(151, 149, 149);" /></a></div></div>';
		    }	        
		}         
		return $html;	 
	}

	public function getHtmlImageNormal($path){
		$html = '';
		foreach ($path as $link) {
			if(strlen($link['link']) < 2){
				$src_url = URL_BASE.$link;
				$src = SITE_ROOT.$link;	
			}else{
				$src_url = URL_BASE.$link['link'];
				$src = SITE_ROOT.$link['link'];	
			}

			if(file_exists($src)){
		        $html.='<a class="fancybox-effects-d" href="'.$src_url.'" title="Evento" data-fancybox-group="gallery" >';
		        $html.='<img src="'.$src_url.'" alt="Evento" style="max-height: 250px;"/></a>';
		    }	        
		}         
		return $html;	 
	}

	public function getHtmlVideo($link){
		$html = '';
		foreach ($link as $url) {
			$url['link'] = str_replace('watch', 'embed', $url['link']);
			$html.='<div class="col-lg-4" style="margin-top:25px;margin-bottom:20px">';
			$html.='<iframe width="100%" height="300px" src="'.$url['link'].'" frameborder="0" allowfullscreen></iframe>';
			$html.='<h4 style="text-align:center"><a href="#">'.$url['descricao'].'</a></h4>';
			$html.='</div>';
		}          
		return $html;	 
	}
}