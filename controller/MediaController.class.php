<?php
/**
* Classe que controla as medias do site
*/
class MediaController extends ControllerAbstract
{
	public function getHtmlImage($path){
		$html = '';
		foreach ($path as $link) {
			$src_url = URL_BASE.$link['link'];
			$src = SITE_ROOT.$link['link'];
			if(file_exists($src)){
				$html.='<div class="col-sm-4 col-md-2">';
		        $html.='<div class="image-row">';
		        $html.='<div class="image-set">';
		        $html.='<a href="'.$src_url.'" data-lightbox="example-set" title="Evento">';
		        $html.=' <img class="example-image" src="'.$src_url.'" alt="Evento" width="150" height="150"/>';
		        $html.='</a></div></div></div>';
			}	        
		}          
		return $html;	 
	}
}