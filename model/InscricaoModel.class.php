<?php
/**
* Classe de inscrição
*/
class InscricaoModel extends ModelAbstract
{
	function inscricao($data){
		try{
			$user = new UserModel();
			$user = $user->getUserByEmail($_SESSION['user']['email']);

			$data['id_inscricao'] = $this->getNextIncrement('inscricao');
			
			if($data['total'] == 0){
				$dadosEmail['id_inscricao'] = $data['id_inscricao'];
				$dadosEmail['id_evento'] = $data['id_evento'];

				$this->confirmarPagamento($data['id_inscricao']);
				$this->enviarEmailEventoFree($dadosEmail, $user);
			}else{
				$pagamento = new PagseguroModel();
				$url_pag = $pagamento->pagamento($data);
				$this->enviarEmail($url_pag, $user);
			}
			$id_inscricao = $this->inscricaoEvento($user['id_usuario'], $data['id_evento'], $url_pag);
			if(isset($data['subevento'])){
				foreach ($data['subevento'] as $id_subevento) {
					$this->inscricaoSubevento($id_subevento, $id_inscricao);
				}
			}
			if($data['total'] == 0){
				Flash::setMessage('success', 'Inscrição feita com sucesso!');
				App::redirect('user/index');
			}else{
				$this->render('evento/pagseguro', array('url' => $url_pag), true);
			}
			exit;
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('user/index');
		}
	}

	private function inscricaoEvento($id_usuario, $id_evento, $url_pag){
		$autoIncrement = $this->getNextIncrement('inscricao');
		$query = "INSERT INTO inscricao (data_inscricao, pagamento, id_usuario, id_evento, url) VALUES (CURDATE(), '0', :id_usuario, :id_evento, :url)";
		$values = array(
				':id_usuario' => $id_usuario,
				':id_evento' => $id_evento,
				':url' => $url_pag
			);

		$prep = $this->db->prepare($query);
		$prep->execute($values);

		$this->decrementarVagas('evento', $id_evento);
		return $autoIncrement;
	}

	private function inscricaoSubevento($id_subevento, $id_inscricao){
		$query = "INSERT INTO inscricao_subevento (data_inscricao, pagamento, id_inscricao, id_subevento) VALUES (CURDATE(), '0', :id_inscricao, :id_subevento)";
		$values = array(
				':id_inscricao' => $id_inscricao,
				':id_subevento' => $id_subevento,
			);

		$prep = $this->db->prepare($query);
		$prep->execute($values);
		$this->decrementarVagas('subevento', $id_subevento);
	}

	private function decrementarVagas($tipo, $id){
		$query = "UPDATE $tipo SET vagas=vagas-1 WHERE id_$tipo=$id";
		$prep = $this->db->prepare($query);
		$prep->execute();
	}

	private function incrementarVagas($tipo, $id){
		$query = "UPDATE $tipo SET vagas=vagas+1 WHERE id_$tipo=$id";
		$prep = $this->db->prepare($query);
		$prep->execute();
	}

	private function enviarEmail($url_pag, $user){
		$html = '<h1>Olá '.$user['nome'].'..</h1>';
		$html.= 'Obrigado por realizar a inscrição nos nossos eventos.<br><br>';
		$html.= 'Efetue o pagamento através da URL abaixo:<br>';
		$html.= $url_pag.'<br><br>';
		$html.= 'O prazo de recebimento do pagamento é de até 3 dias após a realização do mesmo.<br>';
		$html.= 'Assim que seu pagamento for recebido, enviaremos uma confirmação via e-mail.<br>';
		$html.= 'E-mail enviado automaticamente, qualquer dúvida estamos disponíveis para resposta.';
		
		Email::sendMail($user['email'], 'Você se inscreveu em um evento ..', $html);
	}

	private function enviarEmailEventoFree($data, $user){
		$evento = new EventoModel();
		$evento = $evento->getData($data['id_evento']);
		$evento = $evento[0];

		$html = 'Confirmação de inscrição:<br>';
		$html.= $user['nome'].', obrigado por se inscrever no evento: <br>';
		$html.= $evento['titulo'].'<br>';
		$html.= 'Seu código de inscrição é: '.$data['id_inscricao'].'<br>';
		$subeventos = $this->codigoSubEventos($data['id_inscricao'], $data['id_evento']);
		if($subeventos){
			$html.= 'Os códigos de inscrição dos seus sub-eventos são:<br>';
			foreach ($subeventos as $subevento) {
				$html.=$subevento['titulo'].': '.$subevento['codigo'].'<br>';
			}
		}
		$html.= 'Não esqueça que é indispensável na entrada dos eventos a apresentação dos códigos de inscrições em eventos e subeventos juntamente com documento de identidade com foto.<br>';
		$html.='Muito obrigado, e bons eventos para você!';
		
		Email::sendMail($user['email'], 'Você se inscreveu em um evento ..', $html);
	}

