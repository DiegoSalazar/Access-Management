<?php include("session.php"); 
	if ($_SESSION['type'] != 'admin') {
		header("Location: admin.php"); 
		exit;
	}
?>
<?php include("admin_process.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Database Administration</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript">
	function validate(form) {
		var e = form.elements;
		
			if (e['element_2'].value != e['element_2_1'].value) {
				alert('Passwords do not match.');
				return false;
			}
			return true;
			}
</script>
</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Database Administration</a></h1>
		<form id="form_58304" class="appnitro"  method="post" action="new_user.php" onsubmit="return validate(this);">
					<div class="form_description">
			<h2>Database Administration</h2>
			<p>Add A New User</p>
		</div>	
        <?php if (isset($_POST['submit_new_user'])) { displayMismatch(); displaySuccess(); } ?> 					
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Username </label>
		<div>
			<input id="element_1" name="element_1" class="element text medium" type="text" maxlength="20" value=""/> 
		</div><p class="guidelines" id="guide_1"><small>This name will be used to logon to the system</small></p> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Permission Level </label>
		<div>
		<select class="element select medium" id="element_4" name="auth"> 
			<option value="" selected="selected"></option>
            <option value="admin" >Administrator</option>
            <option value="user" >Regular User</option>
		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Password </label>
		<div>
			<input id="element_2" name="element_2" class="element text medium" type="password" maxlength="30" value=""/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Confirm Password </label>
		<div>
			<input id="element_3" name="element_2_1" class="element text medium" type="password" maxlength="30" value=""/> 
		</div><p class="guidelines" id="guide_3"><small>Type in the same password to confirm</small></p> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="58304" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit_new_user" value="Add User" />
		</li>
			</ul>
		</form>	
         <form id="form_58029" class="appnitro"  method="link" action="admin.php">
        <input id="saveForm" class="button_text" type="submit" name="back" value="Back To Admin Area" />
        </form>
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>