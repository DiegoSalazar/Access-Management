<?php
	include("../includes/dbconnect.php");
	
	//add a new user
	if (isset($_POST['submit_new_user'])) {
		
		//get new user variables
		$username = mysql_real_escape_string(trim($_POST['element_1']));
		$auth = $_POST['auth'];
		$password1 = $_POST['element_2'];
		$password2 = $_POST['element_2_1'];
			
		//check if passwords match
		if ($password1 != $password2) {
			function displaySuccess(){}
			function displayMismatch() {
				echo "<div style='background-color:#FFF; text-align:center;'>
						  <h3>Passwords do not match</h3>
					  </div>";
			}
		}
		if ($password1 == $password2) {
			
			//encrypt password
			$hashed_pw = sha1($password1);
			
			$query = "INSERT INTO `deeniesystem`.`users` (`id`, `type`, `username`, `hashed_pw`) 
						VALUES (NULL, '$auth', '$username', '$hashed_pw')";
			
			mysql_query($query) or die('Error, add new user failed' . mysql_error());
			
			function displayMismatch(){}
			function displaySuccess() {
				global $username;
				$user = ucfirst($username);
				
				echo "<div style='background-color:#FFF; text-align:center;'>
						  <h3>{$user} Successfully Added</h3>
					  </div>";
			}
			
		}
	}
	
	//display users to delete
	if (isset($_POST['delete_user'])) {
		
		$query = "SELECT id, username, type
				    FROM users";
		
		$result = mysql_query($query);
			if (!result) { die("Pick users query failed"); }
		
		function displayPickUser() {
			global $result;
			$num_records = mysql_num_rows($result);
			
			echo "<h3>Current Users: {$num_records}</h3>
				<table class='contacts' cellspacing='0'>
					<tr>
					  <th class='contactDept'>Username</th>
					  <th class='contactDept'>Type</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'><a onclick='return confirmDelete()' href=";
					echo "admin.php?user_id={$row['id']}&username={$row['username']}"; 
					echo ">{$row['username']}</a></td>";
					echo	"<td class='contact'>{$row['type']}</td>
						  </tr>";
				}
				echo"</table>";
		}
	}
	
	//delete user
	if (isset($_GET['user_id'])) {
		$user = $_GET['username'];
		$user_id = $_GET['user_id'];
		
		$query = "DELETE FROM users
						WHERE id = '$user_id' ";
						
		$done = mysql_query($query);
			if (!$done) { die("Delete Failed"); }
			
		function displayDeletedUser() {
			global $user;
			echo ucfirst($user);
			echo " Has been deleted.";
		}
	}
	
	//admin page user login
	if (isset($_POST['submit_login'])) {
		
		//get user login variables
		$username = mysql_real_escape_string(trim($_POST['element_1']));
		$password = $_POST['element_2'];
		$hashed_pw = sha1($password);
		
		$query = "SELECT id, type, username FROM users WHERE username = '$username' AND hashed_pw = '$hashed_pw' LIMIT 1";
		$result = mysql_query($query);
			if (!result) { die("User not found."); }
			
		if (mysql_num_rows($result) == 1) {
			$found_user = mysql_fetch_array($result);
			$_SESSION['user_id'] = $found_user['id'];
			$_SESSION['username'] = $found_user['username'];
			$_SESSION['type'] = $found_user['type'];
	
			header("Location: admin.php"); 
			exit;	
		}
	}
	
	//user logout
	if (isset($_GET['logout'])) {
		$logout = $_GET['logout'];
		
		if ($logout == 1) {
			session_destroy();
			header("Location: index.php"); 
			exit;
		}
	}
	
