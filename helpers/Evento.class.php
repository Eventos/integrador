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
		return $params;
	}

	static function SubEventoNewHelper(){
		$params = array();
		$palestrantes = new PalestranteModel();
		$params['palestrantes'] = $palestrantes->getAllPalestrantes();
		return $params;
	}

	static function mediaHelper($idEvento = null){
		$params = array('id_evento' => $idEvento);
		return $params;
	}

	static function exists ( $id=null ){  
		$evento = new EventoModel();  
	    return $evento->eventoExists($id);
	}
}