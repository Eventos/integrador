<?php
/**
* Classe para palestrante
*/
class PalestranteModel extends ModelAbstract
{
	function getAllPalestrantes(){
		$palestrante = $this->db->query('SELECT id_palestrante, nome FROM palestrante');
		$data = iterator_to_array($palestrante);
		return $data;
	}
}