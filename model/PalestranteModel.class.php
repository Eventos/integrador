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

	private function insertImage($caminho){
		try{	
			$query = "INSERT INTO foto_video (link, id_evento, id_subevento, descricao, tipo) Values (:caminho, :evento, :subevento, :descricao, :tipo )";
			$values = Array(
				':caminho' => $caminho,
				':evento' => 1,
				':subevento' => null,
				':descricao' => 'foto palestrante',
				':tipo' => 'f'
			);
			$prep = $this->db->prepare($query);
			$prep->execute($values);
		}catch(Exception $e){
			Flash::setMessage('danger', 'Erro ao inserir palestrante - '.$e);
			return false;
		}
		return true;
	}

	function newAction($data, $file){

		if (!$file == null){
			$destination = 'uploads/'.$file['image']['name'];
			copy($file['image']['tmp_name'], $destination);
			if($this->insertImage($destination)){
				$query = "SELECT LAST_INSERT_ID();";
				$id = $this->db->query($query);
				$id = iterator_to_array($id);
				$destination = $id[0][0];
			}else{
				$destination = 1;
			}
		}else{
			$destination = 1;
		}
		$data['copyImage'] = $destination;
		$query = 'INSERT INTO palestrante (nome, data_nascimento, id_formacao, email, telefone, id_cidade, facebook, twitter, google_plus, descricao, id_image ) VALUES (:nome, :data_nascimento, :id_formacao, :email, :telefone, :id_cidade, :facebook, :twitter, :google_plus, :descricao, :copyImage)';
		$values = array();
		foreach ($data as $key => $value) {
			$values[':'.$key] = $value;
		}

		$prep = $this->db->prepare($query);
		$prep->execute($values);
		Flash::setMessage('success', 'Palestrante inserido com sucesso!');
		App::redirect('admin/index');
		exit;
	}

	function exists(){
		$query = "SELECT id_palestrante FROM palestrante";
	
		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_palestrante", $data[0] ))
			return true;
		return false;
	}

	function getData(){
		$query = "SELECT * FROM palestrante";
		$db = $this->db->prepare($query);
		$db->execute();
		$data = $db->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	private function getPath($id){
		if($id ==null){
			$path[0]['link'] = App::getUrl().'assets/images/palestrante.png';
		}else{
			$query = "SELECT link FROM foto_video WHERE id_foto_video = '$id'";
			$db = $this->db->prepare($query);
			$db->execute();
			$path = $db->fetchAll(PDO::FETCH_ASSOC);
		}
		return $path[0]['link'];
	}

	function getImage($id){
		$query = "SELECT id_image FROM palestrante WHERE id_palestrante = '$id'";
		$db = $this->db->prepare($query);
		$db->execute();
		$data = $db->fetchAll(PDO::FETCH_ASSOC);
		$image = new PalestranteController();
		if(isset($data[0]['id_image'])){
			$path =$this->getPath($data[0]['id_image']);
		}else{
			$path =$this->getPath(null);
		}
		$html = $image->getImageHtml($path);
		return $html;
	}
}