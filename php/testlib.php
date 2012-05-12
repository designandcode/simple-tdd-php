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
	function assertWrapper($pass,$expected, $result, $comparison, $callee, $func="", $parms="", $customMessage=""){
		$texpected = gettype($expected);
		$tresult = gettype($result);
		$parms = implode('","', $parms);
		if($pass=="pass")
			return("<dl class=\"assert assert-pass\"><dt>PASS ($callee) -> $func(\"$parms\") - Expected ($texpected) $expected $comparison ($tresult) $result</dt><dd>$customMessage &nbsp;</dd></dl>");
		else
			return("<dl class=\"assert assert-fail\"><dt>Fail ($callee) -> $func(\"$parms\") - Expected ($texpected) $expected $comparison ($tresult) $result</dt><dd>$customMessage &nbsp;</dd></dl>");
	}

	// Import Module
	function import($module){
		include_once($module . ".php");
		return $module;
	}

	// Match Weakly Typed
	function assertStringWeak($module, $parms, $expected, $customMessage=""){
		$callee = __FUNCTION__;
		$func = $module;
		$parms = explode(",", $parms);
		$result = call_user_func_array($func, $parms);
		if($result == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$expected,$result,"==",$callee,$func,$parms,$customMessage);	
	}
	

	// Match Strongly Typed
	function assertStringStrong($module, $parms, $expected, $customMessage=""){
		$callee = __FUNCTION__;
		$func = $module;
		$parms = explode(",", $parms);
		$result = call_user_func_array($func, $parms);
		if($result === $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$expected,$result,"===",$callee,$func,$parms,$customMessage);
	}

	// Match Pattern
	function assertInString($module, $parms, $expected, $customMessage=""){
		$callee = __FUNCTION__;
		$func = $module;
		$parms = explode(",", $parms);
		$result = call_user_func_array($func, $parms);
		$pattern = "$expected";
		$pos = strpos($result, $pattern);
		if($pos !== false) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$expected,$result,"found ",$callee,$func,$parms,$customMessage);
	}

	// Match Array Length
	function assertArrayLength($module, $function, $expected, $customMessage=""){
		$callee = __FUNCTION__;
		$func = $module;
		$parms = explode(",", $parms);
		$result = call_user_func_array($func, $parms);
		$length = count($result);
		if($length == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$expected,$length,"found ",$callee,$func,$parms,$customMessage);
	}

	// Match Array Value
	function assertInArray($module, $function, $expected, $customMessage){
		$callee = __FUNCTION__;
		$func = $module;
		$parms = explode(",", $parms);
		$result = call_user_func_array($func, $parms);
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
		echo assertWrapper($pass,$expected,$value,"found ",$callee,$func,$parms,$customMessage);
	}


?>