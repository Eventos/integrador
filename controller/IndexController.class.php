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
			
		}else{
			App::errorPage();
		}
	}

	public function helpAction($params){
		$this->render('help');
	}

	public function newsletterAction($params){

		if(isset($_POST)){
			extract($_POST);

			if(isset($simple)){
				$user_simple = new UserModel();
				if ($user_simple->user_letter($email, $name)){
					Email::newsletter($email,$name,null);
					Flash::setMessage('success', 'Obrigado por se cadastrar em nossa newsletter');
					App::redirect();
				}
				else{
					Flash::setMessage('danger', 'Falha ao cadastrar tente novamente mais tarde ou entre em contato conosco!');
					App::redirect();
				}
				exit();
			}elseif(isset($full)){
				$data = array('name' => $name, 'email'=> $email); 
				$this->render('user/user_inscricao',$data);
				exit;
			}
		}	
	}
	
}