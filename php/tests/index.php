<?php

include_once("../testlib.php");
include_once("../functions.php");

assertStringWeak(
	toUpperCase(foo(),"bar"),
	"FOO BAR",
	"toUpperCase() converts Foo Bar to FOO BAR",
	true
);
assertStringStrong(
	toUpperCase("foo","bar"),
	"FOO BAR",
	"toUpperCase() converts Foo Bar to FOO BAR",
	true
);
assertInString(
	bar(),
	"Foo is barz",
	"bar() contains the text foo is barz",
	true
);
assertArrayLength(
	baz(),
	5,
	"baz() returned 5 items",
	true
);
assertInArray(
	baz(),
	"three",
	"baz() returned an array containing at least on value equal to three",
	true
);
assertInArray(
	baz(),
	"Mike",
	"baz() returned an array containing at least one value equal to Mike",
	true
);
echo assertHeader();

?>