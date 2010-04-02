<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Single Female's Application</title>
<link rel="stylesheet" type="text/css" href="coupleform/view.css" media="all">
<script type="text/javascript" src="coupleform/view.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
	function clearText(){
		document.myForm.txtBday.value= "";
	}
</script>
<style type="text/css">
	.price {
		position:absolute;
		left:100pt;
		margin-top:-17pt;
	}
</style>

</head>
<body id="main_body" >
	
	<img id="top" src="coupleform/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Single Female's Application</a></h1>
		<form id="form_57963" name="myForm" class="appnitro"  method="post" action="process.php" onSubmit="return ValidateForm()">
					<div class="form_description">
			<h2>Single Female's Application</h2>
			<p>With Brief Questionnaire</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Name </label>
		<span>
			<input id="element_1_1" name= "element_1_1" class="element text" maxlength="20" size="8" 
            						value="<?php if(isset($_GET['f'])){
											echo $_GET['f'];} ?>"/>
			<label>First<span class="error_note">*
							<?php
                            if(isset($_GET['fname'])) {
                                echo "Fill In Your First Name.";}
                            ?>
                            </span></label>
		</span>
		<span>
			<input id="element_1_2" name= "element_1_2" class="element text" maxlength="20" size="14" 
            					value="<?php if(isset($_GET['l'])){
											echo $_GET['l'];} ?>"/>
			<label>Last<span class="error_note">*
							<?php
                            if(isset($_GET['lname'])) {
                                echo "Fill In Your Last Name.";}
                            ?>
                            </span></label>
		</span>		</li>			
			  <li id="li_3" >
		<label class="description" for="element_3">Email <span class="error_note">*
													<?php
                                                    if(isset($_GET['email'])) {
                                                        echo "Invalid Email.";}
                                                    ?>
                                                    </span></label>	
		<div>
			<input id="element_3" name="txtEmail" class="element text medium" type="text" maxlength="30" 
            					value="<?php if(isset($_GET['e'])){
											echo $_GET['e'];} ?>"/>
		</div> 
		</li>	
        	<li id="li_3_1" >
		<label class="description" for="element_3_1">Birthday <span class="error_note">*
																<?php
                                                                if(isset($_GET['bday'])) {
                                                                    echo "Invalid Date.";}
                                                                ?>
                                                                </span></label>
		<div>
			<input id="element_3_1" name="txtBday" class="element text medium" type="text" maxlength="30" 
            						value="<?php if(isset($_GET['b'])){
											echo $_GET['b'];} else echo "MM/DD/YYYY"; ?>" onclick="clearText()" /> 
		</div> 
		</li>
        
			  <li id="li_4" >
		<label class="description" for="element_4">Are You Offended By Nudity? <span class="error_note">*
																				<?php
                                                                                if(isset($_GET['nudity'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
			<input id="element_4_1" name="element_4" class="element radio" type="radio" value="1" <?php if($_GET['n']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_4_1">No</label>
            <input id="element_4_2" name="element_4" class="element radio" type="radio" value="2" <?php if($_GET['n']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_4_2">Yes</label>
		</span>		</li>		
			  <li id="li_5" >
		<label class="description" for="element_5">Does Sexual Activity Offend You?<span class="error_note">*
																				<?php
                                                                                if(isset($_GET['sex_act'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
			<input id="element_5_1" name="element_5" class="element radio" type="radio" value="1"<?php if($_GET['s']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_5_1">No</label>
            <input id="element_5_2" name="element_5" class="element radio" type="radio" value="2" <?php if($_GET['s']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_5_2">Yes</label>
		</span>		</li>		
			  <li id="li_6" >
		<label class="description" for="element_6">Are you Offended By Swinging?<span class="error_note">*
																				<?php
                                                                                if(isset($_GET['swinging'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
			<input id="element_6_1" name="element_6" class="element radio" type="radio" value="1"<?php if($_GET['w']==1){
																									echo "checked='checked'";} ?>  />
            <label class="choice" for="element_6_1">No</label>
            <input id="element_6_2" name="element_6" class="element radio" type="radio" value="2"<?php if($_GET['w']==2){
																									echo "checked='checked'";} ?>  />
            <label class="choice" for="element_6_2">Yes</label>
		</span>		</li>		
			  <li id="li_7" >
		<label class="description" for="element_7">Are You An Undercover Police Officer?<span class="error_note">*
																				<?php
                                                                                if(isset($_GET['police'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
			<input id="element_7_1" name="element_7" class="element radio" type="radio" value="1" <?php if($_GET['p']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_7_1">No</label>
            <input id="element_7_2" name="element_7" class="element radio" type="radio" value="2"<?php if($_GET['p']==2){
																									echo "checked='checked'";} ?>  />
            <label class="choice" for="element_7_2">Yes</label>
		</span>		</li>		
			  <li id="li_8" >
		<label class="description" for="element_8">Do You Agree To All Rules? <span class="error_note">*
																				<?php
                                                                                if(isset($_GET['agree'])) {
                                                                                    echo "You Must Agree All Rules.";}
                                                                                ?>
                                                                                </span></label>
		<span>
         	<input id="element_8_2" name="element_8" class="element radio" type="radio" value="1" <?php if($_GET['a']==1){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_8_2">Yes</label>
			<input id="element_8_1" name="element_8" class="element radio" type="radio" value="2"<?php if($_GET['a']==2){
																									echo "checked='checked'";} ?>  />
            <label class="choice" for="element_8_1">No</label>
		</span>		</li>
			
			  <li class="buttons">
			    <input type="hidden" name="gender" value="female" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit_single_female" value="Submit" />
		</li>
		  </ul>
		</form>	
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="coupleform/bottom.png" alt="">
	</body>
</html>