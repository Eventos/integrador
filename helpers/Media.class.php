<?php
/**
* Helper para Fotos e Videos
*/
class Media
{
	static function image_exists($id,$id_sub=null){
		 $boo = new MediaModel();
		 return $boo->image_exists($id, $id_sub);
	}

	static function getAllImages($id,$id_sub=null){
		$html = new MediaModel();
		return $html->getImages($id,$id_sub);
	}

	static function getImage($id,$id_sub=null){
		$html = new MediaModel();
		return $html->getImage($id,$id_sub);
	}

	static function getImageNormal($id,$id_sub=null){
		$html = new MediaModel();
		return $html->getImageNormal($id,$id_sub);
	}

	static function getImageUrl($id,$id_sub=null){
		$html = new MediaModel();
		return $html->getImageUrl($id,$id_sub);
	}

	static function video_exists($id,$id_sub=null){
		 $boo = new MediaModel();
		 return $boo->video_exists($id,$id_sub);
	}

	static function getAllVideos($id,$id_sub=null){
		$html = new MediaModel();
		return $html->getVideos($id,$id_sub);
	}

	static function getUrlVideo($id,$id_sub=null){
		$url = new MediaModel();
		return $url->getUrlVideo($id,$id_sub);
	}

}