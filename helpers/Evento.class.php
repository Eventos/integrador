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
}