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
}