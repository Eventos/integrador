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
			elseif ($params[0] == 'user'){

				$this->render('login_user');
			}
			else{
				App::errorPage("Parametro não encontrado");
			}
		}else{
			App::errorPage("PAGINA NAO ENCONTRADA");
		}
	}
	public function loggerAction($params){
		$data = $_POST;
		$login = new LoginModel();
		if (isset($_POST['email']) && isset($_POST['password'])){	
			if($data['email'] <> '' && $data['password'] <> ''){	
				if ($params[0]  == 'user'){
					if(isset($params[1]) && $params[1]=='inscricao'){
						$login->logginUser($data['email'],$data['password'],'inscricao');
					}elseif(isset($params[2]) && $params[1]=='execute'){
						$login->logginUser($data['email'],$data['password'],'execute',$params[2]);
					}else	
						$login->logginUser($data['email'],$data['password']);
				}elseif($params[0] == 'admin'){
					$login->logginAdm($data['email'],$data['password']);
				}else
					App::errorPage('Parametro Invalido');
			}else{
				Flash::setMessage("danger","Erro ao Solicitar login");
				App::redirect(App::getUrl().'login/verify/'.$params[0]);
			}
		}else
			App::errorPage();
	}
}