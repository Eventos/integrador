<?php
/**
* Classe que controla as Fotos e Videos
*/
class MediaModel extends ModelAbstract
{
	function image_exists($id){
		$query = "SELECT id_evento FROM foto_video WHERE id_evento = '$id' and tipo = 'f'";
		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_evento", $data[0] ))
			return true;
		return false;
	}
}
