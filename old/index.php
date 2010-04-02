<?php session_start(); ?>		
<?php include("includes/form_redirect.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>A Private Swingers Club</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

<style type="text/css">
.short {
	margin-top:10pt;
}
.short p {
	line-height:0.6;
}
</style>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Deenie's Hideaway - A Private Swingers Club</a></h1>
		<form id="form_57965" class="appnitro"  method="post" action="includes/form_redirect.php">
					<div class="form_description">
			<h2>Deenie's Hideaway - A Private Swingers Club</h2>
			<div class="short">
                <p>Application For Membership</p>
                <p>Please Read All The Club Rules</p>
            </div>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Club Rules </label>
		<div>
			<textarea id="element_1" name="element_1" class="element textarea" readonly="readonly" rows="11">
    1.  The purchase or sale of alcoholic beverages at Deenie's Hideaway is strictly prohibited.
    2.  Our conduct will be lawful &amp; no lewd or lascivious acts will be allowed.
    3.  No picture phones or cameras of any kind allowed inside and all bags will be inspected.
    4.  No illegal drugs, no gambling, no prostitution, and no one under 21 allowed.
    5.  Members will help control club operations.
    6.  Members will not exceed 2100 persons.
    7.  Only 210 Members will be allowed in at one time.
    8.  Long Term Couples Charter Membership: $1300 + tax yearly.
    9.  Long term Singles Charter Membership: $3000 + tax yearly.
    10. Membership Committee will approve long term Memberships.
    11. Membership denied unless you score 25 points.
            </textarea> 
		</div>
        
        	<div style='background-color:#FFF; text-align:center;'>
				<?php if (isset($_GET['err_msg'])) { echo $_GET['err_msg']; } ?> 
            </div>
        
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Membership Type </label>
		<div>
		<select class="element select small" id="element_2" name="element_2"> 
			<option value="" selected="selected"></option>
            <option value="1" >Couple</option>
            <option value="2" >Single Female</option>
            <option value="3" >Single Male</option>
		</select>
		</div> 
		</li>
        		<li id="li_3" >
		<label class="description" for="element_3">Do You Agree To The Rules? </label>
		<span>
			<input id="element_3_1" name="element_3" class="element radio" type="radio" value="1" />
            <label class="choice" for="element_3_1">Yes!</label>
            <input id="element_3_2" name="element_3" class="element radio" type="radio" value="2" />
            <label class="choice" for="element_3_2">No</label>

		</span> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="57965" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Next" />
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