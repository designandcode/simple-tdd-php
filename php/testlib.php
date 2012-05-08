<link href="../../css/tests.css" rel="stylesheet" type="text/css" />
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
	function assertWrapper($type, $funcname,$expected, $result, $comparison){
		if($type=="pass")
			return("<dl class=\"assert assert-pass\"><dt>PASS - Expected: $funcname( ) $comparison $expected</dt><dd>Got: $funcname( ) $comparison $result</dd></dl>");
		else
			return("<dl class=\"assert assert-fail\"><dt>Fail - Expected: $funcname( ) $comparison $expected</dt><dd>Got: $funcname( ) $comparison $result</dd></dl>");
	}

	// Match Weakly Typed
	function assertStringWeak($funcname, $expected, $customMessage=""){
		include_once($funcname . ".php");
		$result = call_user_func($funcname);
		if($result == $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}	
		echo assertWrapper($pass,$funcname,$expected,$result,"==");
	}

	// Match Strongly Typed
	function assertStringStrong($funcname, $expected, $customMessage=""){
		include_once($funcname . ".php");
		$result = call_user_func($funcname);
		if($result === $expected) {
			$pass = true;
			assertRegister("pass");
		}
		else {
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$funcname,$expected,$result,"===");
	}

	// Match Pattern
	function assertStringMatch($funcname, $expected, $customMessage=""){
		include_once($funcname . ".php");
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
		echo assertWrapper($pass,$funcname,$expected,$result,"at {position $pos} found ");
	}

	// Match Array Length
	function assertArrayLength($funcname, $expected){
		include_once($funcname . ".php");
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
		echo assertWrapper($pass,$funcname,$expected,$length,"length =");
	}

	// Match Array Value
	function assertArrayValue($funcname, $expected){
		include_once($funcname . ".php");
		$result = call_user_func($funcname);
		$key = array_search($expected, $result);
		$value = $result[$key];
		if($key != false){
			$pass = true;
			assertRegister("pass");
		} else{
			$pass = false;
			assertRegister("fail");
		}
		echo assertWrapper($pass,$funcname,$expected,$value,"at {position $key} found ");
	}


?>