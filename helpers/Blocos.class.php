<?php
/**
* Helper para blocos
*/
class Blocos
{
	static function insertHelper ($param){
		$html = new BlocosModel;
		$cod = $html->getBlock($param);
		return $cod[0];
	}
}