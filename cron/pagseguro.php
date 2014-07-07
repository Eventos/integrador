<?php
ini_set('display_errors', 1);
echo '<pre>';
require('../core/App.class.php');
$app = new App('/var/www/integrador/');
$app->ready();
$inscricoes = new InscricaoModel();
$inscricoes = $inscricoes->getInscricoesNaoPagas();

foreach ($inscricoes as $inscricao) {
	$evento = new EventoModel();
	$evento = $evento->getData($inscricao['id_evento']);
	$evento = $evento[0];

	$url_pagseguro = $inscricao['url'];
	
	$data_inscricao = new DateTime($inscricao['data_inscricao']);
	$hoje = new DateTime();
	$dif_date = date_diff($data_inscricao, $hoje);
	$dif_date = (int)$dif_date->format('%a');

	$user = new UserModel();
	$user = $user->getUserById($inscricao['id_usuario']);

	$id_pagseguro = $inscricao['id_inscricao'];
	$id_pagseguro = 126;

	$pagseguro = new PagseguroModel();
	$transacao = $pagseguro->verificarTransacao($id_pagseguro);

	if($transacao['status'] == 1){ //AINDA NÃO FOI PAGO

		if($dif_date == 3){
			$html = 'Olá, você se cadastrou no evento e ainda não realizou o pagamento?<br>';
			$html.= 'Realize já o pagamento, você ainda tem 4 dias!<br>';
			$html.= '<a href="'.$url_pagseguro.'"></a>Realizar pagamento<br>';
			$html.= 'Se você já realizou o pagamento, desconsidere este e-mail.';
			
			Email::send($user['email'], 'Realize o pagamento do seu evento', $html);
		}elseif($dif_date >= 7){
			//CANCELAR INSCRIÇÃO

			$html = 'Olá, você se cadastrou no evento e ainda não realizou o pagamento.<br>';
			$html .= 'Conforme as nossas regras, após 7 dias da inscrição, caso o pagamento não tenha sido realizado, cancelamos a inscrição. Desculpe pelo transtorno!<br>';
			Email::send($user['email'], 'Realize o pagamento do seu evento', $html);
		}

	}elseif($transacao['status'] == 3 || $transacao['status'] == 4){ //JÁ FOI PAGO
		//CONFIRMAR INSCRIÇÃO E ENVIAR EMAIL PRO USUARIO E ADM
	}

	exit;
}