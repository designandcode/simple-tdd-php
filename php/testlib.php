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
	function assertWrapper($pass, $namespace, $funcname,$expected, $result, $comparison, $customMessage=""){
		if($pass=="pass")
			return("<dl class=\"assert assert-pass\"><dt>PASS - Expected: $namespace:$funcname( ) $comparison $expected</dt><dd>Got: $namespace:$funcname( ) $comparison $result</dd><dd>$customMessage &nbsp;</dd></dl>");
		else
			return("<dl class=\"assert assert-fail\"><dt>Fail - Expected: $namespace:$funcname( ) $comparison $expected</dt><dd>Got: $namespace:$funcname( ) $comparison $result</dd><dd>$customMessage &nbsp;</dd></dl>");
	}

	// Match Weakly Typed
	function assertStringWeak($namespace, $funcname, $expected, $customMessage=""){
		include_once($namespace . ".php");
		$result = call_user_func($funcname);
		if($result == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}	
		echo assertWrapper($pass,$namespace,$funcname,$expected,$result,"==",$customMessage);
	}

	// Match Strongly Typed
	function assertStringStrong($namespace, $funcname, $expected, $customMessage=""){
		include_once($namespace . ".php");
		$result = call_user_func($funcname);
		if($result === $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$namespace,$funcname,$expected,$result,"===");
	}

	// Match Pattern
	function assertStringMatch($namespace, $funcname, $expected, $customMessage=""){
		include_once($namespace . ".php");
		$result = call_user_func($funcname);
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
		echo assertWrapper($pass,$namespace,$funcname,$expected,$result,"at {position $pos} found ");
	}

	// Match Array Length
	function assertArrayLength($namespace, $funcname, $expected){
		include_once($namespace . ".php");
		$result = call_user_func($funcname);
		$length = count($result);
		if($length == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$namespace,$funcname,$expected,$length,"length =");
	}

	// Match Array Value
	function assertArrayValue($namespace, $funcname, $expected){
		include_once($namespace . ".php");
		$result = call_user_func($funcname);
		if(count($result) != count($result, COUNT_RECURSIVE)){
			$values = array();
			foreach($result as $line){
				foreach($line as $element){
					array_push($values, $element);
				}
			}
			// echo "This is a multidimensional array";
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
		echo assertWrapper($pass,$namespace,$funcname,$expected,$value,"at {position $key} found ");
	}


?>