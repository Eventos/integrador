<?php
/**
* Helper para palestrantes
*/
class Palestrante
{
	static function newHelper(){
		$params = array();
		$formacao = new FormacaoModel;
		$params['formacoes'] = $formacao->getAllFormacoes();
		return $params;
	}
}