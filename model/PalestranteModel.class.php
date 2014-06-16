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

	function newAction($data){
		$query = 'INSERT INTO palestrante (nome, data_nascimento, id_formacao, email, telefone, id_cidade, facebook, twitter, google_plus, linkedin, descricao) VALUES (:nome, :data_nascimento, :id_formacao, :email, :telefone, :id_cidade, :facebook, :twitter, :google_plus, :linkedin, :descricao)';
		$values = array();
		foreach ($data as $key => $value) {
			$values[':'.$key] = $value;
		}
		$prep = $this->db->prepare($query);
		$prep->execute($values);
		Flash::setMessage('success', 'Palestrante inserido com sucesso!');
		App::redirect('admin/index');
	}
}