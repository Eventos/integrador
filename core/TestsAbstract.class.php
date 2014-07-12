<?php
/**
* Classe base para testes
*/
class TestsAbstract
{
	protected function testValues($value1, $value2, $compare_type = false, $msg = null){
		if($compare_type){
			$result = $value1 === $value2 ? true : false;
		}else{
			$result = $value1 == $value2 ? true : false;
		}

		$this->printResult($result, $msg);
		return $result;
	}

	protected function testArray($value, $count, $msg = null){
		$result = count($value) == $count ? true : false;
		$this->printResult($result, $msg);
		return $result;
	}

	protected function testArrayValid($value, $msg = null){
		$result = count($value) > 0 ? true : false;
		$this->printResult($result, $msg);
		return $result;
	}

	protected function testArrayCount($value, $count ,$msg = null, $exp = false){
		$c = $exp ? $count : 0;
		$result = count($value) > $c ? true : false;
		$this->printResult($result, $msg);
		return $result;
	}

	protected function testType($value1, $type, $msg = null){
		$result = gettype($value1) == $type ? true : false;
		$this->printResult($result, $msg);
		return $result;
	}

	private function printResult($result, $msg){
		echo '<br>';
		echo $msg.'<br>';
		echo $result ? 'Success' : 'Failure';
		echo '<br>';
	}
}