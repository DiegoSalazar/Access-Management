<?php session_start(); ?>
<?php
include("admin/classes.php"); 
$fc = new FeeCalculator;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Single Male's Application</title>
<link rel="stylesheet" type="text/css" href="singleform/view.css" media="all">
<script type="text/javascript" src="singleform/view.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<style type="text/css">
	#li_10 {
		width:213pt;
	}
	
	.price {
		position:absolute;
		left:100pt;
		margin-top:-17pt;
	}
	.note {
		font-size:9px;
		margin-left:20pt;
		font-style:italic;
		margin-top:-2pt;
		color:#212121;
		font-weight:bold;
		margin-bottom:10pt;
	}
	.note_list { margin-top:-11px; }
	.err_note {
		color:#FF0000;
		font-size:10px;
		font-style:italic;
		float:left;
		display:inline;
	}
</style>

</head>
<body id="main_body" >
	
	<img id="top" src="singleform/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Single Male's Application</h1>
		<form name="myForm" id="myForm" class="appnitro"  method="post" action="process.php" onsubmit="return ValidateForm()" >
					<div class="form_description">
			<h2>Single Male's Application</h2>
			<p>With Brief Questionnaire</p>
		</div>						
			<ul >
			  <li id="li_1" >
		<label class="description" for="element_1">Name </label>
		<span>
			<input id="firstname" name= "element_1_1" class="element text" maxlength="20" size="8" 
            						value="<?php if(isset($_GET['f'])){
											echo $_GET['f'];} ?>"/>
			<label>First <span class="error_note">*
							<?php
                            if(isset($_GET['fname'])) {
                                echo "Fill In Your First Name.";}
                            ?>
                            </span></label>
		</span>
		<span>
			<input id="lastname" name= "element_1_2" class="element text" maxlength="20" size="14" 
            					value="<?php if(isset($_GET['l'])){
											echo $_GET['l'];} ?>"/>
			<label>Last <span class="error_note">*
						<?php
                        if(isset($_GET['lname'])) {
                            echo "Fill In Your Last Name.";}
                        ?>
                        </span></label>
		</span>		</li>		
	
			  <li id="li_2" >
		<label class="description" for="element_2">Email <span class="error_note">*
															<?php
                                                            if(isset($_GET['email'])) {
                                                                echo "Invalid Email Address.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="email" name="txtEmail" class="email element text medium" type="text" maxlength="30" 
            							value="<?php if(isset($_GET['e'])){
											echo $_GET['e'];} ?>"/> 
            
		</div> 
		</li>	
         	<li id="li_2" >
		<label class="description" for="element_3">Birthday <span class="error_note">*
															<?php
                                                            if(isset($_GET['bday'])) {
                                                                echo "Invalid Date Format.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_3" name="txtBday" class="element text medium" type="text" maxlength="30"
            								 value="<?php if(isset($_GET['b'])){
											echo $_GET['b'];} else echo "DD/MM/YYYY"; ?>" onclick="clearText(this)" onblur="clearText(this)"  />		 
		</div> 
		</li>
      
        <li id="li_10" >
		<label class="description" for="element_8">Membership Type <span class="error_note">*
																	<?php
                                                                    if(isset($_GET['mem_len'])) {
                                                                        echo "Choose An Answer.";}
                                                                    ?>
                                                                    </span></label>
		<span>
            <input id="element_8_1" name="element_8" class="element radio" type="radio" value="1" <?php if($_GET['m']==1){
																									echo "checked='checked'"; }?> />
            <label class="choice" for="element_8_1">One Day</label><div class="price">
			$<?php $dayFee = $fc->forWhom("single", "One Day", "new", "male"); echo $dayFee['mem_fee'];?></div>
            <p class="note">$50 Door Fee Each Visit Monday-Thursday, and Friday before 10pm<br />
            	$50 After 5pm<br /> 
				Saturdays before 5pm - $20 Membership, $50 Door fee
            </p>
            <input id="element_8_2" name="element_8" class="element radio" type="radio" value="2" <?php if($_GET['m']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_8_2">One Month</label><div class="price">
			$<?php $monthFee = $fc->forWhom("single", "One Month", "new", "male"); echo $monthFee['mem_fee'];?></div>
             <p class="note">$50 Door Fee Each Visit Monday-Friday, $100 After 5pm<br/>
             				$50 Friday &amp; Saturday Night, and Sunday</p>
             
            <input id="element_8_3" name="element_8" class="element radio" type="radio" value="3" <?php if($_GET['m']==3){
																									echo "checked='checked'"; }?> />
            <label class="choice" for="element_8_3">One Year</label><div class="price">
			$<?php $yearFee = $fc->forWhom("single", "One Year VIP", "new", "male"); echo $yearFee['mem_fee'];?></div>
		</span>		</li>
       
			  <li id="li_4" >
		<label class="description" for="element_4">Are You Offended By Nudity?  <span class="error_note">*
																				<?php
                                                                                if(isset($_GET['nudity'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
            <input id="element_4_2" name="element_4" class="element radio" type="radio" value="1" <?php if($_GET['n']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_4_2">No</label>
            <input id="element_4_1" name="element_4" class="element radio" type="radio" value="2"  <?php if($_GET['n']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_4_1">Yes</label>
		</span>		</li>		
			  <li id="li_5">
		<label class="description" for="element_5">Are You Offended By Sexual Activity?  <span class="error_note">*
																							<?php
                                                                                            if(isset($_GET['sex_act'])) {
                                                                                                echo "Choose An Answer.";}
                                                                                            ?>
                                                                                            </span></label>
		<span>
            <input id="element_5_2" name="element_5" class="element radio" type="radio" value="1" <?php if($_GET['s']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_5_2">No</label>
            <input id="element_5_1" name="element_5" class="element radio" type="radio" value="2" <?php if($_GET['s']==2){
																									echo "checked='checked'"; }?> />
            <label class="choice" for="element_5_1">Yes</label>
		</span>		</li>		
			  <li id="li_6" >
		<label class="description" for="element_6">Does Swinging Offend You?  <span class="error_note">*
        																		<?php
																				if(isset($_GET['swinging'])) {
																					echo "Choose An Answer.";}
																				?>
                                                                                </span></label>
		<span>
            <input id="element_6_2" name="element_6" class="element radio" type="radio" value="1"  <?php if($_GET['w']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_6_2">No</label>
            <input id="element_6_1" name="element_6" class="element radio" type="radio" value="2" <?php if($_GET['w']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_6_1">Yes</label>
		</span>		</li>		
			  <li id="li_7" >
		<label class="description" for="element_7">Are You A Police Officer?  <span class="error_note">*
        																		<?php
																				if(isset($_GET['police'])) {
																					echo "Choose An Answer.";}
																				?>
                                                                                </span></label>
		<span>
            <input id="element_7_2" name="element_7" class="element radio" type="radio" value="1" <?php if($_GET['p']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_7_2">No</label>
            <input id="element_7_1" name="element_7" class="element radio" type="radio" value="2" <?php if($_GET['p']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_7_1">Yes</label>
		</span>		</li>		
			  <li id="li_9" >
		<label class="description" for="element_9">Do You Agree To All Rules?  <span class="error_note">*
        																		<?php
																				if(isset($_GET['agree'])) {
																					echo "Sorry You Have To Agree To Join.";}
																				?>
                                                                                </span></label>
		<span>
            <input id="element_9_1" name="element_9" class="element radio" type="radio" value="1" <?php if($_GET['a']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_9_1">Yes</label>
            <input id="element_9_2" name="element_9" class="element radio" type="radio" value="2" <?php if($_GET['a']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_9_2">No</label>
		</span>		</li>
			
			  <li class="buttons">
			    <input type="hidden" name="gender" value="male" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit_single_male" value="Submit" />
		</li>
		  </ul>
		</form>	
        
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="singleform/bottom.png" alt="">
	</body>
</html>