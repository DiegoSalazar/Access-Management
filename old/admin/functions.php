<?php
	function getMemberNamesAndTypeByMemNum($mem_num) {
		$sql = "SELECT member_info.fname, member_info.lname, member_info.fname2, member_info.lname2, members.mem_type
		 		  FROM member_info, members
				 WHERE member_info.mem_num = '$mem_num'
				   AND members.member_num = '$mem_num'";
		$result = mysql_query($sql) or die("Get Member Names And Type query Failed ".mysql_error());;
		$set = mysql_fetch_assoc($result);
		
		$name = $set['fname']."&nbsp;".$set['lname'];
		$type = $set['mem_type'];
		if ($type == "couple") {
			$pname = $set['fname2']."&nbsp;".$set['lname2'];
		} else $pname = "";
		
		$names = array("name"    => $name,
					   "partner" => $pname,
					   "type"    => $type);
		return $names;
	}
	
	function getMemLengthCostGenderPaidAndEndDateByMemNum($mem_num) {
		//get membership length and gender to calculate door fees
		$sql = "SELECT mem_price.mem_length, mem_price.paid_mem_fee, mem_price.cost, member_info.gender , enroll_period.end_date
					 FROM mem_price, member_info, enroll_period
					WHERE mem_price.mem_num = '$mem_num' 
					  AND (member_info.mem_num = '$mem_num'
						   AND enroll_period.mem_num = '$mem_num')";
		$result = mysql_query($sql) or die("Get Member Length and Gender Failed ".mysql_error());
		$set = mysql_fetch_assoc($result);
		
		$values = array("mem_length" => $set['mem_length'],
						"paid"     => $set['paid_mem_fee'],
						"cost"       => $set['cost'],
						"gender"       => $set['gender'],
						"end_date"   => $set['end_date']);
		return $values;
	}
	
	function isMemMonthYear($len) {
		if ($len == "One Month" || $len == "Three Months" || $len == "One Year" || $len == "One Year VIP") {
			return true;
		} else return false;
	}
	
	function isExpired($end_date) {
		$today = strtotime(date("d-m-Y"));
		$end_date = strtotime($end_date);
		if ($end_date < $today) {
			return true;
		} else return false;
	}
	
	function seriesNumFunc($mem_length) {
		if ($mem_length != "One Day") {
			$ng = new MemSeriesNumberGenerator;
			$series_num = $ng->newNum;
		} else $series_num = "none";
		return $series_num;
	}
	
	function isCouple($type) {
		if ($type == "couple") { return true; }
		else return false;
	}
	
	function updatePaidStatus($mem_num) {
		$sql = "UPDATE mem_price SET paid_mem_fee = 'No' WHERE mem_num = '$mem_num'";
		$do = mysql_query($sql) or die("Update paid_mem_fee 2 Failed ".mysql_error());
	}
	
	function displayCheckInPrice($prices, $type, $end_date, $paid, $mem_length) {
		global $staff, $mem_num;
		$day = date("l");
		if ($paid == "No" && ($mem_length == "One Year" || $mem_length == "One Year VIP")) {
			echo "<h2>Membership Fee: " . $prices['mem_fee'] . "</h2>";
		}
		else {
			if ($paid == "No" ) {
				if ($type == "single") { 
					if (isExpired($end_date)) {
						echo "<h3>Door Fee: $" . $prices[door_fee] . "</h3>";
						echo "<h3>Membership Fee: $" . $prices[mem_fee] . "</h3>";
						echo "<h2>Total: $" . $prices['mem_fee'] += $prices['door_fee'] . "</h2>";
						echo "<h4>Membership Expires, Renew?&nbsp;
								<a href='admin.php?renew_mem=1&mem_num=$mem_num&staff=$staff'>Yes.</a></h4>";
					}
					if (!isExpired($end_date)) {
						echo "<h3>Door Fee: $" . $prices['door_fee'] . "</h3>";
						echo "<h3>Membership Fee: $" . $prices[mem_fee] . "</h3>";
						echo "<h2>Total: $" . $prices['mem_fee'] += $prices['door_fee'] . "</h2>";
					}
				}
				elseif ($type == "couple") {
					if (isExpired($end_date)) {
						echo "<h3>Door Fee: $" . $prices['door_fee'] . "</h3>";
						echo "<h3>Membership Fee: $" . $prices['mem_fee'] . "</h3>";
						echo "<h2>Total: $" . $prices['mem_fee'] += $prices['door_fee'] . "</h2>";
						echo "<h4>Membership Expires, Renew?&nbsp;
								<a href='admin.php?renew_mem=1&mem_num=$mem_num&staff=$staff'>Yes.</a></h4>";
					}
					elseif (!isExpired($end_date)) {
						echo "<h3>Door Fee: $" . $prices['door_fee'] . "</h3>";
						echo "<h3>Membership Fee: $" . $prices[mem_fee] . "</h3>";
						echo "<h2>Total: $" . $prices['mem_fee'] += $prices['door_fee'] . "</h2>";
					}
				}
			}
			elseif ($paid == "Yes") {
				if ($type == "single") {
					echo "<h2>Door Fee: $" . $prices['door_fee'] . "</h2>";
				}
				elseif ($type == "couple") {
					echo "<h2>Door Fee: $" . $prices['door_fee'] . "</h2>";
				}
			}
		}
	} //END displayCheckInPrice
?>