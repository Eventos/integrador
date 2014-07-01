<?php
/**
* Helper para eventos
*/
class Subevento
{
	static function exists ( $id_evento, $id_subevento=null ){  
		$subevento = new SubeventoModel();  
	    return $subevento->subeventoExists($id_evento,$id_subevento);
	}

	static function getSubevento ($id_evento,$id_subevento = null, $type){
		$data = array();
		$subevento = new SubeventoModel();
		if($type == 'info')
			$data = $subevento->getList($id_evento,$id_subevento);
		elseif($type == 'all'){
			$data = $subevento->getData($id_evento, $id_subevento);
		}
		return $data;
	}
}