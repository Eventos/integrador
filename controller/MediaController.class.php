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
		        $html.='<div class="image-row">';
		        $html.='<div class="image-set">';
		        $html.='<a id="single_image" href="'.$src_url.'" title="Evento">';
		        $html.=' <img src="'.$src_url.'" alt="Evento" width="150" height="150"/>';
		        $html.='</a></div></div>';

		        /*
                $html.="<div class='widget-content'>";
                $html.="<div id='examples' class='section examples-section'>";
		        $html.="<div class='col-sm-4 col-md-2'>";
		        $html.="<div class='image-row'>";
		        $html.='<div class="image-set">';
		        $html.="<a class='example-image-link' href='".$src_url."' data-lightbox='example-set' title='Clique no lado da imagem para avançar.'>";
		        $html.="<img class='example-image' src='".$src_url."' alt='evento' width='150' height='150'/>";
		        $html.='</a></div></div></div></div></div>';*/
		        
			}	        
		}         
		return $html;	 
	}

	public function getHtmlVideo($link){
		$html = '';
		foreach ($link as $url) {
			$url['link'] = str_replace('watch', 'embed', $url['link']);
			$html.='<div class="col-lg-4" style="margin-bottom:20px">';
			$html.='<iframe width="100%" height="300px" src="'.$url['link'].'" frameborder="0" allowfullscreen></iframe>';
			$html.='<h4 style="text-align:center"><a href="#">'.$url['descricao'].'</a></h4>';
			$html.='</div>';
		}          
		return $html;	 
	}
}