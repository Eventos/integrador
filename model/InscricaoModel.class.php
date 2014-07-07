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

			$pagamento = new PagseguroModel();
			$url_pag = $pagamento->pagamento($data);

			$id_inscricao = $this->inscricaoEvento($user['id_usuario'], $data['id_evento'], $url_pag);
			if(isset($data['subevento'])){
				foreach ($data['subevento'] as $id_subevento) {
					$this->inscricaoSubevento($id_subevento, $id_inscricao);
				}
			}

			$this->enviarEmail($url_pag, $user);

			$this->render('evento/pagseguro', array('url' => $url_pag), true);
			exit;
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
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

	function getInscricoesNaoPagas(){
		$sql = $this->db->query("SELECT id_inscricao, id_usuario, data_inscricao, url, id_evento FROM inscricao WHERE pagamento = 0");
		$inscricoes = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $inscricoes;
	}
}