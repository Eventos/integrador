<?php
/**
* Helper para blocos
*/
class Blocos
{
	static function writer($param){
		$html = new BlocosModel;
		$cod = $html->getBlock($param);
		return $cod[0];
	}

	static function exists($id=null){
		$boo = new BlocosModel();
		return $boo->exists($id);
	}

	static function existsReferencia($id){
		$boo = new BlocosModel();
		return $boo->existsReferencia($id);
	}

	static function getData(){
		$blocos = new BlocosModel();
		return $blocos->getBlocks();
	}

	static function getReferencia($id){
		$id_bloco = new BlocosModel();
		$id_ref = $id_bloco->getIdReferencia($id);
		return $id_bloco->getReferencia($id_ref);
	}
}