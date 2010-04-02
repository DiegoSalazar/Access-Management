<?php include("session.php"); ?>
<?php include("admin_process.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="../js/jquery-1.2.6.js"></script>
<script type="text/javascript" src="../js/buttons.js"></script>
<title>Admin Area</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<link rel="stylesheet" type="text/css" href="table.css" media="all">
<script type="text/javascript" src="view.js"></script>
<style type="text/css">
#logout {
	float:right;
	margin-top:35pt;
	margin-right:10pt;
}
</style>
<script type="text/javascript">
<!--
	function confirmLogout() {
		var answer = confirm("Are You Sure You Want To Logout?")
		if (answer){
			window.location = "admin.php?logout=1";
		}
	}
	function confirmDelete() {
		var agree = confirm("Are You Sure You Want To Delete?");
		if (agree)
			return true ;
		else
			return false ;
	}
	function validateCheckinForm(){
		if (document.checkin_form.staff[document.checkin_form.staff.selectedIndex].value == "::Select::"){
			alert("Please Select a Staff Member");
		return false;}
	}
//-->
</script>
</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
		
        	<div id="logout"><input type="submit" name="logout" onclick="confirmLogout()" value="Logout" /></div>
                             
		<h1><a>Database Administration</a></h1>
		<form id="form_58024" class="appnitro"  method="post" action="admin.php">
					<div class="form_description">
			<h2>Database Administration</h2>
			<p>Welcome, <?php echo ucfirst($_SESSION['username']); ?></p>
		</div>						
			
		</form>
    <div class="options">
        <fieldset>
           <legend>Options</legend>
           	  <form method="get" action="member_card.php">
              	<input type="image" src="buttons/Member-card-button.png" name="process_mem" id="mem_card" value="New Member Card" />
              </form>
              <form method="post" action="admin.php">
                <input type="image" src="buttons/reprint-card-button.png" name="reprint_card" id="reprint_card" value="Reprint Card" />
              </form>
              <form method="post" action="admin.php">
                <input type="image" src="buttons/renew_membership-button.png" name="renew_mem_search" id="renew_mem_search" value="Renew Membership" />
              </form>
              <form method="post" action="admin.php">
                <input type="image" src="buttons/checkin-button.png" name="check_in" id="checkin" value="Member Check In" />
              </form>
        </fieldset>
        <br />
   
   <!--only display these options to admin users-->    
   <?php if ($_SESSION['type'] == 'admin') { 
			echo "<fieldset>
				<legend>Database Options</legend>";
			echo "<form class='link_form' method='link' action='new_user.php'><input type='image' src='buttons/newStaff-button.png' id='newStaff' value='Add New User' /></form>";
			echo "<form class='link_form' method='post' action='admin.php'><input type='image' src='buttons/deleteStaff-button.png' id='deleteStaff' name='delete_user'
					 value='Delete Staff' /></form>";
			echo "<form class='link_form' method='post' action='admin.php'><input type='image' src='buttons/entrance_log-button.png' id='entrance_log' name='entrance_log' value='Entrance Log' /></form>";
			//echo "<form class='link_form' method='post' action='admin.php'><input type='submit' name='mail_lists'
					 //value='Mailing Lists' /></form>";
			echo "<form class='link_form' method='link' action='slideshow/FlashEffects/index.php'><input type='image' src='buttons/edit_slideshow-button.png' id='edit_slideshow' value='Edit Slideshow' />
					</form>
					<br />";
				echo "<form class='link_form' method='post' action='admin.php'><input type='image' src='buttons/deleteMember-button.png' id='delete_mem' name='show_delete_mem' value='Delete Member' /></form>
					</fieldset>";
          }
	?>
    </div>
    
    <form id="form_58026" class="appnitro"  method="post" action="admin.php" >  
    <fieldset>
    <legend>Display</legend>
   	  <div class="db_queries" style="padding-left:-5px">
        <input class="button_text" type="image" src="buttons/all_members-button.png" id="allMembers" name="all_members" value="All Members" />
        <input class="button_text" type="image" src="buttons/all_singles-button.png" id="all_singles" name="all_singles" value="All Singles" />
        <input class="button_text" type="image" src="buttons/all_couples-button.png" id="all_couples" name="all_couples" value="All Couples" />
        <input class="button_text" type="image" src="buttons/mem_detail-button.png" id="get_mem_detail" name="get_mem_detail" value="Search" />
        <input class="button_text" type="image" src="buttons/member_scores-button.png" id="member_scores" name="all_scores" value="Member Scores" />
      </div>
    </fieldset>
    </form>
    <a name="anchor"></a>
    <!--display query results-->
    <?php if (isset($_POST['all_members']) || isset($_GET['all_mems_page'])) {	
			echo "<fieldset class='results_field'>
					<legend>Results</legend>
					<div>";
						 displayAllMembers();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['all_singles']) || isset($_GET['singles_page'])) {	
			echo "<fieldset class='results_field'>
					<legend>Results</legend>
					<div>";
						 displayAllSingles();
			echo	"</div>
				  </fieldset>";
		 } 
	 	  if (isset($_POST['all_couples']) || isset($_GET['couples_page'])) {	
			echo "<fieldset class='results_field'>
					<legend>Results</legend>
					<div>";
						 displayAllCouples();
			echo	"</div>
				  </fieldset>";
		 } 
		 if (isset($_POST['delete_user'])) {	
			echo "<fieldset class='results_field'>
					<legend>Pick A User To Delete</legend>
					<div>";
						 displayPickUser();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_GET['user_id'])) {
		 	echo "<div id='deleted'><center><h3>";
			    		displayDeletedUser();
			echo "</h3></center></div>";
		 }
		 if (isset($_POST['reprint_card'])) {
		 	echo "<div class='options'><center><h3>";
			   		displayMemberFilter();
			echo "</h3></center></div>";
		 }
		 if (isset($_POST['submit_filter'])) {	
			echo "<fieldset class='results_field'>
					<legend>Click A Member To Reprint Their Card</legend>
					<div>";
						 displayChooseMember();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['all_scores']) || isset($_GET['scores_page'])) {	
			echo "<fieldset class='results_field'>
					<legend>Member Scores</legend>
					<div>";
						 displayMemberScores();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['check_in'])) {
		 	echo "<div class='options'><center><h3>";
			   		displayMemberCheckIn();
			echo "</h3></center></div>";
		 }
		  if (isset($_POST['submit_mem_num'])) {	
			echo "<fieldset class='results_field'>
					<legend>Member Check In</legend>
					<div>";
						 displayMemberCheckInList();
			echo	"</div>
				  </fieldset>";
		 } 
		 if (isset($_POST['entrance_log']) || isset($_GET['log_page'])) {	
			echo "<fieldset class='results_field'>
					<legend>Member Entrance Log</legend>
					<div>";
						 displayEntranceLog();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['mail_lists'])) {	
			echo "<fieldset class='results_field'>
					<legend>Pick A Mailing List To Generate</legend>
					<div>";
						 displayMailListOptions();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['submit_get_mail_list'])) {	
			echo "<fieldset class='results_field'>
					<legend>Preview Mailing List Results</legend>
					<div>";
						 displayMailListResults();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_POST['show_delete_mem'])) {	
			echo "<fieldset class='results_field'>
					<legend>Delete A Member</legend>
					<div>";
						 displayMemberDelete();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_GET['delete_mem'])) {
		 	echo "<div class='options'><center><h3>";
			   		displayDeleteSuccess();
			echo "</h3></center></div>";	

		 }
		 if (isset($_POST['renew_mem_search'])) {
		 	echo "<div class='options'><center><h3>";
			   		displayMembershipRenewal();
			echo "</h3></center></div>";
		 }
		 if (isset($_POST['submit_renew_mem'])) {
		 	echo "<fieldset class='results_field'>
					<legend>Renew Membership</legend>
					<div>";
						 displayMemberRenewalList();
			echo	"</div>
				  </fieldset>";
		 }
		 if (isset($_GET['renew_mem'])) {
		 	displayRenewalOptions();
		 }
		 if (isset($_POST['get_mem_detail'])) {
		 	echo "<div class='options'><center><h3>";
			   		displayMemberSearchForm();
			echo "</h3></center></div>";
		 }
		 if (isset($_GET['member_detail'])) {
		 	echo "<fieldset class='results_field'>
					<legend>Member Details</legend>
					<div>";
						 getMemberDetail($_GET['mem_name_or_num']);
			echo	"</div>
				  </fieldset>";
		 }
	 ?>
    
    	<br />
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>