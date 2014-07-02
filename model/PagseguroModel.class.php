<?php
/**
* Classe de que realiza o pagamento via PagSeguro
*/
class PagseguroModel extends ModelAbstract
{

	function pagamento($data){

		try{
			echo '<pre>';
			$arrayPagamento = $this->montarArray($data);
			$this->executarPagamento($arrayPagamento);
			exit;

		}catch(Exception $e){
			exit;
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}

	private function executarPagamento($pagamento){
		try{
			require SITE_ROOT.'model/PagSeguro/PagSeguroLibrary.php';
			$pagseguro = new PagSeguroPaymentRequest();
			$pagseguro->setCurrency("BRL");
			$pagseguro->setShippingType(3);
			$pagseguro->setReference(uniqid(true));

			$user = $_SESSION['user'];

			$pagseguro->setSender($user['name'], $user['email'], '', '');

			$pagseguro->addItem($pagamento['evento']['id'], $pagamento['evento']['titulo'], 1, (float)$pagamento['evento']['valor'], 0);

			foreach ($pagamento['subevento'] as $id => $item) {
				$pagseguro->addItem($id, $item['titulo'], 1, (float)$item['valor'], 0);
			}

			$credenciais = new PagSeguroAccountCredentials(EMAIL_PAGSEGURO, TOKEN_PAGSEGURO);

			$url = $pagseguro->register($credenciais);
			
			echo '<a href="'.$url.'" target="_blank">Ir para o PagSeguro</a>';
		} catch (PagSeguroServiceException $e) {  
		    foreach ($e->getErrors() as $key => $error) {  
		        echo $error->getCode().' - '; // imprime o código do erro  
		        echo $error->getMessage().'<br>'; // imprime a mensagem do erro  
		    }  
		}
	}

	private function montarArray($data){
		$pagamento = array();

		$evento = new EventoModel();
		$id_evento = $data['id_evento'];
		$dataEvento = $evento->getData($id_evento);			
		$pagamento['evento']['id'] = $id_evento;
		$pagamento['evento']['valor'] = $evento->getValueEventoById($id_evento);
		$pagamento['evento']['titulo'] = 'Evento: '.$dataEvento[0]['titulo'];

		$pagamento['subevento'] = array();
		foreach ($data['subevento'] as $subevento) {
			$_subevento = new SubeventoModel();
			$data = $_subevento->getData($id_evento, $subevento);
			$id = $id_evento.'-'.$subevento;
			$pagamento['subevento'][$id]['valor'] = $_subevento->getValueSubeventoById($subevento);
			$pagamento['subevento'][$id]['titulo'] = 'Subevento: '.$data[0]['titulo'];
		}

		return $pagamento;
	}

}