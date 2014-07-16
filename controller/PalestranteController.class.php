<?php
/**
* Usuario index controller
*/
class PalestranteController extends ControllerAbstract
{
	public function getImageHtml($path){
		$html = '<img src="';
		$html.=	 App::getUrl().$path;
		$html.= ' "alt="Palestrante" style="max-height: 200px;min-height: 200px;">';
		return $html;
	}
}
