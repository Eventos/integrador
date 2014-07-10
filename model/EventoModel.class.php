<?php
/**
* Classe que controla os eventos
*/
class EventoModel extends ModelAbstract
{

	function newAction($data){
		echo '<pre>';

		try{
			$emailAdm = $_SESSION['adm']['email'];
			$query = $this->db->query("SELECT id_administrador FROM administrador WHERE email = '$emailAdm'");
			$id_administrador = $query->fetch(PDO::FETCH_ASSOC);

			$aberturaInscricoes = $data['valores'][1]['data_ini'];
			$query = $this->db->query("SELECT DATEDIFF(CURDATE(), '$aberturaInscricoes')");
			$aberto = $query->fetch(PDO::FETCH_ASSOC);
			$aberto = $aberto >= 0 ? 1 : 0;

			$id_evento = $this->getNextIncrement('evento');

			$query = "INSERT INTO evento (local, desc_contato, data_hora, data_limite, vagas, aberto, desc_evento, email_contato, telefone_contato, id_cidade, id_administrador, facebook, twitter, google_plus, id_palestrante, titulo, descricao_resumida, ativo) VALUES (:local, :descricao_contato, :data_hora, :data_limite, :vagas, :aberto, :desc_evento, :email_contato, :telefone_contato, :id_cidade, :id_administrador, :facebook, :twitter, :google_plus, :palestrante, :titulo, :descricao_resumida, 's')";
			$values = array(':local' => $data['local'],':descricao_contato' => $data['desc_contato'],':data_hora' => $data['data_hora'],':data_limite' => $data['data_limite'],':vagas' => $data['vagas'],':aberto' => $aberto,':desc_evento' => $data['desc_evento'],':email_contato' => $data['email_contato'],':telefone_contato' => $data['telefone_contato'],':id_cidade' => $data['cidade'],':id_administrador' => (int)$id_administrador,':facebook' => $data['facebook'],':twitter' => $data['twitter'],':google_plus' => $data['google_plus'],':palestrante' => $data['palestrante'], ':titulo' => $data['titulo'], ':descricao_resumida' => $data['descricao_resumida']);

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

		if($data['type'] == 'video'){
			$this->insertVideo($id_evento, $data);
		}elseif($data['type'] == 'foto'){
			$this->insertFoto($id_evento, $data, $files);
		}
	}

	private function insertFoto($id_evento, $data, $files){
		try{
			$dataFiles = $this->organizeFiles($files);
			foreach ($dataFiles as $key => $file) {
				$descricao = $data['inputFoto'][$key]['descricao'];
				$destination = 'uploads/evento'.$id_evento . '-'. $key . '-' . $file['name']['file'];
				copy($file['tmp_name']['file'], $destination);

				$query = "INSERT INTO foto_video (link, id_evento, descricao, tipo) VALUES (:link, :id_evento, :descricao, 'f')";
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
				$query = "INSERT INTO foto_video (link, id_evento, descricao, tipo) VALUES (:link, :id_evento, :descricao, 'v')";
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

	function eventoExists($id=null, $type=null){
		if($type ==null){
			if($id === null){
				$query = "SELECT id_evento FROM evento WHERE aberto = 1 and ativo = 's'";
			}
			else{
				$query = "SELECT id_evento FROM evento WHERE id_evento = '$id' and aberto = 1 and ativo='s' ";
			}
		}else{
			if($id === null){
				$query = "SELECT id_evento FROM evento WHERE ativo = 'n'";
			}
			else{
				$query = "SELECT id_evento FROM evento WHERE id_evento = '$id' and ativo='n' ";
			}
		}

		$data = $this->db->query($query);
		$data = iterator_to_array($data);

		if (isset($data[0]) && array_key_exists("id_evento", $data[0] ))
			return true;
		return false;
	}

	function getlist($id=null){
		if($id === null){
			$query = "SELECT id_evento, titulo, descricao_resumida, data_hora, data_limite FROM evento WHERE aberto = 1 and ativo='s'";
		}
		else{
			$query = "SELECT titulo, descricao_resumida, data_hora, data_limite FROM evento WHERE id_evento = '$id' and aberto = 1 and ativo='s'";
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $linha;
	}

	function getData($id=null,$type=null){
		if($type == null){
			if($id === null){
				$query = "SELECT * FROM evento WHERE aberto = 1 and ativo = 's'";
			}
			else{
				$query = "SELECT * FROM evento WHERE id_evento = '$id' and aberto = 1 and ativo = 's' ";
			}
		}else{
			if($id === null){
				$query = "SELECT * FROM evento WHERE ativo = 'n'";
			}
			else{
				$query = "SELECT * FROM evento WHERE id_evento = '$id' and ativo = 'n' ";
			}
		}

		$consulta = $this->db->prepare($query);
		$consulta->execute();
		$linha = $consulta->fetchAll(PDO::FETCH_ASSOC);

		if($id != null){
			$query = "SELECT valor FROM valor_evento WHERE DATEDIFF(CURDATE(), data_ini) >= 0 AND DATEDIFF(CURDATE(), data_fim) <= 0 AND id_evento = :id LIMIT 0,1";
			$value = array(':id' => $id);
			$db = $this->db->prepare($query);
			$db->execute($value);
			$valor = $db->fetchAll(PDO::FETCH_ASSOC);
			if(isset($valor[0])){
				$linha[0]['valor'] = $valor[0]['valor'];
			}
		}
		
		return $linha;
	}
	function countRegistered($id){
		$id = 3;
		$query = $query = "SELECT count(id_inscricao)  FROM inscricao WHERE pagamento = 1 and Id_evento =  '$id'";
		$data = $this->db->query($query);
		$data = $data->fetch(PDO::FETCH_NUM);
		return $data[0];
	}
	function deleteAction($id){
		try{
			$query = "UPDATE evento SET ativo = 'n' WHERE id_evento = $id";
			$prep = $this->db->prepare($query);
			$exec = $prep->execute();
			if(!$exec) throw new Exception('Erro na exclusão..');
			Flash::setMessage('success', 'Evento excluído com sucesso');
			App::redirect('admin/index');
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}	
	}

	function sendMsg($data){
		try{
			$query = "INSERT INTO contato (nome, email, mensagem, resposta, id_evento, id_administrador) VALUES (:name, :email, :mensagem, :resposta, :id_evento, :id_administrador)";
			$values = array(':name'=>$data['name'], ':email'=>$data['email'], ':mensagem'=>$data['message'], ':resposta'=>'n', ':id_evento'=>$data['evento'], ':id_administrador'=>$data['id_admin']);
			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			
		}catch(Exception $e){
			return false;
		}
		return true;	
	}

	function getValueEventoById($id_evento){
		$query = "SELECT valor FROM valor_evento WHERE DATEDIFF(CURDATE(), data_ini) >= 0 AND DATEDIFF(CURDATE(), data_fim) <= 0 AND id_evento = :id LIMIT 0,1";
		$value = array(':id' => $id_evento);
		$db = $this->db->prepare($query);
		$db->execute($value);
		$valor = $db->fetchAll(PDO::FETCH_ASSOC);
		if(isset($valor[0])){
			return $valor[0]['valor'];
		}
	}
}