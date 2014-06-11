<?php
/**
* Helper para renderizar cidades e estados
*/
class Local
{
	private static function getEstados(){
		$local = new LocalModel();
		return $local->getEstados();
	}

	private static function getCidades(){
		$local = new LocalModel();
		return $local->getCidades();
	}

	private static function getData(){
		$cidades = self::getCidades();
		$data = array();
		foreach ($cidades as $cidade) {
			$data[$cidade['id_estado']][$cidade['id_cidade']] = $cidade['nome'];
		}
		return $data;
	}

	static function getSelectCidades($id_estado){
		$data = self::getData();
		$html = '<select name="cidade" class="cidades form-control">';
		foreach ($data[$id_estado] as $id_cidade => $cidade) {
			$html .= '<option value="'.$id_cidade.'">'.$cidade.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	static function getSelectEstados(){
		//$data = self::getData();
		$estados = self::getEstados();
		$html = '<select name="estados" class="estados form-control">';
		foreach ($estados as $estado) {
			$html .= '<option value="'.$estado['id_estado'].'">'.$estado['nome'].'</option>';
		}
		$html .= '</select>';
		return $html;
	}
}