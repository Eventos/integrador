<?php
/**
* Testes
*/
class TesteController extends TestsAbstract
{
	private function adminTest(){
		$value1 = Admin::getMsg();
		$this->testType($value1, array(), 'Teste: Admin->getMsg');
	}

	private function blocosTest(){
		$value1 = Blocos::exists();
		$this->testValues($value1, true, true, 'Teste: Blocos->exists');

		$value1 = Blocos::getData();
		$this->testArrayValid($value1, 'Teste: Blocos->getData');
	}

	private function emailTest(){
		$value1 = Email::sendMail('ericodias1@gmail.com', 'teste', 'teste');
		$this->testValues($value1, true, true, 'Test: Email->sendMail');
	}

	private function eventoTest(){
		$value1 = Evento::SubEventoNewHelper();
		$this->testArrayValid($value1, 'Teste: Evento->SubEventoNewHelper');

		$value1 = Evento::newHelper();
		$this->testArrayValid($value1, 'Teste: Evento->newHelper');

		$value1 = Evento::mediaHelper();
		$this->testArray($value1, 2,'Teste: Evento->mediaHelper');

		$t1 = Evento::getEvento(1, 'info');
		$t2 = Evento::getEvento(1, 'all');
		$t3 = Evento::getEvento(1, 'encerrado');
		$this->testType($t1, 'array', 'Teste: Evento->getEvento(info)');
		$this->testType($t2, 'array', 'Teste: Evento->getEvento(all)');
		$this->testType($t3, 'array', 'Teste: Evento->getEvento(encerrado)');

		$value1 = Evento::selectEmailInscritos(3);
		$this->testType($value1, 'string', 'Teste: Evento->selectEmailInscritos');
	}

	private function flashTest(){
		Flash::setMessage('teste', 'teste');
		$value1 = $_SESSION['messages'];
		$this->testArray($value1, 1, 'Teste: Flash->setMessage');
	}

	private function localTest(){
		$value1 = Local::getSelectEstados();
		$this->testType($value1, 'string', 'Teste: Local->getEstados');	

		$value1 = Local::getSelectCidades(1);
		$this->testType($value1, 'string', 'Teste: Local->getCidades');	
	}

	private function mediaTest(){
		$value1 = Media::image_exists(1);
		$this->testType($value1, 'boolean', 'Teste: Media->image_exists');	

		$value1 = Media::getAllImages(1);
		$this->testType($value1, 'string', 'Teste: Media->getAllImages');	

		$value1 = Media::getImage(1);
		$this->testType($value1, 'string', 'Teste: Media->getImage');

		$value1 = Media::video_exists(1);
		$this->testType($value1, 'boolean', 'Teste: Media->video_exists');

		$value1 = Media::getAllVideos(1);
		$this->testType($value1, 'string', 'Teste: Media->getAllVideos');
	}

	private function pageTest(){
		$value1 = Page::urlImage('Ponto.png');
		$this->testType($value1, 'string', 'Teste: Page->urlImage');
	}

	private function palestranteTest(){
		$value1 = Palestrante::newHelper();
		$this->testArrayValid($value1, 'Teste: Palestrante->newHelper');
		
		$value1 = Palestrante::exists();
		$this->testType($value1, 'boolean', 'Teste: Palestrante->exists');
		
		$value1 = Palestrante::getPalestrantes();
		$this->testArrayValid($value1, 'Teste: Palestrante->getPalestrantes');

		$value1 = Palestrante::getImagePalestrante(2);
		$this->testType($value1, 'string', 'Teste: Palestrante->getImagePalestrante');
	}

	private function subeventoTest(){
		$value1 = Subevento::exists(3,1);
		$this->testValues($value1, true, true, 'Teste: Subevento->exists');

		$value1 = Subevento::getSubevento(3,2, 'info');
		$this->testArrayValid($value1, 'Teste: Subevento->getSubEvento');

		$value1 = Subevento::getValueSubeventoById(1);
		//SE NAO TIVER UM VALOR PARA O DIA, RETORNA NULL (UM DOS DOIS TESTES DEVE DAR CERTO)
		$this->testType($value1, 'NULL', 'Teste: Subevento->getSubEventoById');
		$this->testType($value1, 'string', 'Teste: Subevento->getSubEventoById');
	}

	private function userTest(){
		$value1 = User::listarEventosInscritos();
		$this->testArrayValid($value1, 'Teste: User->listarEventosInscritos');
	}

	function indexAction($params){
		$this->adminTest();
		$this->blocosTest();
		//$this->emailTest();
		$this->eventoTest();
		$this->flashTest();
		$this->localTest();
		$this->mediaTest();
		$this->pageTest();
		$this->palestranteTest();
		$this->subeventoTest();
		$this->userTest();
	}
}