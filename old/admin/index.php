<?php session_start(); ?>
<?php include("admin_process.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User Login</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Admin Area</a></h1>
		<form id="form_58023" class="appnitro"  method="post" action="index.php">
					<div class="form_description">
			<h2>Admin Area</h2>
			<p>User Login</p>
		</div>
        						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Username: </label>
		<div>
			<input id="element_1" name="element_1" class="element text small" type="text" maxlength="20" value=""/> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Password </label>
		<div>
			<input id="element_2" name="element_2" class="element text small" type="password" maxlength="20" value=""/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="58024" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit_login" value="Login" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>