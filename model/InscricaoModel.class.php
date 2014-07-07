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
			
			$pagamento = new PagseguroModel();
			$url_pag = $pagamento->pagamento($data);

			$id_inscricao = $this->inscricaoEvento($user['id_usuario'], $data['id_evento'], $url_pag);
			if(isset($data['subevento'])){
				foreach ($data['subevento'] as $id_subevento) {
					$this->inscricaoSubevento($id_subevento, $id_inscricao);
				}
			}
			
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
}