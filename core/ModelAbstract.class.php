<?php
/**
* Classe base para modelos
*/
class ModelAbstract
{
	public $db;

	function __construct(){
		$this->db = DbAbstract::openConnect();
	}

	protected function getNextIncrement($table){
		$query = $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".$table."'");
		$id_evento = $query->fetch(PDO::FETCH_ASSOC);
		$id_evento = $id_evento['AUTO_INCREMENT'];
		return $id_evento;
	}

	protected function organizeFiles($files){
		$dataFiles = array();
		foreach ($files as $files) {
			foreach ($files['name'] as $key => $value) {
				$dataFiles[$key]['name'] = $value;
			}
			foreach ($files['tmp_name'] as $key => $value) {
				$dataFiles[$key]['tmp_name'] = $value;
			}
		}
		return $dataFiles;
	}

	protected function render($view, $params = null, $clear = false){
		if($params !== null){
			extract($params);
		}
		if($clear){
			require_once(SITE_ROOT.'view/'.$view.'.phtml');	
		}
		elseif(strpos($view, 'evento') !== false && strpos($view , 'admin') === false){
			require_once(SITE_ROOT.'view/evento/header.phtml');
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			require_once(SITE_ROOT.'view/evento/footer.phtml');
		}
		elseif(strpos($view, 'admin') !== false && strpos($view, 'login') === false){
			require_once(SITE_ROOT.'view/admin/head.phtml');
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			require_once(SITE_ROOT.'view/admin/footer.phtml');
			
		}elseif((strpos($view, 'user') !== false  || strpos($view, 'inscricao')) !== false && strpos($view, 'login') === false && strpos($view, 'user_inscricao') === false){
			require_once(SITE_ROOT.'view/user/head.phtml');
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			require_once(SITE_ROOT.'view/user/footer.phtml');
			
		}else{
			require_once(SITE_ROOT.'view/'.$view.'.phtml');
			
		}
	}
}