<?php
/**
* Helper para eventos
*/
class Evento
{
	function newHelper(){
		$params = array();
		$palestrantes = new PalestranteModel();
		$params['palestrantes'] = $palestrantes->getAllPalestrantes();
		return $params;
	}
}