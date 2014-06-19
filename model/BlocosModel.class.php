<?php
/**
* Evento que controla a parte de blocos do sistema
*/
class BlocosModel extends ModelAbstract
{
	function newAction(){

	}

	function listAction(){

	}

	function editAction(){

	}

	function getBlock($param){
		$data = $this->db->query("SELECT html FROM blocos_estaticos WHERE id_bloco = '$param'");
		$data = iterator_to_array($data);
		$block = $data[0];
		return $block;
	}
}