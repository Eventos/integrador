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

	protected function getNextIncrement($table){
		$query = $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".$table."'");
		$id_evento = $query->fetch(PDO::FETCH_ASSOC);
		$id_evento = $id_evento['AUTO_INCREMENT'];
		return $id_evento;
	}
}