<?php
/**
* Evento que controla a parte de administração do sistema
*/
class LocalModel extends ModelAbstract
{
	private $estados;
	private $cidades;

	private function setCidades(){
		$this->cidades = $this->db->query('SELECT id_cidade, id_estado, nome FROM cidade');
		$this->cidades = iterator_to_array($this->cidades);
	}

	private function setEstados(){
		$this->estados = $this->db->query('SELECT id_estado, nome FROM estado');
		$this->estados = iterator_to_array($this->estados);
	}

	function getCidades(){
		$this->setCidades();
		return $this->cidades;
	}

	function getEstados(){
		$this->setEstados();
		return $this->estados;
	}

}