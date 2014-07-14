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

	static function exists(){
		$boo = new PalestranteModel();
		return $boo->exists();
	}

	static function getPalestrantes(){
		$palestrantes = new PalestranteModel();
		return $palestrantes->getData();
	}

	static function getPalestrante($id){
		$palestrantes = new PalestranteModel();
		$palestrante = $palestrantes->getData($id);
		return $palestrante[0];
	}

	static function getImagePalestrante($id){
		$html = new PalestranteModel();
		return $html->getImage($id);
	}
}