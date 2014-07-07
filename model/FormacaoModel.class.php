<?php

class FormacaoModel extends ModelAbstract{
	function getAllFormacoes(){
		$formacoes = $this->db->query('SELECT id_formacao, nome FROM formacao');
		$data = iterator_to_array($formacoes);
		return $data;
	}
}
?>