	function getInscricoesNaoPagas(){
		$sql = $this->db->query("SELECT id_inscricao, id_usuario, data_inscricao, url, id_evento FROM inscricao WHERE pagamento = 0");
		$inscricoes = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $inscricoes;
	}

	function getInscritosNoEvento($id){
		$sql = $this->db->query("SELECT id_usuario FROM inscricao WHERE id_evento = $id");
		$inscricoes = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $inscricoes;
	}

	private function idEventoDaInscricao($id_inscricao){
		$query = 'SELECT id_evento FROM inscricao WHERE id_inscricao = '.$id_inscricao;
		$prep = $this->db->prepare($query);
		$prep->execute();
		$id_evento = $prep->fetch(PDO::FETCH_ASSOC);
		$id_evento = $id_evento['id_evento'];
		return $id_evento;
	}

	private function idsSubEventosDaInscricao($id_inscricao){
		$query = 'SELECT id_subevento FROM inscricao_subevento WHERE id_inscricao = '.$id_inscricao;
		$prep = $this->db->prepare($query);
		$prep->execute();
		$id_subeventos = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $id_subeventos;
	}

	private function excluirInscricaoSubeventos($id_inscricao){
		$query = 'DELETE FROM inscricao_subevento WHERE id_inscricao = '.$id_inscricao;
		$prep = $this->db->prepare($query);
		$prep->execute();
	}

	private function excluirInscricaoEvento($id_inscricao){
		$query = 'DELETE FROM inscricao WHERE id_inscricao = '.$id_inscricao;
		$prep = $this->db->prepare($query);
		$prep->execute();
	}

	function cancelar($id_inscricao){
		$id_subeventos = $this->idsSubEventosDaInscricao($id_inscricao);
		$id_evento = $this->idEventoDaInscricao($id_inscricao);

		foreach ($id_subeventos as $id) {
			$this->incrementarVagas('subevento', $id['id_subevento']);
		}
		$this->excluirInscricaoSubeventos($id_inscricao);
		$this->excluirInscricaoEvento($id_inscricao);
		$this->incrementarVagas('evento', $id_evento);
	}

	function confirmarPagamento($id){
		$query = "UPDATE inscricao SET pagamento=1 WHERE id_inscricao=$id";
		$prep = $this->db->prepare($query);
		$prep->execute();
	}

	function codigoSubeventos($id_inscricao, $id_evento){
		$query = "SELECT id_inscricao_subevento, id_subevento FROM inscricao_subevento WHERE id_inscricao = $id_inscricao";
		$prep = $this->db->prepare($query);
		$prep->execute();
		$data = $prep->fetchAll(PDO::FETCH_ASSOC);

		$retorno = array();
		foreach ($data as $item) {
			$retorno[$item['id_subevento']]['codigo'] = $item['id_inscricao_subevento'];
			$subevento = new SubeventoModel();
			$subevento = $subevento->getData($id_evento,$item['id_subevento']);
			$retorno[$item['id_subevento']]['titulo'] = $subevento[0]['titulo'];
		}
		
		return $retorno;
	}

	function inscricoesPorUsuario($id_user){
		$eventos_pagos = $this->inscricoesPagasPorUsuario($id_user);
		$eventos_pendentes = $this->inscricoesPendentesPorUsuario($id_user);
		return array('pagos' => $eventos_pagos, 'pendentes' => $eventos_pendentes);
	}

	private function inscricoesPagasPorUsuario($id_user){
		$query = "SELECT evento.titulo, evento.data_limite, inscricao.data_inscricao, inscricao.pagamento , inscricao.url FROM inscricao INNER JOIN evento ON evento.id_evento = inscricao.id_evento WHERE inscricao.id_usuario = $id_user AND inscricao.pagamento = 1";
		$prep = $this->db->prepare($query);
		$prep->execute();
		$eventos_pagos = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $eventos_pagos;
	}

	private function inscricoesPendentesPorUsuario($id_user){
		$query = "SELECT evento.titulo, evento.data_limite, inscricao.data_inscricao, inscricao.pagamento, inscricao.url FROM inscricao INNER JOIN evento ON evento.id_evento = inscricao.id_evento WHERE inscricao.id_usuario = $id_user AND inscricao.pagamento = 0";
		$prep = $this->db->prepare($query);
		$prep->execute();
		$eventos_pendentes = $prep->fetchAll(PDO::FETCH_ASSOC);
		return $eventos_pendentes;
	}
}