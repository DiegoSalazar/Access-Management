<img id="top" src="<?php echo base_url(); ?>images/top.png" alt="">
<div id="form_container">

	<h1><a>Application</a></h1>
	<form class="appnitro" method="post" action="<?php echo base_url() . 'front/new_member/' . $type; ?>">
		<div class="form_description">
			<h2><?php echo $type_heading; ?>'s Application</h2>
			<p>With Brief Questionnaire</p>
		</div>	
		
		<div class="msg">
		  <?php if($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>
          </div>	
						
		<ul class="input_list">
			<li id="li_1" >
				<label class="description">Name </label>
				<span>
					<input name="fname" id="fname" class="element text" maxlength="20" size="12" value=""/>
					<label for="fname">First<span class="error_note">*</span></label>
				</span>
				<span>
					<input name="lname" id="lname" class="element text" maxlength="20" size="14" value=""/>
					<label for="lname">Last<span class="error_note">*</span></label>
				</span>		
			</li>
			<?php if ($type == 'couple'): ?>
				<li class="inlineList">
					<label class="description">Partner's Name </label>
					<span>
						<input name="pfname" id="pfname" class="element text" maxlength="20" size="12" value=""/>
						<label for="pfname">First<span class="error_note">*</span></label>
					</span>
					<span>
						<input name="plname" id="plname" class="element text" maxlength="20" size="14" value=""/>
						<label for="pfname">Last<span class="error_note">*</span></label>
					</span>		
				</li>	
			<?php endif; ?>		
			<li id="li_3" >
				<label class="description" for="email">Email <span class="error_note">*</span></label>	
				<div>
					<input name="email" id="email" class="element text" type="text" maxlength="40" value=""/>
				</div> 
			</li>	
			<?php if ($type == 'couple'): ?>
				<li class="inlineList">
					<label class="description" for="pemail">Partner's Email <span class="error_note">*</span></label>	
					<div>
						<input name="pemail" id="pemail" class="element text" type="text" maxlength="40" value=""/>
					</div> 
				</li>	
			<?php endif; ?>
			<li id="li_3_1" >
				<label class="description" for="bday">Birthday <span class="error_note">*</span></label>
				<div>
					<input name="bday" id="bday" class="datefield element text medium" type="text" maxlength="10" value=""  /> 
				</div> 
			</li>
			<?php if ($type == 'couple'): ?>
				<li class="inlineList">
					<label class="description" for="pbday">Partner's Birthday <span class="error_note">*</span></label>	
					<div>
						<input name="pbday" id="pbday" class="datefield element text medium" type="text" maxlength="10" value=""/>
					</div> 
				</li>
				<li>
					<label class="description" for="anniv">Anniversary <span class="error_note">*</span></label>	
					<div>
						<input name="anniv" id="anniv" class="annivfield element text medium" type="text" maxlength="10" value=""/>
					</div> 
				</li>		
			<?php endif; ?>
			
			<li id="prices_list">
				<h3 class="prices_heading">Memberships</h3>
				<?php echo $memberships; ?>
				<h3 class="prices_heading">Door Fees</h3>
				<?php echo $prices; ?>
			</li>
			
			<li class="block">&nbsp;</li>
			
			<li id="li_4" class="score_fields">
				<label class="description">Are You Offended By Nudity? <span class="error_note">*</span></label>
				<span>
					<input id="nudity_no" name="score[nudity]" class="element radio" type="radio" value="1"  />
					<label class="choice" for="nudity_no">No</label>
					<input id="nudity_yes" name="score[nudity]" class="element radio" type="radio" value="0" />
					<label class="choice" for="nudity_yes">Yes</label>
				</span>		
			</li>		
			<li id="li_5" class="score_fields">
				<label class="description" >Does Sexual Activity Offend You?<span class="error_note">*</span></label>
				<span>
					<input id="sex_no" name="score[sex_act]" class="element radio" type="radio" value="1" />
					<label class="choice" for="sex_no">No</label>
					<input id="sex_yes" name="score[sex_act]" class="element radio" type="radio" value="0" />
					<label class="choice" for="sex_yes">Yes</label>
				</span>		
			</li>		
		  <li id="li_6" class="score_fields">
			<label class="description">Are you Offended By Swinging?<span class="error_note">*</span></label>
			<span>
				<input id="swing_no" name="score[swinging]" class="element radio" type="radio" value="1" />
				<label class="choice" for="swing_no">No</label>
				<input id="swing_yes" name="score[swinging]" class="element radio" type="radio" value="0" />
				<label class="choice" for="swing_yes">Yes</label>
			</span>		
		</li>		
		<li id="li_7" class="score_fields">
			<label class="description">Are You An Undercover Police Officer?<span class="error_note">*</span></label>
			<span>
				<input id="police_no" name="score[police]" class="element radio" type="radio" value="1" />
				<label class="choice" for="police_no">No</label>
				<input id="police_yes" name="score[police]" class="element radio" type="radio" value="0" />
				<label class="choice" for="police_yes">Yes</label>
			</span>		
		</li>		
		<li id="li_8" class="score_fields">
			<label class="description">Do You Agree To All Rules? <span class="error_note">*</span></label>
			<span>
				<input id="agree_yes" name="score[agree]" class="element radio" type="radio" value="1" />
				<label class="choice" for="agree_yes">Yes</label>
				<input id="agree_no" name="score[agree]" class="element radio" type="radio" value="0" />
				<label class="choice" for="agree_no">No</label>
			</span>		
		</li>
		
		<li class="buttons">
			<input type="hidden" name="type" value="<?php echo $type; ?>" />
			<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit &amp; Review" />
		</li>
	  </ul>
	</form>	
