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

			$query = "INSERT INTO subevento (local, descricao, data_hora, vagas, data_limite, id_evento, aberto, id_palestrante) VALUES (:local, :descricao, :data_hora, :vagas, :data_limite, :id_evento, :aberto, :id_palestrante)";
			$values = array(
					':local' => $data['local'],
					':descricao' => $data['desc_subevento'],
					':data_hora' => $data['data_hora'],
					':vagas' => $data['vagas'],
					':data_limite' => $data['data_limite'],
					':id_evento' => $id_evento,
					':aberto' => $aberto,
					':id_palestrante' => $data['palestrante']
			);

			$prep = $this->db->prepare($query);
			$query = $prep->execute($values);
			if(!$query) throw new Exception('Erro na inserção..');

			$valores = $data['valores'];
			$this->insertValues($valores, $id_subevento);
			
			Flash::setMessage('success', 'Sub-evento inserido com sucesso');
			App::redirect('admin/index');
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
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
}