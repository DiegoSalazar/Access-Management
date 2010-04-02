<?php $this->load->view('common/header'); ?>
<style type='text/css'>
#wrap { width:50%; margin:0 auto; background-color:#fff; padding:20px }
label { display:block; margin-top:14px }
input { margin-bottom:7px }
#partners_info { display:none }
form { overflow:hidden; padding:14px }
form div { width:50%; float:left }
#submit_box { margin-top:14px; float:left;  }
#partners_info { width:100%; float:none; margin:0 0 14px 0; }
#partners_info p { clear:both; padding:14px 0; border-top:1px solid #7a7a7a }
#status { padding:14px }
#status label { display:inline }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.all.js"></script>
<script type="text/javascript">
$(function(){
	var d = new Date();
	var maxYear = d.getFullYear() - 21;
	var opts = { 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1910:'+maxYear,
		defaultDate: '-21y',
		buttonImage: '<?php echo base_url().'images/datepicker.gif'; ?>',
		buttonImageOnly: true
	};
	$(".datefield").datepicker(opts); 
	
	var annivOpts = { 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1930:'+d.getFullYear(),
		defaultDate: '-2y',
		buttonImage: '<?php echo base_url().'images/datepicker.gif'; ?>',
		buttonImageOnly: true
	};
	$(".annivfield").datepicker(annivOpts);
	
	var joinOpts = { 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1930:'+d.getFullYear(),
		defaultDate: '-1m',
		buttonImage: '<?php echo base_url().'images/datepicker.gif'; ?>',
		buttonImageOnly: true
	};
	$(".joinedfield").datepicker(joinOpts);
	
	$('#type').change(function(){
		if ($(this).val() == 'couple') $('#partners_info').slideDown();					  
	});		 
});
</script>
<title>Add Member</title>
</head>
<body>

<div id="wrap">
	
	<div class="msg">
	<?php if ($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>
	</div>
	
<a href='/club'>Back</a>

	<?php echo form_open('club/quick_add'); ?>
		<div>
			<label for="type">Type: </label>
			<select name="type" id="type">
				<option value=""></option>
				<option value="couple">Couple</option>
				<option value="female">Single Female</option>
				<option value="male">Single Male</option>
			</select>
		</div>
		<div>
			<label for="type">Membership: </label>
			<select name="membership" id="membership">
				<option value="1_Month">One Month</option>
				<option value="3_Months">Three Months</option>
				<option value="1_Year">One Year</option>
				<option value="3_Month_VIP">Three Month VIP</option>
				<option value="1_Yr_Couples_VIP">One Year Couples VIP</option>
				<option value="1_Yr_Singles_VIP">One Year Singles VIP</option>


			</select>
		</div>
		<div>
			<label for="fname">First Name: </label>
			<input type="text" name="fname" id="fname" />
		</div>
		<div>
			<label for="lname">Last Name: </label>
			<input type="text" name="lname" id="lname" />
		</div>
		<div>
			<label for="email">Email: </label>
			<input type="text" name="email" id="email" />
		</div>
		<div>
			<label for="bday">Birthday: </label>
			<input type="text" name="bday" id="bday" class="datefield" />
		</div>
		
		<div id="partners_info">
			<p>Partner's Info</p>
			<div>
				<label for="pfname">First Name: </label>
				<input type="text" name="pfname" id="pfname" />
			</div>
			<div>
				<label for="plname">Last Name: </label>
				<input type="text" name="plname" id="plname" />
			</div>
			<div>
				<label for="pemail">Email: </label>
				<input type="text" name="pemail" id="pemail" />
			</div>
			<div>
				<label for="pbday">Birthday: </label>
				<input type="text" name="pbday" id="pbday" class="datefield" />
			</div>
			<div>
				<label for="anniv">Anniversary: </label>
				<input type="text" name="anniv" id="anniv" class="annivfield" />
			</div>
		</div>
		
		<div id="status">
			<label for="status">Newby: </label>
			<input type="radio" name="status" value="newby" />
			<label for="status">Active: </label>
			<input type="radio" name="status" value="active" />
		</div>
		
		<div>
			<label for="date_joined">Date Joined: </label>
			<input type="text" name="date_joined" id="date_joined" class="joinedfield" />
		</div>
		
		
		<div id="submit_box"><input type="submit" name="submit" value="Add" /></div>
	</form>
	
</div>

</body>
</html>