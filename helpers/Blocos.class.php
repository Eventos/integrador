<?php
/**
* Helper para blocos
*/
class Blocos
{
	static function print ($param){
		$html = new BlocosModel;
		$cod = $html->getBlock($param);
		return $cod[0];
	}
}