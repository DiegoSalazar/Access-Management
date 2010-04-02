<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Member Check In</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<style type="text/css">
	#form_container {
		text-align:center;
	}
	#form_container p {
		line-height: 0.5;
	}
</style>
<?php
include("../includes/dbconnect.php"); include("functions.php"); include("classes.php");
	
	//insert into member_enter table after member pays door fee
	if (isset($_POST['submit_member_enter'])) {
		$mem_num = $_POST['mem_num'];
		$query2 = "UPDATE mem_price SET paid_mem_fee = 'Yes' WHERE mem_num = '$mem_num' LIMIT 1";
		mysql_query($query2) or die("Update paid_mem_fee Failed ".mysql_error());
		$success1 = mysql_affected_rows();
		if (!$success1) { die("Failed to Update mem_price after paying"); }
		else {		
		
			$date = date("d-m-Y");
			$time = date("g:ia");
			$door_fee = $_POST['payed_fee'];
			$staff = $_POST['staff'];
			$name = $_POST['mem_name'];
			if (isset($_POST['partner'])) {
				$partner = $_POST['partner'];
			}
			
			$query3 = "SELECT member_info.gender, enroll_period.end_date, mem_price.mem_length, mem_price.paid_mem_fee
					  FROM mem_price, enroll_period, member_info
					 WHERE mem_price.mem_num = '$mem_num' 
					   AND enroll_period.mem_num = '$mem_num'";
			$result = mysql_query($query3) or die("Get mem_price query Failed ".mysql_error());
			$set = mysql_fetch_assoc($result);
			
			//if the membership is expired, it will renew with the original mem_length
			if (isExpired($set['end_date']) && $set['gender'] != "female") {
				if ($set['mem_length'] == "One Day") {
					$end_date = date('d-m-Y', strtotime('+ 1 day'));
					$sql = "UPDATE enroll_period SET end_date = '$end_date' WHERE mem_num = '$mem_num'";
					$do = mysql_query($sql) or die("Update one day membership end date Failed ".mysql_error());
					$success3 = mysql_affected_rows();
					if (!$success3) { die("Failed to Update enroll after paying, mem_length One Day"); }	
				}
				elseif ($set['mem_length'] == "One Month") {
					$end_date = date('d-m-Y', strtotime('+ 1 month'));
					$sql = "UPDATE enroll_period SET end_date = '$end_date' WHERE mem_num = '$mem_num'";
					$do = mysql_query($sql) or die("Update one month membership end date Failed ".mysql_error());
					$success4 = mysql_affected_rows();
					if (!$success4) { die("Failed to Update enroll_period after paying, mem_length One Month"); }	
				}
				elseif ($set['mem_length'] == "Three Months") {
					$end_date = date('d-m-Y', strtotime('+ 3 month'));
					$sql = "UPDATE enroll_period SET end_date = '$end_date' WHERE mem_num = '$mem_num'";
					$do = mysql_query($sql) or die("Update three month membership end date Failed ".mysql_error());
					$success4 = mysql_affected_rows();
					if (!$success4) { die("Failed to Update enroll after paying, mem_length Three Months"); }	
				}
				elseif ($set['mem_length'] == "One Year" || $set['mem_length'] == "One Year VIP") {
					$end_date = date('d-m-Y', strtotime('+ 1 year'));
					$sql = "UPDATE enroll_period SET end_date = '$end_date' WHERE mem_num = '$mem_num'";
					$do = mysql_query($sql) or die("Update one year membership end date Failed ".mysql_error());
					$success5 = mysql_affected_rows();
					if (!$success5) { die("Failed to Update enroll after paying, mem_length One Year"); }	
				}
			}
			
			$query = "INSERT INTO deeniesystem.member_enter (id, mem_num, date_in, time_in, staff, door_fee) 
							VALUES (NULL, '$mem_num', '$date', '$time', '$staff', '$door_fee')";
			mysql_query($query) or die("Insert member_enter failed " . mysql_error());
			
			header("Location: success.php?mem=$name&partner=$partner&fee=$door_fee");
			exit();
		}
	}
	
	//display the calculated fees depending on the pricing criteria for the member type, day, hour, and gender if single
	$mem_num = $_GET['mem_num'];
	$staff = $_GET['staff'];
	
	//get the names based on member number
	$nameNtype = getMemberNamesAndTypeByMemNum($mem_num);
	if(is_array($nameNtype)) { 
		$name = $nameNtype['name'];
		$partner = $nameNtype['partner'];
		$type = $nameNtype['type']; //single or couple
	} else die("Get nameNtype failed");
	
	//get additional info required to calculate fees
	$info = getMemLengthCostGenderPaidAndEndDateByMemNum($mem_num);
	if (!is_array($info)) {
		die("Get info failed");
		exit();
	}
	$mem_length = $info['mem_length'];
	$cost = $info['cost'];
	$gender = $info['gender'];
	$paid = $info['paid']; //status of membership payment, Yes or No
	$end_date = $info['end_date']; //membership expiration 
	
	if ($gender == "female") {
		$prices['door_fee'] = 5;
	}
	else {
		$fc = new FeeCalculator;
		$day = date("l");
		
		//if membership is new, get new membership prices
		if ($paid == "No") {
			if (!isMemMonthYear($mem_length)) {
				$new = true;
			} else $MnYr = true;
			$prices = $fc->forWhom($type, $mem_length, "new", $gender);
			if(empty($prices)) { $error = "error getting NEW prices"; };
		}
		
		//if membership is expired, get new membership prices
		if (isExpired($end_date)) {
			if (!isMemMonthYear($mem_length)) {
				$new = true;
			} else $MnYr = true;
			$prices = $fc->forWhom($type, $mem_length, "new", $gender);
			if(empty($prices)) { $error = "error getting EXPIRED prices"; }
			else {
				updatePaidStatus($mem_num);
			}
		}
		
		//if they are current members
		if ($paid == "Yes" && !isExpired($end_date)) {
			$new = false;
			$prices = $fc->forWhom($type, $mem_length, $mem_num, $gender);
			if(!is_array($prices)) { $error = "error getting NORMAL prices"; }
		} 
		//get the paid status now incase it was updated by updatePaidStatus function above, then pass it to displayCheckinPrice function below
		$info2 = getMemLengthCostGenderPaidAndEndDateByMemNum($mem_num);
		$paid2 = $info2['paid'];
	}
	if ($error) { die("$error"); }
