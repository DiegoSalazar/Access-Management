<?php
	session_start(); 
	//confirm logged in
	if (!isset($_SESSION['user_id'])){
		header("Location: index.php"); 
		exit;
	}
?>