<?php
/**
* Classe que controla as Fotos e Videos
*/
class MediaModel extends ModelAbstract
{
	function image_exists($id, $id_sub=null){
		if($id_sub == null){
			$query = "SELECT id_evento FROM foto_video WHERE id_evento = '$id' and tipo = 'f'";
		}
		else{
			$query = "SELECT id_evento FROM foto_video WHERE id_evento = '$id' and tipo = 'f' and id_subevento = '$id_sub'";
		}		
		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_evento", $data[0] ))
			return true;
		return false;
	}
	function getImages($id, $id_sub=null){
		if ($id_sub == null){
			$query = "SELECT link FROM foto_video WHERE tipo = 'f' and id_evento = :id_evento ";
			$value = array(':id_evento' => $id);
		}else{
			$query = "SELECT link FROM foto_video WHERE tipo = 'f' and id_evento = :id_evento and id_subevento = :id_subevento";
			$value = array(':id_evento' => $id, ':id_subevento' => $id_sub);
		}
		$prep = $this->db->prepare($query);
		$prep->execute($value);
		$link = $prep->fetchAll(PDO::FETCH_ASSOC);
		
		$html = new MediaController();
		return $html->getHtmlImage($link);
	}

	function video_exists($id,$id_sub=null){
		if ($id_sub==null) {
			$query = "SELECT id_evento FROM foto_video WHERE id_evento = '$id' and tipo = 'v'";
		}else{
			$query = "SELECT id_evento FROM foto_video WHERE id_evento = '$id' and id_subevento = '$id_sub' and tipo = 'v'";
		}
		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_evento", $data[0] ))
			return true;
		return false;
	}
	function getVideos($id, $id_sub=null){
		if($id_sub == null){
			$query = "SELECT link FROM foto_video WHERE tipo = 'v' and id_evento = :id_evento ";
		}else{
			$query = "SELECT link FROM foto_video WHERE tipo = 'v' and id_evento = :id_evento and id_subevento = '$id_sub' ";
		}
		$value = array(':id_evento' => $id);
		$prep = $this->db->prepare($query);
		$prep->execute($value);
		$link = $prep->fetchAll(PDO::FETCH_ASSOC);
		
		$html = new MediaController();
		return $html->getHtmlVideo($link);
	}
}
