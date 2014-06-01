<?php
/**
* Classe que controla o login do site
*/
class LoginController extends ControllerAbstract
{	
	public function verifyAction($params){
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
					if ($params[0]  == 'user'){
						$login->logginUser($data['email'],$data['password']);
						exit();
					}
					elseif ($params[0] == 'admin' ){
						$login->logginAdm($data['email'],$data['password']);
						exit();
					}
					else
						App::errorPage('Parametro Invalido');
				}
			}
			else
				Flash::setMessage("danger","Erro ao Solicitar login");
				App::redirect(App::getUrl().'login/verify/'.$params[0]);
		}
	}
}