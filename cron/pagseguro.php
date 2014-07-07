<?php
ini_set('display_errors', 1);
echo 'Iniciando CRON de verificação de pagamentos.'."\n";
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

	$_inscricao = new InscricaoModel();

	$pagseguro = new PagseguroModel();
	$transacao = $pagseguro->verificarTransacao($id_pagseguro);

	if($transacao['status'] == 1){ 

		if($dif_date == 3){ // 3 DIAS DEPOIS ENVIA AVISO AO COMPRADOR
			$html = 'Olá, você se cadastrou no evento e ainda não realizou o pagamento?<br>';
			$html.= 'Realize já o pagamento, você ainda tem 4 dias!<br>';
			$html.= '<a href="'.$url_pagseguro.'"></a>Realizar pagamento<br>';
			$html.= 'Se você já realizou o pagamento, desconsidere este e-mail.';
			
			Email::sendMail($user['email'], 'Realize o pagamento do seu evento', $html);
			echo 'Enviado e-mail de lembrete da inscrição: '.$inscricao['id_inscricao']."\n";
		}elseif($dif_date >= 7){ // 7 DIAS DEPOIS, CANCELA A INSCRIÇÃO
			$_inscricao->cancelar($inscricao['id_inscricao']);

			$html = 'Olá, você se cadastrou no evento e ainda não realizou o pagamento.<br>';
			$html .= 'Conforme as nossas regras, após 7 dias da inscrição, caso o pagamento não tenha sido realizado, cancelamos a inscrição. Desculpe pelo transtorno!<br>';
			Email::sendMail($user['email'], 'Inscrição para o evento cancelada', $html);
			echo 'Cancelada a inscrição: '.$inscricao['id_inscricao']."\n";
		}

	}elseif($transacao['status'] == 3 || $transacao['status'] == 4){ //JÁ FOI PAGO
		$_inscricao->confirmarPagamento($inscricao['id_inscricao']);

		$html = 'Confirmação de inscrição:<br>';
		$html.= $user['nome'].', obrigado por se inscrever no evento: <br>';
		$html.= $evento['titulo'].'<br>';
		$html.= 'Seu código de inscrição é: '.$inscricao['id_inscricao'].'<br>';
		$subeventos = $_inscricao->codigoSubEventos($inscricao['id_inscricao'], $inscricao['id_evento']);
		if($subeventos){
			$html.= 'Os códigos de inscrição dos seus sub-eventos são:<br>';
			foreach ($subeventos as $subevento) {
				$html.=$subevento['titulo'].': '.$subevento['codigo'].'<br>';
			}
		}
		$html.= 'Não esqueça que é indispensável na entrada dos eventos a apresentação dos códigos de inscrições em eventos e subeventos juntamente com documento de identidade com foto.<br>';
		$html.='Muito obrigado, e bons eventos para você!';

		Email::sendMail($user['email'], 'Inscrição para o evento confirmada', $html);
		$emailsAdm = new AdminModel();
		$emailsAdm = $emailsAdm->getAllEmailsAdm();
		foreach ($emailsAdm as $email) {
			Email::sendMail($email['email'], 'Inscrição para o evento confirmada', $html);
		}
		echo 'Confirmado pagamento da inscrição: '.$inscricao['id_inscricao']."\n";
	}

	exit;
}