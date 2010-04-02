<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Couples Application</title>
<link rel="stylesheet" type="text/css" href="coupleform/view.css" media="all">
<?php
include("admin/classes.php");
$fc = new FeeCalculator;
?>
<script type="text/javascript" src="coupleform/view.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
	function clearText(input){
		input.value= "";
	}
	function reFillText(input) {
		if (input.value == "") {
			input.value = "MM/DD/YYYY";
		}
	}
</script>
<style type="text/css">
	.price {
		position:absolute;
		left:120pt;
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
</style>

</head>
<body id="main_body" >
	
	<img id="top" src="coupleform/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Couple's Application</a></h1>
		<form id="form_57963" name="myForm" class="appnitro"  method="post" action="process.php" onSubmit="return ValidateForm()">
					<div class="form_description">
			<h2>Couple's Application</h2>
			<p>With Brief Questionnaire</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Name </label>
		<span>
			<input id="element_1_1" name= "element_1_1" class="element text" maxlength="20" size="8" 
            				value="<?php if(isset($_GET['f1'])){
											echo $_GET['f1'];} ?>"/>
			<label>First<span class="error_note">*
						<?php
                        if(isset($_GET['fname1'])) {
                            echo "Fill In Your First Name.";}
                        ?>
                        </span></label>
		</span>
		<span>
			<input id="element_1_2" name= "element_1_2" class="element text" maxlength="20" size="14" 
            				value="<?php if(isset($_GET['l1'])){
											echo $_GET['l1'];} ?>"/>
			<label>Last<span class="error_note">*
						<?php
                        if(isset($_GET['lname1'])) {
                            echo "Fill In Your Last Name.";}
                        ?>
                        </span></label>
		</span>		</li>		
			  <li id="li_2" >
		<label class="description" for="element_2">Partner's Name </label>
		<span>
			<input id="element_2_1" name= "element_2_1" class="element text" maxlength="20" size="8" 
            				value="<?php if(isset($_GET['f2'])){
											echo $_GET['f2'];} ?>"/>
			<label>First<span class="error_note">*
						<?php
                        if(isset($_GET['fname2'])) {
                            echo "Fill In Your Partner's First Name.";}
                        ?>
                        </span></label>
		</span>
		<span>
			<input id="element_2_2" name= "element_2_2" class="element text" maxlength="20" size="14" 
            				value="<?php if(isset($_GET['l2'])){
											echo $_GET['l2'];} ?>"/>
			<label>Last<span class="error_note">*
						<?php
                        if(isset($_GET['lname2'])) {
                            echo "Fill In Your Partner's Last Name.";}
                        ?>
                        </span></label>
		</span>		</li>		
			  <li>
		<label class="description" for="element_3">Email <span class="error_note">*
															<?php
                                                            if(isset($_GET['email'])) {
                                                                echo "Invalid Email Address.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_3" name="txtEmail" class="element text medium" type="text" maxlength="30" 
            				value="<?php if(isset($_GET['e'])){
											echo $_GET['e'];} ?>"/> 
		</div> 
		</li>	
         <li>
		<label class="description" for="element_3">Partner's Email <span class="error_note">*
															<?php
                                                            if(isset($_GET['email2'])) {
                                                                echo "Invalid Email Address.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_3" name="txtPartnersEmail" class="element text medium" type="text" maxlength="30" 
            				value="<?php if(isset($_GET['e2'])){
											echo $_GET['e2'];} ?>"/> 
		</div> 
		</li>	
        <li>
		<label class="description" for="element_9">Birthday <span class="error_note">*
															<?php
                                                            if(isset($_GET['bday'])) {
                                                                echo "Invalid Date Format.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_9" name="txtBday" class="element text small" type="text" maxlength="30" value="<?php if(isset($_GET['b'])){
																										echo $_GET['b'];}else echo"DD/MM/YYYY"; ?>"  
            																	onclick="clearText(this)" onblur="reFillText(this)"/> 
		</div> 
		</li>	
        <li>
		<label class="description" for="element_19">Partner's Birthday <span class="error_note">*
															<?php
                                                            if(isset($_GET['bday2'])) {
                                                                echo "Invalid Date Format.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_19" name="txtBday2" class="element text small" type="text" maxlength="30" value="<?php if(isset($_GET['b2'])){
																										echo $_GET['b2'];}else echo"DD/MM/YYYY"; ?>" 
            																		onclick="clearText(this)" onblur="reFillText(this)"/> 
		</div> 
		</li>	
        <li id="li_10" >
		<label class="description" for="element_10">Anniversary <span class="error_note">*
															<?php
                                                            if(isset($_GET['anniv'])) {
                                                                echo "Invalid Date Format.";}
                                                            ?>
                                                            </span></label>
		<div>
			<input id="element_10" name="txtAnniv" class="element text small" type="text" maxlength="30" value="<?php if(isset($_GET['anv'])){
																										echo $_GET['anv'];}else echo"DD/MM/YYYY"; ?>"
            																			 onclick="clearText(this)" onblur="reFillText(this)"/> 
		</div> 
		</li>
        
        <li>
        <label class="description" for="element_11">Membership - One Day <span class="error_note">*
																			<?php
                                                                            if(isset($_GET['mem_len'])) {
                                                                                echo "Choose An Answer.";}
                                                                            ?>
                                                                            </span></label>
        <span>
        <input id="element_11_1" name="element_11" class="element radio" type="radio" value="1" <?php if($_GET['m']==1){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_11_1"><?php include("calc2/days.php"); ?></label><div class="price">
			$<?php $dayFee = $fc->forWhom("couple", "One Day", "new");
				if ($dayFee['mem_fee'] == 0) {
					echo $dayFee['door_fee'];
				} else echo $dayFee['mem_fee'];
			 ?>
            	</div>
            <p class="note">$80 On Saturdays and Sundays</p>
      
       
		<label class="description" for="element_11">Membership</label>           
            
            <input id="element_11_2" name="element_11" class="element radio" type="radio" value="2" <?php if($_GET['m']==2){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_11_2">Three Months</label><div class="price">
            $<?php $monthFee = $fc->forWhom("couple", "Three Months", "new"); echo $monthFee['mem_fee']; ?>
            </div>
            <p class="note">$50.00 Door Fee Each Visit</p>
            
            <input id="element_11_3" name="element_11" class="element radio" type="radio" value="3" <?php if($_GET['m']==3){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_11_3">One Year</label><div class="price">
            $<?php $yearFee = $fc->forWhom("couple", "One Year", "new"); echo $yearFee['mem_fee']; ?>
            </div>
            <p class="note">$50.00 Door Fee Each Visit</p>
            
            <input id="element_11_4" name="element_11" class="element radio" type="radio" value="4" <?php if($_GET['m']==4){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_11_4">One Year VIP</label><div class="price">
            $<?php $vipFee = $fc->forWhom("couple", "One Year VIP", "new"); echo $vipFee['mem_fee']; ?>
            </div>
            <p class="note">No Door Fees</p>
		</span>		</li>			
			  <li id="li_4" >
		<label class="description" for="element_4">Are You Offended By Nudity? <span class="error_note">*
																				<?php
                                                                                if(isset($_GET['nudity'])) {
                                                                                    echo "Choose An Answer.";}
                                                                                ?>
                                                                                </span></label>
		<span>
			<input id="element_4_1" name="element_4" class="element radio" type="radio" value="1" <?php if($_GET['n']==1){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_4_1">No</label>
            <input id="element_4_2" name="element_4" class="element radio" type="radio" value="2" <?php if($_GET['n']==2){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_4_2">Yes</label>
		</span>		</li>		
			  <li id="li_5" >
		<label class="description" for="element_5">Does Sexual Activity Offend You? <span class="error_note">*
																					<?php
                                                                                    if(isset($_GET['sex_act'])) {
                                                                                        echo "Choose An Answer.";}
                                                                                    ?>
                                                                                    </span></label>
		<span>
			<input id="element_5_1" name="element_5" class="element radio" type="radio" value="1" <?php if($_GET['s']==1){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_5_1">No</label>
            <input id="element_5_2" name="element_5" class="element radio" type="radio" value="2" <?php if($_GET['s']==2){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_5_2">Yes</label>
		</span>		</li>		
			  <li id="li_6" >
		<label class="description" for="element_6">Are you Offended By Swinging? <span class="error_note">*
																					<?php
                                                                                    if(isset($_GET['swinging'])) {
                                                                                        echo "Choose An Answer.";}
                                                                                    ?>
                                                                                    </span></label>	
		<span>
			<input id="element_6_1" name="element_6" class="element radio" type="radio" value="1" <?php if($_GET['w']==1){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_6_1">No</label>
            <input id="element_6_2" name="element_6" class="element radio" type="radio" value="2" <?php if($_GET['w']==2){
																									echo "checked='checked'";} ?>/>
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
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_7_1">No</label>
            <input id="element_7_2" name="element_7" class="element radio" type="radio" value="2" <?php if($_GET['p']==2){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_7_2">Yes</label>
		</span>		</li>		
			  <li id="li_8" >
		<label class="description" for="element_8">Do You Agree To All Rules?<span class="error_note">*
																					<?php
                                                                                    if(isset($_GET['agree'])) {
                                                                                        echo "Choose An Answer.";}
                                                                                    ?>
                                                                                    </span></label>	
		<span>
         	<input id="element_8_2" name="element_8" class="element radio" type="radio" value="1" <?php if($_GET['a']==1){
																									echo "checked='checked'";} ?>/>
            <label class="choice" for="element_8_2">Yes</label>
			<input id="element_8_1" name="element_8" class="element radio" type="radio" value="2" <?php if($_GET['a']==2){
																									echo "checked='checked'";} ?> />
            <label class="choice" for="element_8_1">No</label>
		</span>		</li>
			
			  <li class="buttons">
			    <input type="hidden" name="form_id" value="57963" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit_couple" value="Submit" />
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