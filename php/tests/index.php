<?php

include_once("../testlib.php");

assertStringWeak(
	import("toUpperCase"),
	"Foo,Bar",
	"FOO BAR",
	"function toUpperCase() converts Foo Bar to FOO BAR"
);
assertStringStrong(
	import("toUpperCase"),
	"Foo,Bar",
	"FOO BAR",
	"function toUpperCase() converts Foo Bar to FOO BAR"
);
assertInString(
	import("bar"),
	"",
	"Foo is barz",
	"bar contains the text foo is barz"
);
assertArrayLength(
	import("baz"),
	"",
	5,
	"Found 5 items"
);
assertInArray(
	import("baz"),
	"",
	"three",
	"Found three"
);
assertInArray(
	import("baz"),
	"",
	"Mike",
	"Found Mike"
);
echo assertHeader();

?>