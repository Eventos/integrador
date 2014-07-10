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

	static function listBlocs(){
		$blocos = new BlocosModel();
		return $blocos->listAction();
	}
}