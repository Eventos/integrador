<?php
/**
* Classe que controla a página home do site
*/
class IndexController extends ControllerAbstract
{	
	public function indexAction($params){
		if(count($params) <= 1){
			if(isset($params[0]) && $params[0] == 'eventos'){
				die('Página que exibe os eventos');
			}elseif(isset($params[0]) && $params[0] == 'index' || isset($params[0]) && $params[0] == ''){
				$this->render('index');
			}elseif (count($params) == 0){
				$this->render('index');
			}else{
				App::errorPage('Action para index não encontrada');
			}
			
		}elseif(count($params) == 2){

		}else{
			App::errorPage();
		}
	}

	public function testeAction($params){
		/*var_dump($params);*/
	}
	public function loginAction($params){
		if(count($params) == 1){
			if ($params[0] == 'admin')
				$this->render('admin/login_admin');
			elseif ($params[0] == 'user')
				$this->render('login_user');
			else{
				App::errorPage("Parametro não encontrado");
			}
		}else{
			App::errorPage("PAGINA NAO ENCONTRADA");
		}
	}
	public function loggerAction($params){
		if(count($params) == 1){
			if (isset($_POST['email']) && isset($_POST['password']))
			{	
				$data = $_POST;
				$login = new LoginModel();
				if($data['email'] <> '' && $data['password'] <> '')
				{	
					if ($params[0]  == 'user')
						$login->logginUser($data['email'],$data['password']);
					elseif ($params[0] == 'adm' )
						$login->logginAdm($data['email'],$data['password']);
					else
						App::errorPage('Parametro Invalido');
				}
			}
			else
				throw new Exception("Erro ao Solicitar login", 1);
		}
	}
}