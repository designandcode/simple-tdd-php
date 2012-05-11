<?php

include_once("../testlib.php");
//include_once("../foo.php");
//include_once("../barz.php");

assertStringWeak("foo","foo",false,"function foo() returns false");
assertStringStrong("foo","foo",true);
assertStringMatch("bar","bar","foo is barz"/*,"The return string contains the characters 'foo is barz' at least once"*/);
assertArrayLength("bar","linkedlist",3);
assertArrayValue("bar","linkedlist","Mike");
assertArrayLength("baz","baz",3);
assertArrayValue("baz","baz","two");
//echo foo();
//print_r($register);
echo assertHeader();

?>