<?php

include_once("../testlib.php");
//include_once("../foo.php");
//include_once("../barz.php");

assertStringWeak("foo",false);
assertStringStrong("foo",false);
assertStringMatch("bar","foo is barz"/*,"The return string contains the characters 'foo is barz' at least once"*/);
assertArrayLength("baz",3);
assertArrayValue("baz","two");
//echo foo();
//print_r($register);
echo assertHeader();

?>