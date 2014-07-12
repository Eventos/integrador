<?php
/**
* Classe que controla os subeventos
*/
class SubeventoModel extends ModelAbstract
{
	function newAction($id_evento, $data){
		echo '<pre>';
		try{
			$aberturaInscricoes = $data['valores'][1]['data_ini'];
			$query = $this->db->query("SELECT DATEDIFF(CURDATE(), '$aberturaInscricoes')");
			$aberto = $query->fetch(PDO::FETCH_ASSOC);
			$aberto = $aberto >= 0 ? 1 : 0;

			$id_subevento = $this->getNextIncrement('subevento');

			$query = "INSERT INTO subevento (local, descricao, data_hora, vagas, data_limite, id_evento, aberto, id_palestrante, titulo, ativo) VALUES (:local, :descricao, :data_hora, :vagas, :data_limite, :id_evento, :aberto, :id_palestrante, :titulo, 's')";
			$values = array(
					':local'          => $data['local'],
					':descricao'      => $data['desc_subevento'],
					':data_hora'      => $data['data_hora'],
					':vagas'          => $data['vagas'],
					':data_limite'    => $data['data_limite'],
					':id_evento'      => $id_evento,
					':aberto'         => $aberto,
					':id_palestrante' => $data['palestrante'],
					':titulo'         => $data['titulo']
			);
			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			if(!$query) throw new Exception('Erro na inserção..');

			$valores = $data['valores'];
			$this->insertValues($valores, $id_subevento);

			Flash::setMessage('success', 'Sub-evento inserido com sucesso');
			App::redirect('admin/subeventos/media/'.$id_subevento);
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}

	private function getIdEvento($id_subevento){
		$query = "SELECT id_evento FROM subevento WHERE id_subevento = :id_subevento and ativo = 's'";
		$value = array(':id_subevento' => $id_subevento);
		$prep = $this->db->prepare($query);
		$prep->execute($value);
		$id = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $id[0]['id_evento'];
	}

	private function insertValues($valores, $id_subevento){
		foreach ($valores as $valor) {
			$query = 'INSERT INTO valor_subevento (data_ini, data_fim, valor, id_subevento) VALUES (:data_ini, :data_fim, :valor, :id_subevento)';
			$values = array(
						':data_ini' => $valor['data_ini'],
						':data_fim' => $valor['data_fim'],
						':valor' => $valor['valor'],
						':id_subevento' => $id_subevento
					);
			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			if(!$query) throw new Exception('Erro na inserção..');
		}
	}

	private function insertFoto($id_subevento, $data, $files){
		try{
			$dataFiles = $this->organizeFiles($files);
			$id_evento = $this->getIdEvento($id_subevento);
			foreach ($dataFiles as $key => $file) {
				$descricao = $data['inputFoto'][$key]['descricao'];
				$destination = 'uploads/subevento'.$id_subevento . '-'. $key . '-' . $file['name']['file'];
				copy($file['tmp_name']['file'], $destination);

				$query = "INSERT INTO foto_video (link, id_evento, id_subevento, descricao, tipo) VALUES (:link, :id_evento, :id_subevento, :descricao, 'f')";
				$values = array(
					':link' => $destination,
					':descricao' => $descricao,
					':id_subevento' => $id_subevento,
					':id_evento' => $id_evento
				);
				$prep = $this->db->prepare($query);
				$query = $prep->execute($values);
				if(!$query) throw new Exception('Erro na inserção..');
			}
			Flash::setMessage('success', 'Subevento inserido com sucesso!');
			App::redirect('admin/index');
		}catch(Exception $e){
			die('erro');
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}

	private function insertVideo($id_subevento, $data){
		try{
			$id_evento = $this->getIdEvento($id_subevento);
			foreach ($data['inputVideo'] as $video) {
				$query = "INSERT INTO foto_video (link, id_evento, id_subevento, descricao, tipo) VALUES (:link, :id_evento, :id_subevento, :descricao, 'v')";
				$values = array(
					':link' => $video['url'],
					':descricao' => $video['descricao'],
					':id_subevento' => $id_subevento,
					':id_evento' => $id_evento
				);
				$prep = $this->db->prepare($query);
				$query = $prep->execute($values);
				if(!$query) throw new Exception('Erro na inserção..');
			}
			Flash::setMessage('success', 'Subevento inserido com sucesso!');
			App::redirect('admin/index');
			exit;
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}

	function insertMedia($id_subevento, $data, $files){
		echo '<pre>';
		if($data['type'] == 'video'){
			$this->insertVideo($id_subevento, $data);
		}elseif($data['type'] == 'foto'){
			$this->insertFoto($id_subevento, $data, $files);
		}
	}

	function subeventoExists($id_evento, $id_subevento=null){
		if($id_subevento === null){
			$query = "SELECT id_subevento FROM subevento WHERE id_evento = '$id_evento' and ativo = 's'";
		}
		else{
			$query = "SELECT id_subevento FROM subevento WHERE id_subevento = '$id_subevento' and id_evento = '$id_evento' and ativo = 's'";
		}

		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_subevento", $data[0] ))
			return true;
		return false;
	}

	function getlist($id_evento,$id_subevento=null){
		if($id_subevento === null){
			$query = "SELECT id_subevento, titulo, descricao, data_hora FROM subevento WHERE id_evento = '$id_evento' and ativo = 's'";
		}
		else{
			$query = "SELECT titulo, descricao, data_hora FROM subevento WHERE id_subevento = '$id_subevento' and id_evento = '$id_evento' and ativo = 's'";
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $linha;
	}

	function getData($id_evento,$id_subevento=null){
		if($id_subevento === null){
			$query = "SELECT * FROM subevento WHERE id_evento = '$id_evento' and ativo ='s'";
		}
		else{
			$query = "SELECT * FROM subevento WHERE id_subevento = '$id_subevento' and id_evento = $id_evento and ativo ='s' ";
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);

		if($id_subevento != null){
			$query = "SELECT valor FROM valor_subevento WHERE DATEDIFF(CURDATE(), data_ini) >= 0 AND DATEDIFF(CURDATE(), data_fim) <= 0 AND id_subevento = :id LIMIT 0,1";
			$value = array(':id' => $id_subevento);
			$db = $this->db->prepare($query);
			$db->execute($value);
			$valor = $db->fetchAll(PDO::FETCH_ASSOC);
			if(isset($valor[0])){
				$linha[0]['valor'] = $valor[0]['valor'];
			}
		}

		return $linha;
	}

	function getValueSubeventoById($id_subevento){
		$query = "SELECT valor FROM valor_subevento WHERE DATEDIFF(CURDATE(), data_ini) >= 0 AND DATEDIFF(CURDATE(), data_fim) <= 0 AND id_subevento = :id LIMIT 0,1";
		$value = array(':id' => $id_subevento);
		$db = $this->db->prepare($query);
		$db->execute($value);
		$valor = $db->fetchAll(PDO::FETCH_ASSOC);
		if(isset($valor[0])){
			$data = $valor[0]['valor'];
			return $data;	
		}
		return null;
	}

	function deleteAction($id){
		try{
			$query = "UPDATE subevento SET ativo = 'n' WHERE id_subevento = $id";
			$prep = $this->db->prepare($query);
			$exec = $prep->execute();
			if(!$exec) throw new Exception('Erro na exclusão..');
			Flash::setMessage('success', 'Subevento excluído com sucesso');
			App::redirect('admin/index');
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}
}