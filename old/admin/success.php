<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Member Checked In</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript">
<!--
function delayer(){
    window.location = "admin.php"
}
//-->
</script>
<style type="text/css">
	#form_container {
		text-align:center;
	}
	#form_container p {
		line-height: 0.5;
	}
</style>

</head>
<body id="main_body" onLoad="setTimeout('delayer()', 3000)">
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>A Private Swingers Club</a></h1>
		<form id="form_57965" class="appnitro"  method="post" action="index.php">
					<div class="form_description">
			<h2><?php echo $_GET['mem']; if ($_GET['partner'] != ""){echo " and ".$_GET['partner']." Have ";} else echo " Has ";?>
            	<br />Been Checked In</h2>
            <h3>Payed: $<?php echo $_GET['fee'];?>
            
           
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