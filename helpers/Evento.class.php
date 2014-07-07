<?php
/**
* Helper para eventos
*/
class Evento
{
	static function newHelper(){
		$params = array();
		$palestrantes = new PalestranteModel();
		$params['palestrantes'] = $palestrantes->getAllPalestrantes();
		$administrador = new AdminModel;
		$params['adm'] = $administrador->getAdmSession();
		return $params;
	}

	static function SubEventoNewHelper(){
		$params = array();
		$palestrantes = new PalestranteModel();
		$params['palestrantes'] = $palestrantes->getAllPalestrantes();
		return $params;
	}

	static function mediaHelper($idEvento = null, $type = 'evento'){
		$params = array('id_evento' => $idEvento,
						'type' => $type
				);
		return $params;
	}

	static function exists ( $id=null, $type=null ){  
		$evento = new EventoModel();
	  	return $evento->eventoExists($id, $type);
	}

	static function getEvento ($id = null, $type){
		$data = array();
		$evento = new EventoModel();
		if($type == 'info')
			$data = $evento->getList($id);
		elseif($type == 'all'){
			$data = $evento->getData($id);
		}
		elseif($type == 'encerrado'){
			$data = $evento->getData($id, 'encerrado');
		}
		return $data;
	}
}