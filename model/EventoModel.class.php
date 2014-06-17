<?php
/**
* Classe que controla os eventos
*/
class EventoModel extends ModelAbstract
{
	private $palestrante;
	private $estado;

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

			$query = "INSERT INTO evento (local, descricao_contato, data_hora, data_limite, vagas, aberto, desc_evento, email_contato, telefone_contato, id_cidade, id_administrador, facebook, twitter, google_plus, id_palestrante) VALUES (:local, :descricao_contato, :data_hora, :data_limite, :vagas, :aberto, :desc_evento, :email_contato, :telefone_contato, :id_cidade, :id_administrador, :facebook, :twitter, :google_plus, :palestrante)";
			$values = array(':local' => $data['local'],
							':descricao_contato' => $data['desc_contato'],
							':data_hora' => $data['data_hora'],
							':data_limite' => $data['data_limite'],
							':vagas' => $data['vagas'],
							':aberto' => $aberto,
							':desc_evento' => $data['desc_evento'],
							':email_contato' => $data['email_contato'],
							':telefone_contato' => $data['telefone_contato'],
							':id_cidade' => $data['cidade'],
							':id_administrador' => (int)$id_administrador,
							':facebook' => $data['facebook'],
							':twitter' => $data['twitter'],
							':google_plus' => $data['google_plus'],
							':palestrante' => $data['palestrante']
					);
			$prep = $this->db->prepare($query);
			
			$query = $prep->execute($values);

			$valores = $data['valores'];
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
			}
			Flash::setMessage('info', 'Insira agora fotos e vídeos para seu evento');
			App::redirect('admin/eventos/media/'.$id_evento);
		}catch(Exception $e){
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}
}