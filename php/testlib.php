<style>
.assert{
	color:white;
}
.assert-pass{
	background:green;
}
.assert-fail{
	background:red;
}
</style>
<?php

// Tracks number of tests run and fail/pass
	$register = array();
	$count = 0;
	function assertCount(){
		global $count;
		return $count++;
	}
	function assertRegister($type){
		global $register;
		array_push($register, $type);
		return $register;
	}
	function assertHeader(){
		global $register;
		rsort($register);
		$count = count($register);
		echo $count . ' tests run - ';
		foreach(array_count_values($register) as $key=>$value){
			echo $value . ': ' . $key . '  ';
		}
	}

	// Prettify asserts
	function assertWrapper($pass,$expected, $result, $comparison, $callee, $customMessage="",$print){
		global $count;
		$texpected = gettype($expected);
		$tresult = gettype($result);
		$outcome = ($print) ? "<dd>$print</dd>" : "";
		if($pass=="pass")
			return("<dl class=\"assert assert-pass\"><dt>$count - PASS ($callee) - Expected ($texpected) $expected $comparison ($tresult) $result</dt><dd>$customMessage &nbsp;</dd>$outcome</dl>");
		else
			return("<dl class=\"assert assert-fail\"><dt>$count - Fail ($callee) - Expected ($texpected) $expected $comparison ($tresult) $result</dt><dd>$customMessage &nbsp;</dd>$outcome</dl>");
	}

	// Import Module
	function import($module){
		include_once($module . ".php");
		return $module;
	}

	// Match Weakly Typed
	function assertStringWeak($function, $expected, $customMessage="",$print=false){
		$callee = __FUNCTION__;
		$print = ($print) ? var_export($function, true) : $print;
		$result = $function;
		if($result == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		assertCount();
		echo assertWrapper($pass,$expected,$result,"==",$callee,$customMessage,$print);
	}
	

	// Match Strongly Typed
	function assertStringStrong($function, $expected, $customMessage="",$print=false){
		$callee = __FUNCTION__;
		$print = ($print) ? var_export($function, true) : $print;
		$result = $function;
		if($result === $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		assertCount();
		echo assertWrapper($pass,$expected,$result,"===",$callee,$customMessage,$print);
	}

	// Match Pattern
	function assertInString($function, $expected, $customMessage="",$print=false){
		$callee = __FUNCTION__;
		$print = ($print) ? var_export($function, true) : $print;
		$result = $function;
		$pattern = "$expected";
		$pos = strpos((string) $result, $pattern);
		if($pos !== false) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		assertCount();
		echo assertWrapper($pass,$expected,$result,"found ",$callee,$customMessage,$print);
	}

	// Match Array Length
	function assertArrayLength($function, $expected, $customMessage="",$print=false){
		$callee = __FUNCTION__;
		$print = ($print) ? var_export($function, true) : $print;
		$result = $function;
		$length = count($result);
		if($length == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		assertCount();
		echo assertWrapper($pass,$expected,$length,"found ",$callee,$customMessage,$print);
	}

	// Match Array Value
	function assertInArray($function, $expected, $customMessage,$print=false){
		$callee = __FUNCTION__;
		$print = ($print) ? var_export($function, true) : $print;
		$result = $function;
		if(count($result) != count($result, COUNT_RECURSIVE)){
			$values = array();
			foreach($result as $line){
				foreach($line as $element){
					array_push($values, $element);
				}
			}
			$result = $values;
			$key = array_search($expected, $result);
		} else {
			$key = array_search($expected, $result);
		}
		$value = $result[$key];
		if($key !== false){
			$pass = true;
			assertRegister("pass");
		} else{
			$pass = false;
			assertRegister("fail");
		}
		assertCount();
		echo assertWrapper($pass,$expected,$value,"found ",$callee,$customMessage,$print);
	}


?>