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
	
	function getBlocks(){
		$query = 'SELECT blok.id_bloco, blok.html, COALESCE(ref.descricao," Não há referencia") as referencia FROM blocos_estaticos as blok LEFT JOIN referencia as ref ON blok.id_referencia = ref.id_referencia';
		
		$prep = $this->db->prepare($query);
		$prep->execute();
		
		$blocos = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $blocos;
	}

	
	function editAction($id, $data){
		try{
			$query = "UPDATE blocos_estaticos SET html = :html WHERE id_bloco = :id ";
			$values= Array(':html' => $data['html'], ':id' => $id);
			$prep = $this->db->prepare($query);
			$exec = $prep->execute($values);
			if(!$exec) throw new Exception('Erro na exclusão..');
			return true;
		}catch(Exception $e){
			return false;
		}	
	}

	


	function getBlock($param){
		$data = $this->db->query("SELECT html FROM blocos_estaticos WHERE id_bloco = '$param'");
		$data = iterator_to_array($data);
		$block = $data[0];
		return $block;
	}

	function exists($id){
		if($id == null){
			$result = $this->db->query("SELECT id_bloco FROM blocos_estaticos");
		}else{
			$result = $this->db->query("SELECT id_bloco FROM blocos_estaticos WHERE id_bloco = '$id'");
		}
		$data = $result->fetch();
		if(!$data || empty($data['id_bloco'])){
			return false;
		}
		return true;
	}

}