<?php
/**
* Classe de que realiza o pagamento via PagSeguro
*/
class PagseguroModel extends ModelAbstract
{
	public $credenciais;

	function __construct(){
		require SITE_ROOT.'model/PagSeguro/PagSeguroLibrary.php';
		$this->credenciais = new PagSeguroAccountCredentials(EMAIL_PAGSEGURO, TOKEN_PAGSEGURO);
	}

	function pagamento($data){

		try{
			$arrayPagamento = $this->montarArray($data);
			$url_pag = $this->executarPagamento($arrayPagamento);
			return $url_pag;
		}catch(Exception $e){
			exit;
			Flash::setMessage('danger', 'Ops: '.$e->getMessage());
			App::redirect('admin/index');
		}
	}

	private function executarPagamento($pagamento){
		try{
			$pagseguro = new PagSeguroPaymentRequest();
			$pagseguro->setCurrency("BRL");
			$pagseguro->setShippingType(3);
			$transaction_id = $pagamento['transaction_id'];
			$pagseguro->setReference($transaction_id);

			$user = $_SESSION['user'];

			$pagseguro->setSender($user['name'], $user['email'], '', '');

			$pagseguro->addItem($pagamento['evento']['id'], $pagamento['evento']['titulo'], 1, (float)$pagamento['evento']['valor'], 0);

			if(isset($pagamento['subevento'])){
				foreach ($pagamento['subevento'] as $id => $item) {
					$pagseguro->addItem($id, $item['titulo'], 1, (float)$item['valor']);
				}
			}
			/*var_dump($pagseguro, $this->credenciais);*/
			$url = $pagseguro->register($this->credenciais);
			return $url;

		} catch (PagSeguroServiceException $e) {
		    foreach ($e->getErrors() as $key => $error) {  
		        echo $error->getCode().' - '; // imprime o código do erro  
		        echo $error->getMessage().'<br>'; // imprime a mensagem do erro  
		    }  
		} catch (Exception $erro){
			var_dump($erro);
		}


	}

	private function montarArray($data){
		$pagamento = array();

		$evento = new EventoModel();
		$id_evento = $data['id_evento'];
		$dataEvento = $evento->getData($id_evento);			
		$pagamento['transaction_id'] = $data['id_inscricao'];
		$pagamento['evento']['id'] = $id_evento;
		$pagamento['evento']['valor'] = $evento->getValueEventoById($id_evento);
		$pagamento['evento']['titulo'] = 'Evento: '.$dataEvento[0]['titulo'];

		$pagamento['subevento'] = array();
		if(isset($data['subevento'])){
			foreach ($data['subevento'] as $subevento) {
				$_subevento = new SubeventoModel();
				$data = $_subevento->getData($id_evento, $subevento);
				$id = $id_evento.'-'.$subevento;
				$pagamento['subevento'][$id]['valor'] = $_subevento->getValueSubeventoById($subevento);
				$pagamento['subevento'][$id]['titulo'] = 'Subevento: '.$data[0]['titulo'];
			}
		}

		return $pagamento;
	}

	function verificarTransacao($codigo){
		$url = 'https://ws.pagseguro.uol.com.br/v2/transactions?email='.EMAIL_PAGSEGURO.'&token='.TOKEN_PAGSEGURO.'&reference='.$codigo;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		$transaction = curl_exec($curl);
		$transaction = iterator_to_array(simplexml_load_string($transaction));

		foreach ($transaction['transactions'] as $t) {
			$return = array(
				'codigo' => (string)$t->code,
				'status' => (string)$t->status
			);
			return $return;
		}
	}

}