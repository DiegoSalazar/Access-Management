<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Club Prices Slideshow Editor</title>
<?php include("process.php"); ?>
<link rel="stylesheet" type="text/css" href="../slideshowform/view.css" media="all">
<script type="text/javascript" src=../"slideshowform/view.js"></script>
<style type="text/css">
#back {
	float:right;
	margin-top:35pt;
	margin-right:10pt;
}
</style>
</head>
<body id="main_body" >
	
	<img id="top" src="../slideshowform/top.png" alt="">
	<div id="form_container">
	
    	<div id="back">
			<form method="link" action="/club"><input type="submit" value="Back to Admin Area" /></form>
			<form method="link" action="slideshow.php">
                <input type="submit" value="Launch Slideshow" />
            </form>
		</div>
    
		<h1><a>Club Prices Slideshow</a></h1>
		<form id="form_58566" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Club Prices Slideshow</h2>
			<p>Edit Individual Slideshow Text Items.</p>
		</div>
        
        <div id="display"><?php if (isset($_POST['submit'])) { displaySuccess(); } ?></div>						
			<ul >
			
					<li class="section_break">
			<h3>Slide 1 - Couples Prices</h3>
			<p></p>
		</li>		
			  <li id="li_1" >
		<label class="description" for="element_1">Field 1 </label>
		<div>
			<textarea id="element_1" name="slide1_1" class="element textarea small"><?php echo $display1_1; ?></textarea> 
		</div><p class="guidelines" id="guide_1"><small>Edit The 1st Text Field in Slide 1</small></p> 
		</li>		
			  <li id="li_2" >
		<label class="description" for="element_2">Field 2 </label>
		<div>
			<textarea id="element_2" name="slide1_2" class="element textarea small"><?php echo $display1_2; ?></textarea> 
		</div><p class="guidelines" id="guide_2"><small>Edit The 2nd Text Field in Slide 1</small></p> 
		</li>		
			  <li id="li_3" >
		<label class="description" for="element_3">Field 3 </label>
		<div>
			<textarea id="element_3" name="slide1_3" class="element textarea small"><?php echo $display1_3; ?></textarea> 
		</div><p class="guidelines" id="guide_3"><small>Edit The 3rd Text Field in Slide 1</small></p> 
		</li>	
        <label class="description" for="element_4">Field 3 </label>
		<div>
			<textarea id="element_4" name="slide1_4" class="element textarea small"><?php echo $display1_4; ?></textarea> 
		</div><p class="guidelines" id="guide_4"><small>Edit The 4TH Text Field in Slide 1</small></p> 
		</li>		
        <label class="description" for="element_3">Field 3 </label>
		<div>
			<textarea id="element_3_5" name="slide1_5" class="element textarea small"><?php echo $display1_5; ?></textarea> 
		</div><p class="guidelines" id="guide_3_5"><small>Edit The 5TH Text Field in Slide 1</small></p> 
		</li>		
        <label class="description" for="element_3_6">Field 6 </label>
		<div>
			<textarea id="element_3_6" name="slide1_6" class="element textarea small"><?php echo $display1_6; ?></textarea> 
		</div><p class="guidelines" id="guide_3_6"><small>Edit The 6TH Text Field in Slide 1</small></p> 
		</li>			
			  <li class="section_break">
			<h3>Slide 2 - Singles Prices</h3>
			<p></p>
		</li>		
			  <li id="li_5" >
		<label class="description" for="element_5">Field 1 </label>
		<div>
			<textarea id="element_5" name="slide2_1" class="element textarea small"><?php echo $display2_1; ?></textarea> 
		</div><p class="guidelines" id="guide_5"><small>Edit The 1st Text Field in Slide 2</small></p> 
		</li>		
			  <li id="li_6" >
		<label class="description" for="element_6">Field 2 </label>
		<div>
			<textarea id="element_6" name="slide2_2" class="element textarea small"><?php echo $display2_2; ?></textarea> 
		</div><p class="guidelines" id="guide_6"><small>Edit The 2nd Text Field in Slide 2</small></p> 
		</li>		
			  <li id="li_7" >
		<label class="description" for="element_7">Field 3 </label>
		<div>
			<textarea id="element_7" name="slide2_3" class="element textarea small"><?php echo $display2_3; ?></textarea> 
		</div><p class="guidelines" id="guide_7"><small>Edit The 3rd Text Field in Slide 2</small></p> 
		</li>	
        <li id="li_7" >
		<label class="description" for="element_7_4">Field 3 </label>
		<div>
			<textarea id="element_7_4" name="slide2_4" class="element textarea small"><?php echo $display2_4; ?></textarea> 
		</div><p class="guidelines" id="guide_7_4"><small>Edit The 4th Text Field in Slide 2</small></p> 
		</li>	
        <li id="li_7" >
		<label class="description" for="element_7_5">Field 3 </label>
		<div>
			<textarea id="element_7_5" name="slide2_5" class="element textarea small"><?php echo $display2_5; ?></textarea> 
		</div><p class="guidelines" id="guide_7_5"><small>Edit The 5TH Text Field in Slide 2</small></p> 
		</li>		
			  <li class="section_break">
			<h3>Slide 3 - Club Description</h3>
			<p></p>
		</li>		
			  <li id="li_9" >
		<label class="description" for="element_9">Summary </label>
		<div>
			<textarea id="element_9" name="slide3" class="element textarea medium"><?php echo $display3; ?></textarea> 
		</div><p class="guidelines" id="guide_9"><small>Edit The Club Description Slide.</small></p> 
		</li>
			
			  <li class="buttons">
			    <input type="hidden" name="form_id" value="58566" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
		  </ul>
		</form>	
		<div id="footer">
			Made Specially For <a href="http://www.deenieshideaway.com">Deenie's Hideaway</a><br />
            by <a href="http://www.greyrobot.com">Greyrobot.com</a>
		</div>
	</div>
	<img id="bottom" src="../Flash Effects/slideshowform/bottom.png" alt="">
	</body>
</html>