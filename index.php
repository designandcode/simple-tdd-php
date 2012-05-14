<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>EMPTY</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--script type="text/javascript" src="jQuery/jquery-1.3.2.js"></script-->
<!--script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script-->
</head>
<body>
<?php


	// functions under test
	include_once("php/functions.php");



	
?>
<p><?php echo foo(); ?></p>
<p><?php echo bar(); ?></p>
<p>
<?php foreach(baz() as $baz): ?>
<li><?php echo $baz ?></li>
<?php endforeach; ?>
</p>
<p><?php echo toUpperCase( foo(), "bar") ?></p>
</body>
</html>