?>
</head>
<body id="main_body">
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>A Private Swingers Club</a></h1>
		<form id="form_57965" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2><?php if(isCouple($type)) { echo "Members: " . $name . " and " . $partner; }
				 else echo "Member: $name."; ?></h2>
            <h3><?php if (isExpired($end_date)) { echo "Enrolling for: " . $mem_length; } 
						else echo "Enrolled for: ". $mem_length; ?></h3>
            <br /> 
            <?php displayCheckInPrice($prices, $type, $end_date, $paid2, $mem_length); ?>
            <br /><br />           
            
            <form method="post" action="checkin.php">
            	<p><strong>Payed: </strong>
                	 <input type="text" size="13" name="payed_fee" />
                	 <input type="hidden" name="mem_num" value="<?php echo $mem_num;?>" />
                     <input type="hidden" name="staff" value="<?php echo $staff;?>" />
                     <input type="hidden" name="mem_name" value="<?php echo $name;?>" />
                     <?php 
					 	if ($partner != "") {
							echo "<input type='hidden' name='partner' value='{$partner}' />";
						}
						if (isset($mem_fee)) {
							echo "<input type='hidden' name='paid_mem_fee' value='Yes' />";
						}
					 ?>
                <input type="submit" name="submit_member_enter" value="Check In" /></p>                
            </form>
            <br />
			
		</div>						
			
		</form>	
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>