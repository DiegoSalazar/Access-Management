<div id="clubContainer">

<div id="club">

	<img id="loader" src="<?php echo base_url(); ?>images/loadingAnimation.gif" alt="Loading..." />

<div id="login" class="<?php echo $authenticated; ?>">
	<h2 id="login-head">Access Management</h2>
	<?php echo form_open('club'); ?>
		<div>
			<input class="text" type="text" name="user" />
		</div>
		<div>
			<input class="text" type="password" name="pw" />
		</div>
		<div>
			<input id="login-btn" type="submit" name="login" value="Log In" />
		</div>
	</form>
	<div id="login_error"></div>
</div>

<div id="logout" class="<?php echo $authenticated; ?>">Logout</div>

<div	id="authenticated" class="<?php echo $authenticated; ?>">
	
	<h2>Welcome <?php echo isset($user) ? $user : ''; ?></h2>
	
	<div id="main_buttons">
		<div id="checkin_div" class="input-div">
			<a class="thickbox main-btn checkin" id="checkin-btn" href="#TB_inline?height=350&width=400&inlineId=checkin_thickbox&modal=true">Check In</a>
		</div>
		
		<!--<div id="new_member_div" class="input-div">
			<a class="thickbox main-btn member_card" href="">Member Card</a>
		</div>-->
	</div>
	
	<div id="search-div">
		<?php echo form_open('club/members'); ?>
			<div><input class="text" id="filter" type="text" name="filter" value="" /></div>
			<div><input class="thickbox member_link" alt="#TB_inline?height=100&width=500&inlineId=member_info_thickbox" type="submit" name="Search" value="Search" /></div>
		</form>	
	</div>
	
	<div id="box_wrapper">
		
		<div id="members" class="box">
			<h3>Member Options</h3>
			<div class="scroll">
				<?php echo isset($members) ? $members : 'Nothing to display'; ?>
			</div>
		</div>
		
		<?php if (isset($memberships)): ?>
		<div id="memberships" class="box">
			<?php echo form_open('club/m_or_df/memberships'); ?>
				<h3>Memberships </h3><span class="box_opts"><input type="submit" name="edit" value="Update" class="edit-btn" /></span>
				<div class="scroll">
				<?php echo isset($memberships) ? $memberships : 'Nothing to display'; ?>
				</div>
			</form>
		</div>
		<?php endif; ?>
		
		<?php if (isset($memberships)): ?>
		<div id="staff" class="box">
			<h3>Staff</h3>
			<div class="scroll">
			<?php echo isset($staff) ? $staff : 'Nothing to display'; ?>
			</div>
			<div class="btns-bar" id="btns-bar">
				<?php echo form_open('club/staff'); ?>
					<div class="left">
						<input type="submit" name="add" value="Add" class="add-btn" />
					</div>
					<div class="mid">
						<label for="user-field">User</label>
						<input type="text" name="user" id="user-field" />
					</div>
					<div class="mid-right">
						<label for="pw-field">Pass</label>
						<input type="password" name="pw" id="pw-field" />
					</div>
					<div class="mid">
						<select name="role" id="role-select">
							<option selected="selected">Role</option>
							<option value="staff">Staff</option>
							<option value="admin">Admin</option>
						</select>
					</div>
				</form>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if (isset($memberships)): ?>
		<div id="door_fees" class="box">
			<?php echo form_open('club/m_or_df/door_fees'); ?>
				<h3>Door Fees - <span class="caption">Day, Night</span></h3><span class="box_opts"><input type="submit" name="edit" value="Update" class="edit-btn" /></span>
				<div class="scroll">
				<?php echo isset($door_fees) ? $door_fees : 'Nothing to display'; ?>
				</div>
			</form>
		</div>
		<?php endif; ?>
		
		<?php if (isset($memberships)): ?>
		<div id="discounts" class="box">
			<?php echo form_open('club/discounts'); ?>
				<h3>Discounts</h3>
				<div class="scroll">
				<?php echo isset($discounts) ? $discounts : 'Nothing to display'; ?>
				</div>
				<div class="btns-bar" id="discount-form-bar">
					<div class="left">
						<input type="submit" name="add" value="Add" class="add-btn" />
					</div>
					<div class="mid">
						<label for="desc-field">Discount</label>
						<input type="text" name="desc" id="desc-field" />
					</div>
					<div class="mid-right">
						<div>
						<label for="percent">&#37;</label>
						<input type="radio" name="operator" id="percent" value="percent" />
						</div>
						<div>
						<label for="minus">&#36;</label>
						<input type="radio" name="operator" id="minus" value="minus" />
						</div>
					</div>
					<div class="mid">
						<input type="text" title="Amount" name="amount" id="amount" maxlength="2" value="" />
					</div>
				</div>
			</form>
		</div>
		<?php endif; ?>
		
		<?php if (isset($memberships)): ?>
		<div id="hours" class="box">
			<?php echo form_open('club/hours'); ?>
				<h3>Business Hours</h3><span class="box_opts"><input type="submit" name="edit" value="Update" class="edit-btn" /></span>
				<div class="scroll">
				<?php echo isset($hours) ? $hours : 'Nothing to display'; ?>
				</div>
			</form>
		</div>
		<?php endif; ?>
		
	</div> <!-- /#box_wrapper -->
	
	<?php if (isset($logs)): ?>	
	<div id="msg_box">
		<?php foreach ($logs as $log): ?>
		<p style="display:block" class="success">
			<span class="timestamp"><?php echo $log->timestamp; ?>: </span>
			<?php echo $log->text; ?>
		</p>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	
	<div id="buttons">
		
		<?php if (isset($download_contacts)): echo form_open('club/download_contacts/'); ?>
			<div><input type="submit" name="contacts" value="Download Contacts" /></div>
		</form>
		<?php endif; ?>
		
		<?php if (isset($quick_add)): echo form_open('club/quick_add/'); ?>
			<div><input type="submit" name="quick_add" value="Add Members" /></div>
		</form>
		<?php endif; ?>

		<?php if (isset($quick_add)):?>
			<a href='<?php echo base_url(); ?>old/admin/slideshow/FlashEffects/'>Slideshow</a>
		<?php endif; ?>

	</div>
	
	<div id="checkin_thickbox">
		<a class="close" href="#" title="Close">X</a>
		<?php echo form_open('club/checkin', array('id' => 'checkin_form')); ?>
			<fieldset id="primary_fields">
				<legend>Check In</legend>
				<div>
					<label for="member_num-field">Member #</label>
					<input type="text" name="member_num" id="member_num-field" class="resetable" maxlength="6" />
				</div>
				<div id="sl_div">
					<select name="staff" id="staff_list">
						<option value="">Staff</option>
						<?php echo isset($staff_names) ? $staff_names : ''; ?>
					</select>
				</div>
				<div>
					<input type="submit" name="submit" class="go-btn" id="go" value="Go" />
					
					<div id="small_opts">
					<label title="If only one male member of a couple is checking in." class="small-label" for="male-button">M</label>
					<input title="If only one male member of a couple is checking in." type="radio" name="checkin_member_type" value="male" id="male-button" />
					<label title="If only one female member of a couple is checking in." class="small-label" for="female-button">F</label>
					<input title="If only one female member of a couple is checking in." class="small-label" type="radio" name="checkin_member_type" value="female" id="female-button" />
					</div>
				</div>
			</fieldset>
			
			<?php if (isset($discount_opts)): ?>
			<fieldset id="discount_fields">
				<legend>Discounts</legend>
				<ul id="discounts_list">
					<?php echo $discount_opts; ?>
				</ul>
			</fieldset>
			<?php endif; ?>
		</form>
	</div> <!-- /#checkin_thickbox -->
	
	<div id="member_info_thickbox">
		<img id="member_loader" src="<?php echo base_url(); ?>images/loadingAnimation.gif" alt="Loading..." />
		<?php if ($this->session->userdata('role') == 'admin'): ?>
			<?php echo form_open('club/members', array('id' => 'member_form')); ?>
		<?php else: ?>
			<?php echo form_open('#', array('id' => 'member_form')); ?>
		<?php endif; ?>
		
			<div id="controls">
				<div id="updating">
					<img src="<?php echo base_url(); ?>images/ajax-loader.gif" alt="Updating..." />
				</div>
				
				<?php if ($this->session->userdata('role') == 'admin'): ?>
					<input type="submit" name="update" id="update" value="Update" />
					<input type="hidden" name="edit" value="1" />
				<?php endif; ?>
				
				<!--<a class="thickbox main-btn row-btn checkin" id="member-" href="#TB_inline?height=350&width=400&inlineId=checkin_thickbox&modal=true">Check In</a>-->
			</div>
			
			<fieldset id="personal-fields">
				<legend>Personal</legend>
				<div id="fname-div">
					<label for="fname-field">First Name</label>
					<input type="text" name="fname" id="fname-field"  maxlength="20" />
				</div>
				<div id="lname-div">
					<label for="lname-field">Last Name</label>
					<input type="text" name="lname" id="lname-field"  maxlength="20" />
				</div>
				<div id="email-div">
					<label for="email-field">Email</label>
					<input type="text" name="email" id="email-field"  maxlength="30" />
				</div>
				<div id="bday-div" class="short">
					<label for="bday-field">Birthday</label>
					<input class="datefield" type="text" name="bday" id="bday-field"  maxlength="10" />
				</div>
			</fieldset>
			<fieldset id="partner-fields" class="no_display">
				<legend>Partner's Info</legend>
				<div id="pfname-div">
					<label for="pfname-field">First Name</label>
					<input type="text" name="pfname" id="pfname-field"  maxlength="20" />
				</div>
				<div id="plname-div">
					<label for="plname-field">Last Name</label>
					<input type="text" name="plname" id="plname-field"  maxlength="20" />
				</div>
				<div id="pemail-div">
					<label for="pemail-field">Email</label>
					<input type="text" name="pemail" id="pemail-field"  maxlength="30" />
				</div>
				<div id="pbday-div" class="short">
					<label for="pbday-field">Birthday</label>
					<input class="datefield" type="text" name="pbday" id="pbday-field"  maxlength="10" />
				</div>
				<div id="anniv-div" class="short">
					<label for="anniv-field">Anniversary</label>
					<input class="annivfield" type="text" name="anniv" id="anniv-field"  maxlength="10" />
				</div>
			</fieldset>
			<fieldset id="membership-fields">
				<legend>Membership Details</legend>
				<div id="memberships-div">
					<label for="membership-field">Membership</label>
					<?php echo $memberships_select; ?>
				</div>
				<div id="mem_num-div" class="short">
					<label for="member_num-field">Member #</label>
					<input type="text" name="member_num" id="member_num-field"  maxlength="6" />
				</div>
				<div id="type-div" class="short">
					<label for="type-field">Type</label>
					<input type="text" name="type" id="type-field"  maxlength="10" />
				</div>
				<div id="status-div" class="short">
					<label for="status-field">Status</label>
					<?php echo $status_select; ?>
				</div>
				<div id="start_date-div" class="short">
					<label for="start_date-field">Join Date</label>
					<input type="text" name="start_date" id="start_date-field"  maxlength="10" />
				</div>
				<div id="expires-div" class="short">
					<label for="expires-field">Expires</label>
					<input type="text" name="expires" id="expires-field"  maxlength="10" />
				</div>
				<div id="recalculate-div" class="short">
					<label for="recalculate-field">Recalculate Expires?</label>
					<input type="checkbox" name="recalculate" id="recalculate-field" />
				</div>
				<p class="notice">
					Recalculating the expiry date takes the Join date and adds the membership length. <br />
					Leave unchecked to manually enter the expires date.
				</p>
			</fieldset>
			<fieldset id="comment-fields">
				<legend>Comments</legend>
				<textarea cols="54" rows="7" name="comment" id="comment-field">Loading...</textarea>
			</fieldset>
			<fieldset id="history-fields">
				<legend>History</legend>
				<table>
					<tr>
						<th class="date-head">Date/Time</th>
						<th class="total-head">Total</th>
						<th class="discounts-head">Discounts</th>
						<th class="paid-head">Paid</th>
						<th class="staff-head">Staff</th>
					</tr>
				</table>
				<div id="history">
					Loading...
				</div>
			</fieldset>
			
		</form>
		
	</div> <!-- /#member_info_thickbox -->

</div><!-- /#authenticated -->		
</div> <!-- /#club -->