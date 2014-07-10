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

	static function getData(){
		$blocos = new BlocosModel();
		return $blocos->getBlocks();
	}
}