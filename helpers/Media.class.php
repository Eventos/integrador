<?php
/**
* Helper para Fotos e Videos
*/
class Media
{
	static function image_exists($id){
		 $boo = new MediaModel();
		 return $boo->image_exists($id);
	}

	static function getAllImages($id){
		$html = new MediaModel();
		return $html->getImages($id);
	}
}