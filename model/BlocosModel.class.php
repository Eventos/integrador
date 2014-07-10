<?php
/**
* Evento que controla a parte de blocos do sistema
*/
class BlocosModel extends ModelAbstract
{
	function newAction($data){
		$query = 'INSERT INTO blocos_estaticos (id_bloco, html) VALUES (:id_bloco, :html)';
		$values = array();
		foreach ($data as $key => $value) {
			$values[':'.$key] = $value;
		}
		$prep = $this->db->prepare($query);
		$prep->execute($values);
		Flash::setMessage('success', 'Bloco inserido com sucesso!');
		App::redirect('admin/index');
		exit;
	}
	
	function listAction(){
		$query = 'SELECT * FROM blocos_estaticos';
		$prep = $this->db->prepare($query);
		$prep->execute();
		$data = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	function deleteAction($id){
		$data = $this->db->query("DELETE FROM blocos_estaticos WHERE id_bloco = '$id'");
		Flash::setMessage('success', 'Bloco deletado com sucesso!');
		App::redirect('admin/index');
	}

	function getBlock($param){
		$data = $this->db->query("SELECT html FROM blocos_estaticos WHERE id_bloco = '$param'");
		$data = iterator_to_array($data);
		$block = $data[0];
		return $block;
	}

}