//admin page database queries
	
	//view entrance log
	if (isset($_POST['entrance_log']) || isset($_GET['log_page'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['log_page'])) {
			$pageNum = $_GET['log_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
				
		$query = "SELECT members.mem_series, member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, member_enter.date_in,
						 member_enter.time_in, member_enter.staff,
						 member_enter.door_fee
					FROM members, member_info, member_enter
				   WHERE members.member_num = member_info.mem_num
				     AND member_info.mem_num = member_enter.mem_num
				ORDER BY member_enter.date_in DESC,
						 member_enter.time_in DESC 
				   LIMIT $offset, $rowsPerPage";
		$result = mysql_query($query);
			if (!result) { die("All members query failed"); }
			
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(mem_num) AS numrows FROM member_enter";
		$howMany = mysql_query($getRowTotal) or die('Error, get row total query failed '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		// print the link to access each page
		$self = $_SERVER['PHP_SELF'];
		$nav  = '';
		
		for($page = 1; $page <= $maxPage; $page++) {
			if ($page == $pageNum) {
			  $nav .= " $page "; // no need to create a link to current page
			}
			else {
				$nav .= " <a href=\"$self?log_page=$page#anchor\">$page</a> ";
			}
		}
		
		function displayEntranceLog() {
			global $result, $nav, $numrows;
			
			echo "<h3>Records Found: {$numrows}</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template'>
					<tr>
					  <th class='contactDept'>Member #</th>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Partner</th>
					  <th class='contactDept'>Date In</th>
					  <th class='contactDept'>Time In</th>
					  <th class='contactDept'>Payed</th>	
					  <th class='contactDept'>Staff</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'>{$row['mem_series']}</td>
							<td class='contact'>{$row['fname']} {$row['lname']}</td>
							<td class='contact'>";
							if($row['fname2'] != 'none') {
								echo "{$row['fname2']} {$row['lname2']}";
							}
					  echo "</td>
							<td class='contact'>{$row['date_in']}</td>
							<td class='contact'>{$row['time_in']}</td>
							<td class='contact'>{$row['door_fee']}</td>
							<td class='contact'>{$row['staff']}</td>
						  </tr>";
				}
				echo"<tr><td colspan='6' align='center'>Pages: $nav</td></tr>";
				echo"</table>";
		}
	}
	
	//show mailing list options	
	if (isset($_POST['mail_lists'])) {
		function displayMailListOptions() {
			echo "<form method='post' action='admin.php'>";
			echo "<span style='width:20%; float:left; border-right:dotted; margin-right:20pt;'>";
			echo "<h3>Birthdays</h3>";
			echo "<p>Today: <input type='radio' name='mail_list' value='bday_today' style='margin-left:31px'/><br />";
			echo " This Week: <input type='radio' name='mail_list' value='bday_next_week' /></p>";
			echo "</span>";
			echo "<span style='width:23%; float:left; border-right:dotted; margin-right:20pt;'>";
			echo "<h3>Anniversaries</h3>";
			echo "<p>Today: <input type='radio' name='mail_list' value='anniv_today' style='margin-left:31px'/><br />";
			echo " This Week: <input type='radio' name='mail_list' value='anniv_next_week'/></p>";
			echo "</span>";
			echo "<span style='width:30%; float:left; margin-bottom:20pt'>";
			echo "<h3>Membership Expires</h3>";
			echo "<p>Today: <input type='radio' name='mail_list' value='exp_today' style='margin-left:31px'/><br />";
			echo " This Week: <input type='radio' name='mail_list' value='exp_next_week'/></p>";
			echo "</span>";
			echo "<div style='width:100%; text-align:center; float:left; clear:both;'>";
			echo "<input type='submit' name='submit_get_mail_list' value='Get Mailing List' />";
			echo "<div>";
			echo "</form>";
		}
	}
	
	//display members to delete
	if (isset($_POST['show_delete_mem'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['log_page'])) {
			$pageNum = $_GET['log_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$query = "SELECT members.mem_series, member_info.fname, member_info.lname, member_info.fname2, member_info.lname2 
					FROM members, member_info
				   WHERE members.member_num = member_info.mem_num
				ORDER BY members.member_num 
			  DESC LIMIT $offset, $rowsPerPage";
		$result = mysql_query($query);
			if (!result) { die("Members delete query failed ".mysql_error()); }
		
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(mem_num) AS numrows FROM member_info";
		$howMany = mysql_query($getRowTotal) or die('Count members to delete '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		function displayMemberDelete() {
			global $result;
			$num_records = mysql_num_rows($result);
			
			echo "<h3>Current Users: {$num_records}</h3>
				<table class='contacts' cellspacing='0'>
					<tr>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Partner</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'><a onclick='return confirmDelete()' href=";
					echo "admin.php?delete_mem={$row['mem_num']}&username={$row['fname']}"; 
					echo ">{$row['fname']}</a>&nbsp;{$row[lname]}</td>";
					echo	"<td class='contact'>{$row['fname2']}&nbsp;{$row[lname2]}</td>
						  </tr>";
				}
				echo"</table>";
		}
	}
	
	//delete member account
	if (isset($_GET['delete_mem'])) {
		$mem_num = $_GET['delete_mem'];
		
		$get_name = mysql_query("SELECT fname FROM member_info WHERE mem_num = '$mem_num'");
		$result_name = mysql_fetch_assoc($get_name) or die("Get name of member to delete query failed ".mysql_error());
		$fname = $result_name['fname'];
		
		//begin deleting member data from each table
		$query_0 = "DELETE FROM members WHERE member_num = '$mem_num'";
		$query_1 = "DELETE FROM member_info WHERE mem_num = '$mem_num'";
		$query_2 = "DELETE FROM member_enter WHERE mem_num = '$mem_num'";
		$query_3 = "DELETE FROM member_score WHERE mem_num = '$mem_num'";
		$query_4 = "DELETE FROM mem_price WHERE mem_num = '$mem_num'";
		$query_5 = "DELETE FROM enroll_period WHERE mem_num = '$mem_num'";
		$query_6 = "DELETE FROM partners_info WHERE mem_num = '$mem_num'";
		
		$do_0 = mysql_query($query_0) or die("Delete from members table failed ".mysql_error());
		$do_1 = mysql_query($query_1) or die("Delete from member_info table failed ".mysql_error());
		$do_2 = mysql_query($query_2) or die("Delete from member_enter table failed ".mysql_error());
		$do_3 = mysql_query($query_3) or die("Delete from member_score table failed ".mysql_error());
		$do_4 = mysql_query($query_4) or die("Delete from mem_price table failed ".mysql_error());
		$do_5 = mysql_query($query_5) or die("Delete from enroll_period table failed ".mysql_error());
		$do_6 = mysql_query($query_6) or die("Delete from partners_info table failed ".mysql_error());
		
		function displayDeleteSuccess() {
			global $fname, $deleted;
			echo ucfirst($fname);
			echo " Has Been Deleted. ";
		}
	}
	
	//show mailing list results and button to generate text list
	if (isset($_POST['submit_get_mail_list'])) {
		$today = date("m/d");
		$thisWeek1 = date('m/d', strtotime('+ 1 day'));
		$thisWeek7 = date('m/d', strtotime('+ 7 day')); 
		
		if ($_POST['mail_list'] == "bday_today") {
			$title = "Today's Birthdays";
			$sql = "SELECT member_info.bday, 
						   partners_info.bday, 
						   member_info.fname, 
						   member_info.lname, 
						   member_info.fname2,
						   member_info.lname2,
						   members.email
					  FROM member_info, partners_info, members
					 WHERE member_info.mem_num = members.member_num
					   AND member_info.mem_num = partners_info.mem_num
 					   AND member_info.bday LIKE '$today%'
					    OR partners_info.bday LIKE '$today%'";
			$result = mysql_query($sql) or die("Failed to get bdays ".mysql_error());
			$numrows = mysql_num_rows($result);
		}
		elseif ($_POST['mail_list'] == "bday_next_week") {
			$title = "This Week's Birthdays";
			$sql1 = "SELECT member_info.bday,
						    member_info.fname, 
						    member_info.lname,
						    members.email
					   FROM member_info, members
					  WHERE member_info.mem_num = members.member_num
					    AND member_info.bday BETWEEN '$thisWeek1%' AND '$thisWeek7%'";
			$sql2 = "SELECT partners_info.bday,
							partners_info.fname,
							partners_info.lname
					   FROM partners_info
					  WHERE partners_info.bday BETWEEN '$thisWeek1%' AND '$thisWeek7%'";
			
			if (mysql_query($sql1)) {
				$result = mysql_query($sql1) or die("Failed to get bdays 1 ".mysql_error());
				$numrows = mysql_num_rows($result);
			}
			if (mysql_query($sql2)) {
				$result2 = mysql_query($sql2) or die("Failed to get bdays 2 ".mysql_error());
				$numrows2 = mysql_num_rows($result2);
			}
			$numrows = $numrows + $numrows2;
		}
		elseif ($_POST['mail_list'] == "anniv_today") {
			$title = "Today's Anniversaries";
		}
		elseif ($_POST['mail_list'] == "anniv_next_week") {
			$title = "This Week's Anniversaries";
		}
		elseif ($_POST['mail_list'] == "exp_today") {
			$title = "Today's Membership Expirations";
		}
		elseif ($_POST['mail_list'] == "exp_next_week") {
			$title = "This Week's Membership Expirations";
		}
		
		function displayMailListResults() {
			global $result, $result2, $numrows, $title;
			if ($numrows > 1) {
				$heading = "Records";
			} else $heading = "Record";
			
			echo "<h3>$numrows $heading Found For $title</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template' style='width:80%'>
					<tr>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Email</th>
					  <th class='contactDept'>Birthday</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'>{$row['fname']} {$row['lname']} </td>
							<td class='contact'>{$row['email']} </td>
							<td class='contact'>{$row['bday']} </td>
						  </tr>";
				}
				while ($row2 = mysql_fetch_assoc($result2)) {
					echo "<tr>
							<td class='contact'>{$row2['fname']} {$row2['lname']} </td>
							<td class='contact'>{$row2['email']} </td>
							<td class='contact'>{$row2['bday']} </td>
						  </tr>";
				}
				echo"</table>";
		}
	}
	
	//select all members
	if (isset($_POST['all_members']) || isset($_GET['all_mems_page'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['all_mems_page'])) {
			$pageNum = $_GET['all_mems_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$query = "SELECT members.mem_series, members.member_num, members.email,
					     members.mem_type, member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.member_num = member_info.mem_num
				     AND member_info.mem_num = enroll_period.mem_num
				ORDER BY enroll_period.start_date DESC
				   LIMIT $offset, $rowsPerPage";
		
		$result = mysql_query($query);
			if (!result) { die("All members query failed"); }
		
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(member_num) AS numrows FROM members";
		$howMany = mysql_query($getRowTotal) or die('Error, get row total query failed '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		// print the link to access each page
		$self = $_SERVER['PHP_SELF'];
		$nav  = '';
		
		for($page = 1; $page <= $maxPage; $page++) {
			if ($page == $pageNum) {
			  $nav .= " $page "; // no need to create a link to current page
			}
			else {
				$nav .= " <a href=\"$self?all_mems_page=$page#anchor\">$page</a> ";
			}
		}
		
		function displayAllMembers() {
			global $result, $nav, $numrows;
			
			echo "<h3>Records Found: {$numrows}</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template'>
					<tr>
					  <th class='contactDept'>Member #</th>
					  <th class='contactDept'>Type</th>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Partner</th>
					  <th class='contactDept'>Email</th>
					  <th class='contactDept'>Start Date</th>
					  <th class='contactDept'>End Date</th>						  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'>{$row['mem_series']}</td>
							<td class='contact'>{$row['mem_type']}</td>
							<td class='contact'>
								<a href='admin.php?mem_name_or_num={$row[member_num]}&member_detail=Search'>{$row['fname']} {$row['lname']}</a></td>
							<td class='contact'>{$row['fname2']} {$row['lname2']}</td>
							<td class='contact'>{$row['email']}</td>
							<td class='contact'>{$row['start_date']}</td>
							<td class='contact'>{$row['end_date']}</td>
						  </tr>";
				}
				echo"<tr onmouseover=\"this.style.backgroundColor='#dadada'; this.style.cursor='hand'; this.style.color='#545454';\" 
                onmouseout=\"this.style.backgroundColor='#FFFFFF'; this.style.color='#CCCCCC';\"><td colspan='7' align='center'>Pages: $nav</td></tr>";
				echo"</table>";
		}
	}
	
	//select all singles
	if (isset($_POST['all_singles']) || isset($_GET['singles_page'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['singles_page'])) {
			$pageNum = $_GET['singles_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$query = "SELECT members.mem_series, members.member_num, members.email,
					     members.mem_type, member_info.fname,
					     member_info.lname, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.mem_type = 'single'
					 AND (members.member_num = member_info.mem_num
				     AND member_info.mem_num = enroll_period.mem_num)
			    ORDER BY enroll_period.start_date DESC
				   LIMIT $offset, $rowsPerPage";
		
		$result = mysql_query($query);
			if (!result) { die("All members query failed"); }
		
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(member_num) AS numrows FROM members WHERE mem_type = 'single'";
		$howMany = mysql_query($getRowTotal) or die('Error, get row total query failed '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		// print the link to access each page
		$self = $_SERVER['PHP_SELF'];
		$nav  = '';
		
		for($page = 1; $page <= $maxPage; $page++) {
			if ($page == $pageNum) {
			  $nav .= " $page "; // no need to create a link to current page
			}
			else {
				$nav .= " <a href=\"$self?singles_page=$page#anchor\">$page</a> ";
			}
		}
		
		function displayAllSingles() {
			global $result, $nav, $numrows;
			$num_records = mysql_num_rows($result);
			
			echo "<h3>Records Found: {$numrows}</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template'>
					<tr>
					  <th class='contactDept'>Member #</th>
					  <th class='contactDept'>Membership Type</th>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Email</th>
					  <th class='contactDept'>Start Date</th>
					  <th class='contactDept'>End Date</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'><a href='admin.php?mem_name_or_num={$row[member_num]}&member_detail=Search'>{$row['mem_series']}</a></td>
							<td class='contact'>{$row['mem_type']}</td>
							<td class='contact'>
								<a href='admin.php?mem_name_or_num={$row[member_num]}&member_detail=Search'>{$row['fname']} {$row['lname']}</a></td>
							<td class='contact'>{$row['email']}</td>
							<td class='contact'>{$row['start_date']}</td>
							<td class='contact'>{$row['end_date']}</td>
						  </tr>";
				}
				echo"<tr><td colspan='6' align='center'>Pages: $nav</td></tr>";
				echo"</table>";
		}
	}
	
	//select all couples
	if (isset($_POST['all_couples']) || isset($_GET['couples_page'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['couples_page'])) {
			$pageNum = $_GET['couples_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$query = "SELECT members.mem_series, members.member_num, members.email,
					     members.mem_type, member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.mem_type = 'couple'
					 AND (members.member_num = member_info.mem_num
				     	  AND member_info.mem_num = enroll_period.mem_num)
				ORDER BY enroll_period.start_date DESC
				   LIMIT $offset, $rowsPerPage";
		
		$result = mysql_query($query);
			if (!result) { die("All members query failed"); }
		
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(member_num) AS numrows FROM members WHERE mem_type = 'couple'";
		$howMany = mysql_query($getRowTotal) or die('Error, get row total query failed '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		// print the link to access each page
		$self = $_SERVER['PHP_SELF'];
		$nav  = '';
		
		for($page = 1; $page <= $maxPage; $page++) {
			if ($page == $pageNum) {
			  $nav .= " $page "; // no need to create a link to current page
			}
			else {
				$nav .= " <a href=\"$self?couples_page=$page#anchor\">$page</a> ";
			}
		}
		
		function displayAllCouples() {
			global $result, $nav, $numrows;
			$num_records = mysql_num_rows($result);
			
			echo "<h3>Records Found: {$numrows}</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template'>
					<tr>
					  <th class='contactDept'>Member #</th>
					  <th class='contactDept'>Membership Type</th>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Partner's Name</th>
					  <th class='contactDept'>Email</th>
					  <th class='contactDept'>Start Date</th>
					  <th class='contactDept'>End Date</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>
							<td class='contact'>{$row['mem_series']}</td>
							<td class='contact'>{$row['mem_type']}</td>
							<td class='contact'>
								<a href='admin.php?mem_name_or_num={$row[member_num]}&member_detail=Search'>{$row['fname']} {$row['lname']}</a></td>
							<td class='contact'>{$row['fname2']} {$row['lname2']}</td>
							<td class='contact'>{$row['email']}</td>
							<td class='contact'>{$row['start_date']}</td>
							<td class='contact'>{$row['end_date']}</td>
						  </tr>";
				}
				echo"<tr><td colspan='7' align='center'>Pages: $nav</td></tr>";
				echo"</table>";
		}
	}
	
	//calculate member scores, return 
	
	//display all members scores from application questionniare
	if (isset($_POST['all_scores']) || isset($_GET['scores_page'])) {
		
		$rowsPerPage = 20;
		//default first page
		$pageNum = 1;

		if(isset($_GET['scores_page'])) {
			$pageNum = $_GET['scores_page'];
		}
		//counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$query = "SELECT members.mem_series, members.member_num, members.email, members.mem_type, member_score.nudity,
						 member_score.sex_act, member_score.swinging, member_score.police, member_score.agree,
					  	 member_info.fname, member_info.lname, member_info.fname2, member_info.lname2,
						 enroll_period.start_date
					FROM members, member_score, member_info, enroll_period
				   WHERE members.member_num = member_info.mem_num
				     AND (members.member_num = member_score.mem_num
					 	 AND members.member_num = enroll_period.mem_num)
				ORDER BY enroll_period.start_date
				    DESC
				   LIMIT $offset, $rowsPerPage";
						  
		$result = mysql_query($query);
		
		// how many rows we have in database
		$getRowTotal   = "SELECT COUNT(member_num) AS numrows FROM members";
		$howMany = mysql_query($getRowTotal) or die('Error, get row total query failed '.mysql_error());
		$row     = mysql_fetch_assoc($howMany);
		$numrows = $row['numrows'];
		 
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		
		// print the link to access each page
		$self = $_SERVER['PHP_SELF'];
		$nav  = '';
		
		for($page = 1; $page <= $maxPage; $page++) {
			if ($page == $pageNum) {
			  $nav .= " $page "; // no need to create a link to current page
			}
			else {
				$nav .= " <a href=\"$self?scores_page=$page#anchor\">$page</a> ";
			}
		}
		
		function displayMemberScores() {
			global $result, $nav, $numrows;
			
			echo "<h3>Records Found: {$numrows}</h3>
				<table class='contacts' cellspacing='0' summary='Contacts template'>
					<tr>
					  <th class='contactDept'>Member #</th>
					  <th class='contactDept'>Name</th>
					  <th class='contactDept'>Partner's Name</th>
					  <th class='contactDept'>Email</th>
					  <th class='contactDept'>Membership Type</th>
					  <th class='contactDept'>Score</th>
					  <th class='contactDept'>Start Date</th>					  
					</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					if ($row['nudity'] + $row['sex_act'] + $row['swinging'] + $row['police'] + $row['agree'] == 5) {
						$score = "Passed";
					} 
					elseif ($row['nudity'] + $row['sex_act'] + $row['swinging'] + $row['police'] + $row['agree'] != 5) { 
						$score = "Failed";
					}
						if ($row['police'] == 2) {
							$score = "Police";
						}
					$failed = "<td class='contact' style='background-color:#FF9900;'>{$score}</td>";
					$passed = "<td class='contact'>{$score}</td>";
					echo "<tr>
							<td class='contact'>{$row['mem_series']}</td>
							<td class='contact'>
								<a href='admin.php?mem_name_or_num={$row[member_num]}&member_detail=Search'>{$row['fname']} {$row['lname']}</a></td>
							<td class='contact'>{$row['fname2']} {$row['lname2']}</td>
							<td class='contact'>{$row['email']}</td>
							<td class='contact'>{$row['mem_type']}</td>";
							if ($score != 'Passed') {
								echo $failed;
							} else { echo $passed; }						
					echo	"<td class='contact'>{$row['start_date']}</td>
						 </tr>";
				}
				echo"<tr><td colspan='7' align='center'>Pages: $nav</td></tr>";
				echo"</table>";		
		}
		
	}
	
	//show filter options for looking for a member to reprint their card
	if (isset($_POST['reprint_card'])) {
		function displayMemberFilter() {
			echo "<fieldset>";
			echo "<legend>Search For Member</legend>";
			echo "<form method='post' action='admin.php'>";
			echo "<span class='label'>Name: </span><input type='text' maxlength='20' name='filterName' value='' />";
			echo "<div class='submit'><input type='submit' name='submit_filter' value='Search' /></div>";
			echo "</form>";
			echo "</fieldset>";
		}
	}
	
	//show filtered table of users to choose and reprint member card
	if (isset($_POST['submit_filter'])) {
		
		//query value
		$mem_name = $_POST['filterName'];
		
		$query = "SELECT members.mem_series, members.member_num, members.mem_type, 
						 member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.member_num = member_info.mem_num
				     AND (members.member_num = enroll_period.mem_num
					 	  AND (member_info.fname LIKE '$mem_name'
					  	  OR member_info.lname LIKE '$mem_name'))
				ORDER BY members.member_num DESC";
		
		$result = mysql_query($query);
			if (!result) { die("All members query failed"); }
		
		function displayChooseMember() {
			global $result;
			$num_records = mysql_num_rows($result);
			
			echo "<h3>Members Found: {$num_records}</h3>
				  	 <table class='contacts' cellspacing='0'>
						<tr>
						  <th class='contactDept'>Member #</th>
						  <th class='contactDept'>Name</th>
						  <th class='contactDept'>Partner's Name</th>
						  <th class='contactDept'>Membership Type</th>
						  <th class='contactDept'>Start Date</th>
						  <th class='contactDept'>End Date</th>					  
						</tr>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td class='contact'>{$row['mem_series']}</td>";
					echo "<td class='contact'>";
					echo "<a href='member_card.php?";
					echo "mem_num={$row['member_num']}";
					echo "&fname={$row['fname']}";
					echo "&lname={$row['lname']}";
					echo "&fname2={$row['fname2']}";
					echo "&lname2={$row['lname2']}";
					echo "&end_date={$row['end_date']}'>";
					echo "{$row['fname']} {$row['lname']}";
					echo "</a></td>";
					echo "<td class='contact'>{$row['fname2']} {$row['lname2']}</td>";
					echo "<td class='contact'>{$row['mem_type']}</td>";
					echo "<td class='contact'>{$row['start_date']}</td>";
					echo "<td class='contact'>{$row['end_date']}</td>";
					echo "</tr>";
				}
				echo"</table>";
		}
	}
	
	//field to enter member number for member check in
	if (isset($_POST['check_in'])) {
		
		//get staff usernames to populate staff drop down, this will be used to log who checked the member in
		$query = "SELECT username FROM users"; 
		$result = mysql_query($query);
		
		function displayMemberCheckIn() {
			global $result;
			
			echo "<fieldset>";
			echo "<legend>Enter Member Number</legend>";
			echo "<form method='post' action='admin.php' name='checkin_form' onsubmit='return validateCheckinForm()'>";
			echo "<span class='label'>Member#: </span><input type='text' maxlength='20' name='filterMemNum' value='' />";
			echo "<div class='submit'>Staff: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
			echo "<select name='staff'>";
			echo "<option selected='selected'>::Select::</option>";
				while ($row = mysql_fetch_assoc($result)) {
					echo "<option value='{$row['username']}'>{$row['username']}</option>";
				}
			echo "</select></div>";
			echo "<div class='submit'><input type='submit' name='submit_mem_num' value='Search' /></div>";
			echo "</form>";
			echo "</fieldset>";
		}
	}
	
	//show filtered table of members to check in
	if (isset($_POST['submit_mem_num'])) {
		
		//member number query value from previous displayMemberCheckIn function
		$mem_num = $_POST['filterMemNum'];
		
		$query = "SELECT members.mem_series, members.member_num, members.mem_type, 
						 member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.member_num = member_info.mem_num
				     AND (members.member_num = enroll_period.mem_num
					 	  AND (member_info.mem_num = '$mem_num'))
				ORDER BY members.member_num DESC LIMIT 1";
		
		$result = mysql_query($query);
			if (!result) { die("Member Check in query failed " . mysql_error()); }
		
		function displayMemberCheckInList() {
			global $result;
			
			//staff user selected from previous displayMemberCheckIn function
			$staff = $_POST['staff'];
			
			echo "<table class='contacts' cellspacing='0'>
						<tr>
						  <th class='contactDept'>Member No.</th>
						  <th class='contactDept'>Name</th>
						  <th class='contactDept'>Partner's Name</th>
						  <th class='contactDept'>Membership Type</th>
						  <th class='contactDept'>Start Date</th>
						  <th class='contactDept'>End Date</th>					  
						</tr>";
				$row = mysql_fetch_assoc($result);
					echo "<tr>";
					echo "<td class='contact'>{$row['mem_series']}</td>";
					echo "<td class='contact'>";
					echo "<a href='checkin.php?";
					echo "mem_num={$row['member_num']}&staff={$staff}'>";
					echo "{$row['fname']} {$row['lname']}";
					echo "</a></td>";
					if ($row['fname2'] != "none") {
						echo "<td class='contact'>{$row['fname2']} {$row['lname2']}</td>";
					}
					else echo "<td class='contact'>&nbsp;</td>";
					echo "<td class='contact'>{$row['mem_type']}</td>";
					echo "<td class='contact'>{$row['start_date']}</td>";
					echo "<td class='contact'>{$row['end_date']}</td>";
					echo "</tr>";
				echo"</table>";
		}
	}
	
	//field to enter member number for membership renewal
	if (isset($_POST['renew_mem_search'])) {
		
		function displayMembershipRenewal() {
			global $result;
			
			echo "<fieldset>";
			echo "<legend>Enter Member Number</legend>";
			echo "<form method='post' action='admin.php' name='renewal_form'>";
			echo "<span class='label'>Member#: </span><input type='text' maxlength='15' name='filterRenewMemNum' value='' />";
			echo "<div class='submit'><input type='submit' name='submit_renew_mem' value='Search' /></div>";
			echo "</form>";
			echo "</fieldset>";
		}
	}
	
	if (isset($_POST['submit_renew_mem'])) {
		
		//member number query value from previous displayMemberCheckIn function
		$mem_num = $_POST['filterRenewMemNum'];
		
		$query = "SELECT members.mem_series, members.member_num, members.mem_type, 
						 member_info.fname,
					     member_info.lname, member_info.fname2,
					     member_info.lname2, enroll_period.start_date,
						 enroll_period.end_date
					FROM members, member_info, enroll_period
				   WHERE members.member_num = member_info.mem_num
				     AND (members.member_num = enroll_period.mem_num
					 	  AND (member_info.mem_num = '$mem_num'))
				ORDER BY members.member_num DESC LIMIT 1";
		
		$result = mysql_query($query);
			if (!result) { die("Membership Renwal query failed " . mysql_error()); }
		
		function displayMemberRenewalList() {
			global $result;
			
			echo "<table class='contacts' cellspacing='0'>
						<tr>
						  <th class='contactDept'>Member No.</th>
						  <th class='contactDept'>Name</th>
						  <th class='contactDept'>Partner's Name</th>
						  <th class='contactDept'>Membership Type</th>
						  <th class='contactDept'>Start Date</th>
						  <th class='contactDept'>End Date</th>					  
						</tr>";
				$row = mysql_fetch_assoc($result);
					echo "<tr>";
					echo "<td class='contact'>{$row['mem_series']}</td>";
					echo "<td class='contact'>";
					echo "<a href='admin.php?renew_mem=1&";
					echo "mem_num={$row['member_num']}'>";
					echo "{$row['fname']} {$row['lname']}";
					echo "</a></td>";
					if ($row['fname2'] != "none") {
						echo "<td class='contact'>{$row['fname2']} {$row['lname2']}</td>";
					}
					else echo "<td class='contact'>&nbsp;</td>";
					echo "<td class='contact'>{$row['mem_type']}</td>";
					echo "<td class='contact'>{$row['start_date']}</td>";
					echo "<td class='contact'>{$row['end_date']}</td>";
					echo "</tr>";
				echo"</table>";
		}
	}
	
	if (isset($_GET['renew_mem'])) {
		$mem_num = $_GET['mem_num'];
		$staff = $_GET['staff'];
		
		//check if single or couple
		$sql = "SELECT members.mem_type, member_info.fname, member_info.lname, member_info.gender 
				  FROM members, member_info 
				 WHERE members.member_num = '$mem_num' 
				   AND member_info.mem_num = '$mem_num'";
		$result = mysql_query($sql);
		$get = mysql_fetch_assoc($result);
		$mem_type = $get['mem_type'];
		$mem_name = $get['fname'];
		$mem_name .= " ";
		$mem_name .= $get['lname'];
		$gender = $get['gender'];
		
		function displayRenewalOptions() {	
			global $mem_num, $mem_type, $mem_name, $staff, $gender;
			echo "<fieldset class='results_field'>
					<legend>Renew Membership For $mem_name</legend>
					<div>";
				echo "<form method='post' action='admin_process.php'>
						<table>
							<tr>
								<td>One Day:</td> <td><input type='radio' name='mem_length' value='One Day' /></td></tr>";
					if ($mem_type == "single") {
					    echo "<tr>
								<td>One Month:</td> <td><input type='radio' name='mem_length' value='One Month' /></td></tr>";
					} else {
						 echo "<tr>
						 		  <td>Three Months:</td> <td><input type='radio' name='mem_length' value='Three Months' /></td></tr>
						 	   <tr>
							   	  <td>One Year VIP:</td> <td><input type='radio' name='mem_length' value='One Year' /></td></tr>";
						 }
				echo "<tr>	
						<td>One Year:</td> <td><input type='radio' name='mem_length' value='One Year' /></td></tr>";
				echo "</table><input type='hidden' name='mem_num' value=\"$mem_num\" />";
				echo "<input type='hidden' name='staff' value=\"$staff\" />";
				echo "<input type='hidden' name='mem_type' value=\"$mem_type\" />";
				echo "<input type='hidden' name='gender' value=\"$gender\" />";
				echo "<input type='submit' name='renew_membership_submit' value='Renew' /></form>"; 
			echo	"</div>
				  </fieldset>";
		}
	}
	
	if (isset($_POST['renew_membership_submit'])) {
		$mem_num = $_POST['mem_num'];
		$staff = $_POST['staff'];
		$mem_type = $_POST['mem_type'];
		$mem_length = $_POST['mem_length'];
		
		if (!empty($mem_length)) {
			$mem_length = $mem_length;
		} 
			elseif (empty($mem_length)) { 
				die("No mem_length for renewal query");
			}
				
		if ($mem_length == "One Day") {
			$new_date = date('d-m-Y', strtotime('+ 1 day'));		
		}	
		if ($mem_length == "One Month") {
			$new_date = date('d-m-Y', strtotime('+ 1 month'));		
		}	
		if ($mem_length == "Three Months") {
			$new_date = date('d-m-Y', strtotime('+ 3 month'));		
		}	
		if ($mem_length == "One Year VIP" ) {
			$new_date = date('d-m-Y', strtotime('+ 1 year'));		
		}	
		
		$sql = "UPDATE enroll_period SET end_date = '$new_date' WHERE mem_num = '$mem_num'";
		$do = mysql_query($sql) or die("Update enroll_period query Failed ".mysql_error());
		
		//get new membership price
		include("classes.php");
		$fc = new FeeCalculator;
		$new_price = $fc->forWhom($mem_type, $mem_length, "new", $gender);
		
		$sql2 = "UPDATE mem_price SET mem_length = '$mem_length', paid_mem_fee = 'No', cost = '$new_price[mem_fee]' WHERE mem_num = '$mem_num'";
		$do2 = mysql_query($sql2) or die("Update mem_price table Failed ".mysql_error());
		
		header("Location: checkin.php?mem_num=$mem_num&staff=$staff");
		exit();
	}
	
	//field to enter member number to search and display details
	if (isset($_POST['get_mem_detail'])) {
		
		function displayMemberSearchForm() {
			global $result;
			
			echo "<fieldset>";
			echo "<legend>Enter Member Name or Number</legend>";
			echo "<form method='get' action='admin.php' name='member_search_form'>";
			echo "<span class='label'>Member: </span><input type='text' maxlength='15' name='mem_name_or_num' value='' />";
			echo "<div class='submit'><input type='submit' name='member_detail' value='Search' /></div>";
			echo "</form>";
			echo "</fieldset>";
		}
	}
	
	function getMemberDetail($mem_name_or_num) {
		//find out if they are single or couple
		$mem_type_query = "SELECT members.mem_type
							  FROM members, member_info 
							 WHERE members.member_num = '$mem_name_or_num' 
								OR member_info.fname = '$mem_name_or_num'
								OR member_info.lname = '$mem_name_or_num' 
								OR member_info.fname2 = '$mem_name_or_num'
								OR member_info.lname2 = '$mem_name_or_num'
							   AND members.member_num = member_info.mem_num";
		$mtq_result = mysql_query($mem_type_query) or die("Member Detail, mem_type lookup query Failed ".mysql_error());
		$mtq_set = mysql_fetch_assoc($mtq_result);
		
		//members table query
		$members_query = "SELECT members.member_num, members.email
						    FROM members, member_info 
						   WHERE members.member_num = '$mem_name_or_num'
							  OR member_info.fname = '$mem_name_or_num' 
							  OR member_info.lname = '$mem_name_or_num'
							  OR member_info.fname2 = '$mem_name_or_num'
							  OR member_info.lname2 = '$mem_name_or_num'
						     AND members.member_num = member_info.mem_num";
		$members_result = mysql_query($members_query) or die("Members Query Failed ".mysql_error());
		$members_set = mysql_fetch_assoc($members_result);
		
		//member_info table query
		$member_info_query = "SELECT fname, lname, gender, bday ";
		if ($mtq_set = "couple") {
			$member_info_query .= ", anniv ";
		}
		$member_info_query .= "FROM member_info 
						  WHERE mem_num = '$mem_name_or_num' 
						  	 OR fname = '$mem_name_or_num'
							 OR lname = '$mem_name_or_num'
							 OR fname2 = '$mem_name_or_num'
							 OR lname2 = '$mem_name_or_num'";
		$member_info_result = mysql_query($member_info_query) or die("Member_info Query Failed ".mysql_error());
		$mi_set = mysql_fetch_assoc($member_info_result);
		
		//enroll_period query
		$enroll_period_query = "SELECT enroll_period.start_date, enroll_period.end_date
								  FROM enroll_period, member_info
								 WHERE enroll_period.mem_num = '$mem_name_or_num'
								    OR member_info.fname = '$mem_name_or_num'
									OR member_info.lname = '$mem_name_or_num'
									OR member_info.fname2 = '$mem_name_or_num'
									OR member_info.lname2 = '$mem_name_or_num' 
								   AND member_info.mem_num = enroll_period.mem_num";
		$enroll_period_result = mysql_query($enroll_period_query) or die("Enroll_period Query Failed ".mysql_error());
		$ep_set = mysql_fetch_assoc($enroll_period_result);
		
		//mem_price query
		$mem_price_query = "SELECT mem_price.mem_length, mem_price.cost
							  FROM mem_price, member_info
							 WHERE mem_price.mem_num = '$mem_name_or_num'
								OR member_info.fname = '$mem_name_or_num'
								OR member_info.lname = '$mem_name_or_num'
								OR member_info.fname2 = '$mem_name_or_num'
								OR member_info.lname2 = '$mem_name_or_num' 
							   AND member_info.mem_num = mem_price.mem_num";
		$mem_price_result = mysql_query($mem_price_query) or die("mem_price_query Failed ".mysql_error());
		$mp_set = mysql_fetch_assoc($mem_price_result);
		
		//member_score query
		$member_score_query = "SELECT member_score.nudity, member_score.sex_act, member_score.swinging,
									  member_score.police, member_score.agree
								 FROM member_score, member_info
								WHERE member_score.mem_num = '$mem_name_or_num'
								   OR member_info.fname = '$mem_name_or_num'
								   OR member_info.lname = '$mem_name_or_num'
								   OR member_info.fname2 = '$mem_name_or_num'
								   OR member_info.lname2 = '$mem_name_or_num' 
								  AND member_info.mem_num = member_score.mem_num";
		$member_score_result = mysql_query($member_score_query) or die("member_score_query Failed ".mysql_error());
		$ms_set = mysql_fetch_assoc($member_score_result);
		
		//calculate score
		$score = $ms_set['nudity'] + $ms_set['sex_act'] + $ms_set['swinging'] + $ms_set['police'] + $ms_set['agree'];
		if ($score != 5) {
			$quiz = "Failed";
		} else $quiz = "Passed";
		if ($ms_set['police'] = 2) {
			$is_police = true;
		} else $is_police = false;

		//member_enter query
		$member_enter_query = "SELECT member_enter.date_in, member_enter.time_in, member_enter.staff
							  FROM member_enter, member_info
							 WHERE member_enter.mem_num = '$mem_name_or_num'
								OR member_info.fname = '$mem_name_or_num'
								OR member_info.lname = '$mem_name_or_num'
								OR member_info.fname2 = '$mem_name_or_num'
								OR member_info.lname2 = '$mem_name_or_num' 
							   AND member_info.mem_num = member_enter.mem_num
						  ORDER BY member_enter.id 
						      DESC 
							 LIMIT 1";
		$member_enter_result = mysql_query($member_enter_query) or die("member_enter_query Failed ".mysql_error());
		$me_set = mysql_fetch_assoc($member_enter_result);
		
		//partners_info query if couple
		if ($mtq_set['mem_type'] == "couple") {
			$partners_info_query = "SELECT partners_info.fname, partners_info.lname, partners_info.bday, partners_info.email
									  FROM partners_info, member_info
									 WHERE partners_info.mem_num = '$mem_name_or_num'
										OR member_info.fname = '$mem_name_or_num'
										OR member_info.lname = '$mem_name_or_num'
										OR member_info.fname2 = '$mem_name_or_num'
										OR member_info.lname2 = '$mem_name_or_num' 
									   AND member_info.mem_num = partners_info.mem_num";
			$partners_info_result = mysql_query($partners_info_query) or die("partners_info_query Failed ".mysql_error());
			$pi_set = mysql_fetch_assoc($partners_info_result);
		}
		
		//echo results if any
		if (empty($mi_set['fname']) && empty($ep_set['start_date'])) {
			echo "<h3>No Results</h3>";
		}
		else {
			echo "<table class='contacts' cellspacing='0'>";
			  if ($score == "Failed") {
				 if ($is_police) {
					echo "<tr><td colspan='2' class='contact' style='background-color:#FF9900;'>Police</td></tr>";
				 }	else echo "<tr><td colspan='2' class='contact' style='background-color:#FF9900;'>{$score}</td></tr>";
			  }
			echo "<tr><th class='contactDept'>Name:</th> 
					<td class='contactDept'>{$mi_set[fname]} {$mi_set[lname]}</td> </tr>";
			  if ($mtq_set['mem_type'] == "couple") {
				echo "<tr><th class='contactDept'>Name:</th>
					  <td class='contactDept'>{$pi_set[fname]} {$pi_set[lname]}</td> </tr>";
			  } 
			echo "<tr><th class='contactDept'>Email:</th> 
					<td class='contactDept'><a href='mailto:{$members_set[email]}'>{$members_set[email]}</a></td> </tr>";
			  if ($mtq_set['mem_type'] == "couple") {
				echo "<tr><th class='contactDept'>Partner's Info:</th>
					  <td class='contactDept'>{$pi_set[email]}</td> </tr>";
			  }
			echo "<tr><th class='contactDept'>Membership:</th> 
					<td class='contactDept'>{$mp_set[mem_length]} - {$mtq_set['mem_type']}</td> </tr>"; 
			echo "<tr><th class='contactDept'>Paid:</th> 
					<td class='contactDept'>{$mp_set[cost]}</td> </tr>"; 
			echo "<tr><th class='contactDept'>Join Date:</th> 
					<td class='contactDept'>{$ep_set[start_date]}</td> </tr>"; 
			echo "<tr><th class='contactDept'>Expires:</th> 
					<td class='contactDept'>{$ep_set[end_date]}</td> </tr>";
			echo "<tr><th class='contactDept'>Birthday:</th> 
					<td class='contactDept'>{$mi_set[bday]}</td> </tr>";
			  if ($mtq_set['mem_type'] == "couple") {
				echo "<tr><th class='contactDept'>Partner's Birthday:</th>
					  <td class='contactDept'>{$pi_set[bday]}</td> </tr>";
			  }
			  if ($mtq_set['mem_type'] == "couple") {
				echo "<tr><th class='contactDept'>Anniversary:</th>
					  <td class='contactDept'>{$mi_set[anniv]}</td> </tr>";
			  }
			echo "<tr><th class='contactDept'>Last Visit:</th> 
					<td class='contactDept'>{$me_set[date_in]} - {$me_set[time_in]}</td> </tr>"; 
			echo "<tr><th class='contactDept'>Admitted By:</th> 
					<td class='contactDept'>{$me_set[staff]}</td> </tr>"; 
			echo "</table>";
		}
	}
?>