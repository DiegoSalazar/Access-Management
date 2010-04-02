<?php
if (isset($_POST['submit'])) {
	if ($_POST['element_3'] == 1 ) { 	
		
		//check if they chose membership type
		if ($_POST['element_2'] == "") {
			$err_msg = "<h3>You Must Choose A Membership Type To Continue</h3>";
			header("Location: ../index.php?err_msg=$err_msg");
			exit(); 	
		}
		
		// Redirect browser depending on membership type choice  
		if ($_POST['element_2'] == 2) {
			header("Location: ../singles_female_form.php"); 
			exit;
		}
		
		if ($_POST['element_2'] == 3) {
			header("Location: ../singles_male_form.php"); 
			exit;
		}
		
		if ($_POST['element_2'] == 1) {
			header("Location: ../couples_form.php");
			exit;
		}
	
	} 
	else { 
		$err_msg = "<h3>You Must Agree to the Rules to Continue</h3>";
		header("Location: ../index.php?err_msg=$err_msg");
		exit();
							   
	}
}

?>