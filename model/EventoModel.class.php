<?php
/**
* Classe que controla os eventos
*/
class EventoModel extends ModelAbstract
{

	function newAction($data){
		echo '<pre>';

		try{
			$emailAdm = $_SESSION['email'];
			$query = $this->db->query("SELECT id_administrador FROM administrador WHERE email = '$emailAdm'");
			$id_administrador = $query->fetch(PDO::FETCH_ASSOC);

			$aberturaInscricoes = $data['valores'][1]['data_ini'];
			$query = $this->db->query("SELECT DATEDIFF(CURDATE(), '$aberturaInscricoes')");
			$aberto = $query->fetch(PDO::FETCH_ASSOC);
			$aberto = $aberto >= 0 ? 1 : 0;

			$id_evento = $this->getNextIncrement('evento');

			$query = "INSERT INTO evento (local, desc_contato, data_hora, data_limite, vagas, aberto, desc_evento, email_contato, telefone_contato, id_cidade, id_administrador, facebook, twitter, google_plus, id_palestrante, titulo, tipo) VALUES (:local, :descricao_contato, :data_hora, :data_limite, :vagas, :aberto, :desc_evento, :email_contato, :telefone_contato, :id_cidade, :id_administrador, :facebook, :twitter, :google_plus, :palestrante, :titulo, :tipo)";
			$values = array(':local' => $data['local'],':descricao_contato' => $data['desc_contato'],':data_hora' => $data['data_hora'],':data_limite' => $data['data_limite'],':vagas' => $data['vagas'],':aberto' => $aberto,':desc_evento' => $data['desc_evento'],':email_contato' => $data['email_contato'],':telefone_contato' => $data['telefone_contato'],':id_cidade' => $data['cidade'],':id_administrador' => (int)$id_administrador,':facebook' => $data['facebook'],':twitter' => $data['twitter'],':google_plus' => $data['google_plus'],':palestrante' => $data['palestrante'], ':titulo' => $data['titulo'], ':tipo' => $data['tipo']);

			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			if(!$query) throw new Exception('Erro na inserção..');

			$valores = $data['valores'];
			$this->insertValues($valores, $id_evento);
			
			Flash::setMessage('info', 'Insira agora fotos e vídeos para seu evento');
			App::redirect('admin/eventos/media/'.$id_evento);
			exit;
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}

	private function insertValues($valores, $id_evento){
		foreach ($valores as $valor) {
			$query = 'INSERT INTO valor_evento (data_ini, data_fim, valor, id_evento) VALUES (:data_ini, :data_fim, :valor, :id_evento)';
			$values = array(
						':data_ini' => $valor['data_ini'],
						':data_fim' => $valor['data_fim'],
						':valor' => $valor['valor'],
						':id_evento' => $id_evento
					);
			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			if(!$query) throw new Exception('Erro na inserção..');
		}
	}

	function editAction($data){
		
	}

	function insertMedia($id_evento, $data, $files){
		echo '<pre>';
		if($data['type'] == 'video'){
			$this->insertVideo($id_evento, $data);
		}elseif($data['type'] == 'foto'){
			$this->insertFoto($id_evento, $data, $files);
		}
	}

	private function organizeFiles($files){
		$dataFiles = array();
		foreach ($files as $files) {
			foreach ($files['name'] as $key => $value) {
				$dataFiles[$key]['name'] = $value;
			}
			foreach ($files['tmp_name'] as $key => $value) {
				$dataFiles[$key]['tmp_name'] = $value;
			}
		}
		return $dataFiles;
	}

	private function insertFoto($id_evento, $data, $files){
		try{
			$dataFiles = $this->organizeFiles($files);
			foreach ($dataFiles as $key => $file) {
				$descricao = $data['inputFoto'][$key]['descricao'];
				$destination = 'uploads/evento'.$id_evento . '-'. $key . '-' . $file['name']['file'];
				copy($file['tmp_name']['file'], $destination);

				$query = "INSERT INTO foto_video (link, id_evento, descricao) VALUES (:link, :id_evento, :descricao)";
				$values = array(
					':link' => $destination,
					':descricao' => $descricao,
					':id_evento' => $id_evento
				);
				$prep = $this->db->prepare($query);
				$query = $prep->execute($values);
				if(!$query) throw new Exception('Erro na inserção..');
			}
			Flash::setMessage('success', 'Evento inserido com sucesso!');
			App::redirect('admin/index');
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}

	private function insertVideo($id_evento, $data){
		try{
			foreach ($data['inputVideo'] as $video) {
				$query = "INSERT INTO foto_video (link, id_evento, descricao) VALUES (:link, :id_evento, :descricao)";
				$values = array(
					':link' => $video['url'],
					':descricao' => $video['descricao'],
					':id_evento' => $id_evento
				);
				$prep = $this->db->prepare($query);
				$query = $prep->execute($values);
				if(!$query) throw new Exception('Erro na inserção..');
			}
			Flash::setMessage('success', 'Evento inserido com sucesso!');
			App::redirect('admin/index');
			exit;
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}

	function eventoExists($id=null){
		if($id === null){
			$query = "SELECT id_evento FROM evento WHERE aberto = 1";
		}
		else{
			$query = "SELECT id_evento FROM evento WHERE id_evento = '$id' and aberto = 1 ";
		}

		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_evento", $data[0] ))
			return true;
		return false;
	}

	function getlist($id=null){
		if($id === null){
			$query = "SELECT titulo, tipo, data_hora, data_limite FROM evento WHERE aberto = 1";
		}
		else{
			$query = "SELECT titulo, tipo, data_hora, data_limite FROM evento WHERE id_evento = '$id' and aberto = 1 ";
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $linha;
	}

	function getData($id=null){
		if($id === null){
			$query = "SELECT * FROM evento WHERE aberto = 1";
		}
		else{
			$query = "SELECT * FROM evento WHERE id_evento = '$id' and aberto = 1 ";
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $linha;
	}
}