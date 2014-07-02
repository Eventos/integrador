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
			
			$id_inscricao = $this->inscricaoEvento($user['id_usuario'], $data['id_evento']);
			if(isset($data['subevento'])){
				foreach ($data['subevento'] as $id_subevento) {
					$this->inscricaoSubevento($id_subevento, $id_inscricao);
				}
			}

			Flash::setMessage('success', 'Inscrição feita com sucesso, realize seu pagamento!');
			App::redirect('inscricao');
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}

	private function inscricaoEvento($id_usuario, $id_evento){
		$autoIncrement = $this->getNextIncrement('inscricao');
		$query = "INSERT INTO inscricao (data_inscricao, pagamento, id_usuario, id_evento) VALUES (CURDATE(), '0', :id_usuario, :id_evento)";
		$values = array(
				':id_usuario' => $id_usuario,
				':id_evento' => $id_evento,
			);

		$prep = $this->db->prepare($query);
		$prep->execute($values);
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
	}
}