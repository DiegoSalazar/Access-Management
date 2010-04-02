<?php include("session.php"); ?>
<?php include("../includes/dbconnect.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="member_card.css" media="all" />
<title>Member Card</title>
</head>
	
<body>
<?php
	
	//generate member card
	if (isset($_GET['process_mem'])) {
		
		//get most recently signed up member
		$query = "SELECT deeniesystem.members.member_num, deeniesystem.members.mem_type,
						 deeniesystem.member_info.fname, deeniesystem.members.email,
						 deeniesystem.member_info.lname, deeniesystem.member_info.fname2,
						 deeniesystem.member_info.lname2, deeniesystem.enroll_period.start_date,
						 deeniesystem.enroll_period.end_date						 
					FROM deeniesystem.members, deeniesystem.member_info, deeniesystem.enroll_period
				   WHERE deeniesystem.members.member_num = deeniesystem.member_info.mem_num
				   	 AND deeniesystem.members.member_num = deeniesystem.enroll_period.mem_num
				ORDER BY deeniesystem.members.member_num DESC LIMIT 1";
			
		$result = mysql_query($query);
			if (!result) { die("Display New Member To Process Failed" . mysql_error()); }
		
		$set = mysql_fetch_assoc($result);
		$mem_num = $set['member_num'];
		
		function displayMemberCard() {
			global $set, $mem_num;
			
			$exp = $set['end_date'];
			$name1 = $set['fname'];
			$name1 .= " ";
			$name1 .= $set['lname'];
			$name2 = $set['fname2'];
			$name2 .= " ";
			$name2 .= $set['lname2'];
			if ($set['fname2'] == "none") {
				$hide = true;
			} 
			
			echo "<div id='card'>";
			echo "<div id='topright'>
							<span class='normal'>Member No.</span><span class='bold'>{$mem_num}</span>
						</div>";
				
			echo	"<div id='title'>
							<h3>Temporary Membership</h3>
							<h4>Deenie's Hideaway</h4>
						</div>";
				
			echo	"<div id='bottom'>
					<span class='normal'>Expires:</span><span class='bold'>{$exp}</span><br />";
			echo	"<span class='normal'>Name:&nbsp;&nbsp;</span><span class='bold'>{$name1}</span>";
			if ($hide != true) {
				echo	"<br /><span class='normal'>Name:&nbsp;&nbsp;</span><span class='bold'>{$name2}</span>";
			}
			echo		"</div>
   						</div> ";

		}
		displayMemberCard();
	}
	
	if (isset($_GET['mem_num'])) {
		
		function displayReprintCard() {
			
			$mem_num = $_GET['mem_num'];
			$name1 = $_GET['fname'];
			$name1 .= " ";
			$name1 .= $_GET['lname'];
			$name2 = $_GET['fname2'];
			$name2 .= " ";
			$name2 .= $_GET['lname2'];
			$exp = $_GET['end_date'];
			if ($name2 == "none none") {
				$hide = true;
			} 
			
			echo "<div id='card'>";
			echo "<div id='topright'>
							<span class='normal'>Member No.</span><span class='bold'>{$mem_num}</span>
						</div>";
				
			echo	"<div id='title'>
							<h3>Temporary Membership</h3>
							<h4>Deenie's Hideaway</h4>
						</div>";
				
			echo	"<div id='bottom'>
					<span class='normal'>Expires:</span><span class='bold'>{$exp}</span><br />";
			echo	"<span class='normal'>Name:&nbsp;&nbsp;</span><span class='bold'>{$name1}</span>";
			if ($hide != true) {
				echo	"<br /><span class='normal'>Name:&nbsp;&nbsp;</span><span class='bold'>{$name2}</span>";
			}
			echo		"</div>
   						</div> ";

		}
		displayReprintCard();
	}
	
?>
</body>
</html>
