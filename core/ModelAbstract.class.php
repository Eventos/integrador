<?php
/**
* Classe base para modelos
*/
class ModelAbstract
{
	public $db;

	function __construct(){
		$this->db = DbAbstract::openConnect();
	}
}