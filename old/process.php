<?php
	session_start();
	include("includes/dbconnect.php");
	include("admin/classes.php");
	include("admin/functions.php");
	
	if (isset($_POST['submit_single_male'])) {
			
		//form field values
			$fname = $_POST['element_1_1'];	//first name
			$lname = $_POST['element_1_2'];	//last name
			$email = $_POST['txtEmail'];	//email
			$bday = $_POST['txtBday'];		//birthday
			$mem_len = $_POST['element_8']; //membership length
			
			//form fields for questionnaire asking if each is offensive, 1 for yes, 2 for no
			$nudity = $_POST['element_4'];		//nudity 
			$sex_act = $_POST['element_5'];		//sexual activity
			$swinging = $_POST['element_6'];	//swinging
			
			//more questions
			$police = $_POST['element_7'];	//is police?
			$agree = $_POST['element_9'];	//agree to rules?	
			
			$errs = "?";
			if (strlen($fname) < 2) {
				$errs .= "fname=1&";
			}
			if (strlen($lname) < 2) {
				$errs .= "lname=1&";
			}
			if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) { 
				$errs .= "email=1&";
			}
			if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $bday)) { 
				$errs .= "bday=1&";
			}
			if (empty($mem_len)) {
				$errs .= "mem_len=1&";
			}
			if (empty($nudity)) {
				$errs .= "nudity=1&";
			}
			if (empty($sex_act)) {
				$errs .= "sex_act=1&";
			}
			if (empty($swinging)) {
				$errs .= "swinging=1&";
			}
			if (empty($police)) {
				$errs .= "police=1&";
			}
			if (empty($agree)) {
				$errs .= "agree=1&";
			}
			
			if (strlen($errs) > 1 || $agree == 2) {
				//preserve for data when invalid
				$values = "f=$fname&l=$lname&e=$email&b=$bday&m=$mem_len&n=$nudity&s=$sex_act&w=$swinging&p=$police&a=$agree";
				header("Location: singles_male_form.php$errs$values");
				exit();
			}
		
		function getMemLength() {
			global $mem_len;
			if ($mem_len == 1) {
				$mem_len = "One Day";
			}
			if ($mem_len == 2) {
				$mem_len = "One Month";
			}
			if ($mem_len == 3) {
				$mem_len = "One Year";
			}
			return $mem_len;
		}
		
		$mem_length = getMemLength();
		
		$series_num = seriesNumFunc($mem_length);
		
		//inserting to members table
		$query1 = "INSERT INTO `deeniesystem`.`members` (`member_num`, `email`, `mem_type`, `mem_series`) 
					VALUES (NULL, '$email', 'single', '$series_num')";
		
		mysql_query($query1) or die('Error, insert query1 failed' . mysql_error());
		
		//get member number from last insert
		$mem = mysql_insert_id();
		
		//inserting to member_info table
		$query2 = "INSERT INTO `deeniesystem`.`member_info` (`id`, `mem_num`, `fname`, `lname`, `gender`, `bday`) 
					VALUES (NULL, '$mem', '$fname', '$lname', 'male', '$bday')";
		
		mysql_query($query2) or die('Error, insert query2 failed' . mysql_error());
		
		//inserting to member_score table
		$query3 = "INSERT INTO `deeniesystem`.`member_score` (`id`, `mem_num`, `nudity`, `sex_act`, `swinging`, `police`, `agree`) 
					VALUES (NULL, '$mem', '$nudity', '$sex_act', '$swinging', '$police', '$agree')";
		
		mysql_query($query3) or die('Error, insert query3 failed' . mysql_error());
			
			$fc = new FeeCalculator;
			$prices = $fc->forWhom("single", $mem_length, "new", "male");
			
			$cost = $prices['mem_fee'];
			$_SESSION['len'] = $mem_length;
		
		//calculate end date based on membership length choice
		if ($mem_length == "One Day") {
			$exp = date('d-m-Y', strtotime('+ 1 day')); 
		}
		elseif ($mem_length == "One Month") {
			$exp = date('d-m-Y', strtotime('+1 month'));
		}
		elseif ($mem_length == "One Year") {
			$exp = date('d-m-Y', strtotime('+ 1 year'));
		}
		$start = date("d-m-Y");
		
		//inserting to enroll_period table
		$query4 = "INSERT INTO `deeniesystem`.`enroll_period` (`id`, `mem_num`, `start_date`, `end_date`) 
					VALUES (NULL, '$mem', '$start', '$exp')";
		
		mysql_query($query4) or die('Error, insert query4 failed' . mysql_error());
		
			
		//inserting to mem_price table
		$query5 = "INSERT INTO `deeniesystem`.`mem_price` (`id`, `mem_num`, `mem_length`, `cost`, `paid_mem_fee`) 
					VALUES (NULL, '$mem', '$mem_length', '$cost', 'No')";
		
		mysql_query($query5) or die('Error, insert query5 failed' . mysql_error());
		
		//redirect to success page if all queries succeeded
		header("Location: success1.php?len=$mem_length"); 
			exit;
	}
	
	if (isset($_POST['submit_single_female'])) {
			
		//form field values
			$fname1 = $_POST['element_1_1'];	//first name
			$lname1 = $_POST['element_1_2'];	//last name
			$email = $_POST['txtEmail'];		//email
			$mem_len = $_POST['element_9'];		//length of membership
			$bday = $_POST['txtBday'];			//birthday
			
			//form fields for questionnaire asking if each is offensive, 1 for yes, 2 for no
			$nudity = $_POST['element_4'];	//nudity 
			$sex_act = $_POST['element_5'];	//sexual activity
			$swinging = $_POST['element_6'];	//swinging
			
			//more questions
			$police = $_POST['element_7'];	//is police?
			$agree = $_POST['element_8'];	//agree to rules?	
			
			$errs = "?";
			if (strlen($fname1) < 2) {
				$errs .= "fname=1&";
			}
			if (strlen($lname1) < 2) {
				$errs .= "lname=1&";
			}
			if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) { 
				$errs .= "email=1&";
			}
			if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $bday)) { 
				$errs .= "bday=1&";
			}
			if (empty($nudity)) {
				$errs .= "nudity=1&";
			}
			if (empty($sex_act)) {
				$errs .= "sex_act=1&";
			}
			if (empty($swinging)) {
				$errs .= "swinging=1&";
			}
			if (empty($police)) {
				$errs .= "police=1&";
			}
			if (empty($agree)) {
				$errs .= "agree=1&";
			}
			
			if (strlen($errs) > 2 || $agree == 2) {
				//preserve for data when invalid
				$values = "f=$fname1&l=$lname1&e=$email&b=$bday&m=$mem_len&n=$nudity&s=$sex_act&w=$swinging&p=$police&a=$agree";
				header("Location: singles_female_form.php$errs$values");
				exit();
			}
			
		//inserting to members table
		$query1 = "INSERT INTO `deeniesystem`.`members` (`member_num`, `email`, `mem_type`) 
					VALUES (NULL, '$email', 'single')";
		
		mysql_query($query1) or die('Error, insert query1 failed' . mysql_error());
		
		//get member number from last insert
		$mem = mysql_insert_id();
		
		//inserting to member_info table
		$query2 = "INSERT INTO `deeniesystem`.`member_info` (`id`, `mem_num`, `fname`, `lname`, `gender`, `bday`) 
					VALUES (NULL, '$mem', '$fname1', '$lname1', 'female', '$bday')";
		
		mysql_query($query2) or die('Error, insert query2 failed' . mysql_error());
		
		//inserting to member_score table
		$query3 = "INSERT INTO `deeniesystem`.`member_score` (`id`, `mem_num`, `nudity`, `sex_act`, `swinging`, `police`, `agree`) 
					VALUES (NULL, '$mem', '$nudity', '$sex_act', '$swinging', '$police', '$agree')";
		
		mysql_query($query3) or die('Error, insert query3 failed' . mysql_error());
		
			//figure out membership length
			
		$mem_length = "One Day";
		$cost = 5;
		$_SESSION['len'] = $mem_length;
		$_SESSION['cost'] = $cost;
		
		//calculate end date based on membership length choice
		$exp = date('d-m-Y', strtotime('+ 1 day')); 
		$start = date("d-m-Y");
		
		//inserting to enroll_period table
		$query4 = "INSERT INTO `deeniesystem`.`enroll_period` (`id`, `mem_num`, `start_date`, `end_date`) 
					VALUES (NULL, '$mem', '$start', '$exp')";
		
		mysql_query($query4) or die('Error, insert query4 failed' . mysql_error());
		
		//insert into mem_price table
		$query5 = "INSERT INTO `deeniesystem`.`mem_price` (`id`, `mem_num`, `mem_length`, `cost`, `paid_mem_fee`) 
					VALUES (NULL, '$mem', '$mem_length', '$cost', 'No')";
		
		mysql_query($query5) or die('Error, insert query5 failed' . mysql_error());
		
		//redirect to success page if all queries succeeded
		header("Location: success3.php"); 
			exit;
	}
	
	if (isset($_POST['submit_couple'])) {
			
		//form field values
			$fname1 = ucfirst(trim($_POST['element_1_1']));	//first name
			$lname1 = ucfirst(trim($_POST['element_1_2']));	//last name
			$fname2 = ucfirst(trim($_POST['element_2_1']));	//partner's first name
			$lname2 = ucfirst(trim($_POST['element_2_2']));	//partner's last name
			$email = trim($_POST['txtEmail']);		//email
			$email2 = trim($_POST['txtPartnersEmail']);		//email
			$bday = trim($_POST['txtBday']);			//birthday
			$bday2 = trim($_POST['txtBday2']);		//partner's birthday
			$anniv = trim($_POST['txtAnniv']); 		//anniversary
			$mem_len = $_POST['element_11']; 	//membership cost and length
					
			//form fields for questionnaire asking if each is offensive, 1 for yes, 2 for no
			$nudity = $_POST['element_4'];	//nudity 
			$sex_act = $_POST['element_5'];	//sexual activity
			$swinging = $_POST['element_6'];	//swinging
			
			//more questions
			$police = $_POST['element_7'];	//is police?
			$agree = $_POST['element_8'];	//agree to rules?	
			
			$errs = "?";
			if (strlen($fname1) < 2) {
				$errs .= "fname1=1&";
			}
			if (strlen($lname1) < 2) {
				$errs .= "lname1=1&";
			}
			if (strlen($fname2) < 2) {
				$errs .= "fname2=1&";
			}
			if (strlen($lname2) < 2) {
				$errs .= "lname2=1&";
			}
			if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) { 
				$errs .= "email=1&";
			}
			if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email2)) { 
				$errs .= "email2=1&";
			}
			if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $bday)) { 
				$errs .= "bday=1&";
			}
			if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $bday2)) { 
				$errs .= "bday2=1&";
			}
			if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $anniv)) { 
				$errs .= "anniv=1&";
			}
			if (empty($mem_len)) {
				$errs .= "mem_len=1&";
			}
			if (empty($nudity)) {
				$errs .= "nudity=1&";
			}
			if (empty($sex_act)) {
				$errs .= "sex_act=1&";
			}
			if (empty($swinging)) {
				$errs .= "swinging=1&";
			}
			if (empty($police)) {
				$errs .= "police=1&";
			}
			if (empty($agree)) {
				$errs .= "agree=1&";
			}
			
			if (strlen($errs) > 1 || $agree == 2) {
				//preserve for data when invalid
				$values = "f1=$fname1&l1=$lname1&f2=$fname2&l2=$lname2&e=$email&e2=$email2&b=$bday&b2=$bday2&anv=$anniv&m=$mem_len&n=$nudity&s=$sex_act&w=$swinging&p=$police&a=$agree";
				header("Location: couples_form.php$errs$values");
				exit();
			}
		
		//figure out membership length and cost
		function getMemLength() {
			global $mem_len;
			if ($mem_len == 1) {
				$mem_len = "One Day";
			}
			if ($mem_len == 2) {
				$mem_len = "Three Months";
			}
			if ($mem_len == 3) {
				$mem_len = "One Year";
			}
			if ($mem_len == 4) {
				$mem_len = "One Year VIP";
			}
			return $mem_len;
		}
		$mem_len = getMemLength();
		
		$series_num = seriesNumFunc($mem_len);
			
		//inserting to members table
		$query1 = "INSERT INTO `deeniesystem`.`members` (`member_num`, `email`, `mem_type`, `mem_series`) 
					VALUES (NULL, '$email', 'couple', '$series_num')";
		
		mysql_query($query1) or die('Error, insert query1 failed' . mysql_error());
		
		//get member number from last insert
		$mem = mysql_insert_id();
		
		//inserting to member_info table
		$query2 = "INSERT INTO `deeniesystem`.`member_info` (`id`, `mem_num`, `fname`, `lname`, `fname2`, `lname2`, `gender`, `bday`, `bday2`, `anniv`) 
					VALUES (NULL, '$mem', '$fname1', '$lname1', '$fname2', '$lname2', 'couple', '$bday', '$bday2', '$anniv')";
		
		mysql_query($query2) or die('Error, insert query2 failed' . mysql_error());
		
		//insert partners info
		$pquery = "INSERT INTO partners_info (id, mem_num, fname, lname, bday)
						VALUES (NULL, '$mem', '$fname2', '$lname2', '$bday2')";
		
		mysql_query($pquery) or die('Error insert partner info failed '.mysql_error());
		
		//inserting to member_score table
		$query3 = "INSERT INTO `deeniesystem`.`member_score` (`id`, `mem_num`, `nudity`, `sex_act`, `swinging`, `police`, `agree`) 
					VALUES (NULL, '$mem', '$nudity', '$sex_act', '$swinging', '$police', '$agree')";
		
		mysql_query($query3) or die('Error, insert query3 failed' . mysql_error());
		
		$fc = new FeeCalculator;
		$prices = $fc->forWhom("couple", $mem_len, "new");
		$cost = $prices['mem_fee'];	
		
		//calculate end date based on membership length choice
		if ($mem_len == "One Day") {
			$exp = date('d-m-Y', strtotime('+ 1 day')); 
		}
		elseif ($mem_len == "Three Months") {
			$exp = date('d-m-Y', strtotime('+3 month'));
		}
		elseif ($mem_len == "One Year" || $mem_len == "One Year VIP") {
			$exp = date('d-m-Y', strtotime('+ 1 year'));
		}
		$start = date("d-m-Y");
		
		//inserting to enroll_period table
		$query4 = "INSERT INTO `deeniesystem`.`enroll_period` (`id`, `mem_num`, `start_date`, `end_date`) 
					VALUES (NULL, '$mem', '$start', '$exp')";
		
		mysql_query($query4) or die('Error, insert query4 failed' . mysql_error());
		
		//insert into mem_price table
		$query5 = "INSERT INTO `deeniesystem`.`mem_price` (`id`, `mem_num`, `mem_length`, `cost`, `paid_mem_fee`) 
					VALUES (NULL, '$mem', '$mem_len', '$cost', 'No')";
		
		mysql_query($query5) or die('Error, insert query5 failed' . mysql_error());
		
		//redirect to success page if all queries succeeded
		header("Location: success2.php?len=$mem_len"); 
			exit;
	}
?>