<?php
	$con = mysql_connect("localhost","root", "deenies01*");
	if (!$con) {
	  die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db('deeniesdb', $con);
?>