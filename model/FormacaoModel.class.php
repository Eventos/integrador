<?php
/*define('SEL_ADM', 
	'SELECT email , senha FROM administrador WHERE email=(:email) AND senha=(:senha)');
define('SEL_USR', 
	'SELECT email , senha FROM usuario WHERE email=(:email) AND senha=(:senha)');*/

class FormacaoModel extends ModelAbstract{
	function getAllFormacoes(){
		$formacoes = $this->db->query('SELECT id_formacao, nome FROM formacao');
		$data = iterator_to_array($formacoes);
		return $data;
	}
}
?>