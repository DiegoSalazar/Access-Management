<?php
class Club extends Controller {

	function Club() {
		parent::Controller();
		$this->load->model('members');
		$this->load->model('staff');
		$this->load->model('discounts');
		$this->load->model('prices');
		$this->load->model('log');
	}
		
	function index() {
		$logging_in = 'false';
		if (isset($_POST['login'])) {
			$logging_in = 'true';
			$this->staff->authenticate($this->input->post('user', true), $this->input->post('pw', true));
		}
		$authenticated = $this->session->userdata('user') ? 'true' : 'false';
		$this->load($authenticated, $logging_in);
	}
		
	function load($authenticated, $logging_in) {
		$data['logging_in'] = $logging_in;
		
		if ($authenticated == 'true') {
			$data['vars']['authenticated'] = 'true';
			
			if ($this->session->userdata('role') == 'admin') {
				$data['vars']['memberships'] = $this->prices->get_memberships_or_door_fees('memberships');
				$data['vars']['door_fees'] = $this->prices->get_memberships_or_door_fees('door_fees');
				$data['vars']['staff'] = $this->staff->staff_table();
				$data['vars']['hours'] = $this->prices->hours_table();
				$data['vars']['discounts'] = $this->prices->discounts();
				$data['vars']['logs'] = $this->log->logs();
				$data['vars']['download_contacts'] = true;
				$data['vars']['quick_add'] = true;
			}
			
			$data['vars']['members'] = $this->members->members_table();
			$data['vars']['memberships_select'] = $this->prices->get_dropdown('membership', 'memberships');
			$data['vars']['status_select'] = $this->prices->get_dropdown('status', 'members');
			//checkin box
			$data['vars']['staff_names'] = $this->staff->staff_names();
			$data['vars']['discount_opts'] = $this->prices->discount_opts();
			$data['vars']['user'] = $this->session->userdata('user');
			
		} else $data['vars']['authenticated'] = 'false';
		
		//page data
		$data['title'] = 'The Club | Deenie\'s Hideaway';
		$data['page'] = 'club';
		$this->load->view('common/layout', $data);
	}
	
	function logout() {
		$this->session->sess_destroy();
		echo 'logged out';
		exit;
	}
	
	function checkin() {
		if (isset($_POST['member_num'])) {
			//Step 1: staff clicks CHECK IN, modal box pops up, types in member_num
			//        gets member details...
			$id = str_replace(array('m','f','c','M','F','C'), '', $this->input->post('member_num', true));
			$staff = $this->input->post('staff', true);
			$member = $this->members->get_member($id);
			if (count($member)) {
				//check that membership is not expired
				if ($member['exp'] <= date('Y-m-d')) {
					$member['status'] = 'expired';
					$this->members->update_member_status($id, 'expired');
				}
				
				//get membership fees just in case member is expired and we need to show all prices
				$memfees = $this->prices->get_membership_fees($member['type'], true);
				$checkin_member_type = $member['type'];
				if ($this->input->post('checkin_member_type') && $member['type'] == 'couple') {
					$checkin_member_type = $this->input->post('checkin_member_type', true);
				}
				
				//then get the door fees that apply to this member
				$door_fee = $this->prices->get_door_fee(($member['status'] == 'newby') ? $member['type'] : $checkin_member_type);
				$raw_door_fee = $door_fee;
				$mem_fee = 0; //default amount
				$xtra_msg = '';
				
				if ($this->members->already_payed_todays_fee($id) && !$this->members->is_night_hours()) {
					$xtra_msg = 'Has already payed today\'s fee.';
					$door_fee = 0;
				}	elseif ($this->members->pays_only_upgrade_fee($id, $member['type'])) {
					// male members have already payed the day fee and only need to pay the upgrade fee
					$xtra_msg = 'Only owes tonight\'s upgrade fee.';
					$door_fee -= $this->prices->get_door_fee($member['type'], true);
				}
				
				//any discounts?
				$discounts = $this->get_discounts();
				
				$total = $door_fee; //default value
				
				//Step 2: Set up the json object to send back to jquery
				//        to make the hidden inputs for the FINISH form
				
				if ($member['status'] != 'expired') {
					$text = 'Checking In: '.$member['name'].' pays $'.number_format($door_fee,'2').".\n " . $xtra_msg;
					
					if ($member['status'] == 'newby') {
						$mem_fee = $this->prices->get_mem_fee(($member['type']), $member['membership']);	
						$total = $mem_fee + $door_fee;
						$member['status'] = 'active';
						
						$newby = $member['type'] == 'couple' ? 'Newbies' : 'Newby';
						$text = $newby.'! '.$member['name'].' owes $'.$door_fee.' in door fees,<br />$'.$mem_fee.' in membership fees for a <br />total of <strong>$'.number_format($total,'2').".</strong>";	
					}
								
				} else {
					//Step 2.5: if the membership is expired lets get the total along back to jquery
					$text = 'Checking In: '.$member['name'].' owes $<span class=\'price\'>'.number_format($total).'</span>, and must renew membership.';
				}
				
				if ($discounts) $text .= '<br />'.$discounts['msg'].' in discounts were used.';
				
				$response = array(
					'status' => 'success',
					'text' => $text,
					'staff' => $staff,
					'name' => $member['name'],
					'id' => $member['id'],
					'raw_door_fee' => $raw_door_fee,
					'door_fee' => $door_fee,
					'mem_fee' => $mem_fee,
					'discounts' => $discounts,
					'total' => $total,
					'mem_status' => $member['status'],
					'memfees' => $memfees
				);	
				
			} else {
				//A non existent member num has been typed in
				$response = array('status' => 'error', 'text' => 'ID: '.$id.', does not exist or is not active');	
			}
			
		}
		//Step 3: staff clicks FINISH and the hidden values that were created by jquery are posted back.
		//        log the event, and generate the json response
		elseif (isset($_POST['checkin']) && !isset($_POST['renew'])) {
			//here the staff has confirmed the member is checking in, should we do more checks?
			$updated = $this->members->update_member_enter();
			$this->members->update_member_status($_POST['id'], 'active');

			if ($updated['status'] == 'success') {
				$response = array('status' => 'success', 'text' => $_POST['name'] . ' Has Been Checked In!');
			} else {
				$response = array('status' => 'error', 'text' => $updated['error']);	
			}
		} elseif (isset($_POST['checkin']) && isset($_POST['renew'])) {
			//the member is renewing and checking in
			$updated = $this->members->update_member_enter();
			$renewed = $this->members->renew_membership();
			
			if ($updated['status'] == 'success') {
				$response = array('status' => 'success', 'text' => $_POST['name'] . ' Has Been Checked In and Renewed!');
			} else {
				$response = array('status' => 'error', 'text' => (isset($updated['error']) ? $updated['error'] : '').' or membership wasn\'t renewed');	
			}
		} else {
			$response = array('status' => 'error', 'text' => 'No valid data sent.');	
		}
		//Step 4. Done, echo and exit to prevent output buffering errors.
		$this->log->save_record($response['text']);
		echo json_encode($response);
		exit;
	}
	
	function get_discounts() {
		global $door_fee;
		if (isset($_POST['discounts'])) {
			$discounts = array();
			$percent = false; $multi_discounts = false;
			$count_d = count($_POST['discounts']); 
			
			if ($count_d > 1) $multi_discounts = true;
			
			$i = 1;
			foreach ($this->input->post('discounts', true) as $expression) {
				$expression = stripslashes($expression);
				list($operator, $val) = split(',', $expression);
				
				$value_str = ($operator == 'percent') ? ($val.' Percent Off') : ('$'.$val.' Off');
				$discounts[] = ($multi_discounts && ($i == $count_d)) ? 'and '.$value_str : $value_str;
				
				switch ($operator) {
					case 'minus':
						$door_fee -= $val;
					break;
					case 'percent': //val should be 
						$door_fee -= number_format($door_fee * ($val / 100));
						$percent = true;
					break;
				}
				$i++;
			}
			if ($door_fee < 0) $door_fee = 0;
			return array('msg' => implode(', ', $discounts), 'off' => $door_fee);
		}
		return array();
	}
	
	function hours() {
		if (isset($_POST['edit'])) {
			$updated = $this->prices->update_hours(
				$this->input->post('day_start', true), 
				$this->input->post('day_end', true), 
				$this->input->post('night_start', true), 
				$this->input->post('night_end', true) 
			);
			$response = array('status' => 'success', 'text' => 'Business Hours Have Been Updated!');	
			if (!$updated || count($updated) == 0) {
				$response = array('status' => 'error', 'text' => 'Failed to update hours.');
			}
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
		}
	}
	
	function reception() {
		$this->dump();	
	}
	
	function memberships() { $this->m_or_df('memberships'); }
	function door_fees() { $this->m_or_df('door_fees'); }
	
	//@param string either 'memberships' or 'door_fees'
	function m_or_df($m_or_df) {
		if (isset($_POST['edit'])) {
			$data = $_POST; unset($data['edit']);
			
			$updated = false;
			foreach ($data as $mem_or_fee => $val) {
				list($type, $membership_or_day) = explode('-', $mem_or_fee);
				$updated .= $this->prices->update_memberships_or_door_fees($m_or_df, $type, $val, $membership_or_day);
			}
			
			if ($updated) {
				$response = array('status' => 'success', 'text' => ucfirst(str_replace('_',' ',$m_or_df)).' Have Been Updated!');
			} else $response = array('status' => 'error', 'text' => 'Failed to update '.str_replace('_',' ',$m_or_df));
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
		}
	}
	
	function staff($id = false) {
		if ($id) { //edit or delete was clicked
			if (isset($_POST['delete'])) {
				$response = array('status' => 'success', 'text' => 'Deleted user account with ID: ' . $id);	
				if (!$this->staff->delete_user($id)) {
					$response = array('status' => 'error', 'text' => 'Failed to delete user with ID: ' . $id);
				}
				echo json_encode($response);
				exit;
			} elseif (isset($_POST['edit'])) {
				$id = $this->input->post('id', true);
				$user = trim($this->input->post('field_1', true));
				$pw = trim($this->input->post('field_2', true));
				$role = $this->input->post('field_3', true);
				
				$response = array(
					'user' => $user, 
					'role' => $role, 
					'status' => 'success', 
					'text' => 'Updated '.$user.'\'s account'
				);
				
				if (!$this->staff->update_staff($id, $user, $pw, $role)) {
					$response = array('status' => 'error', 'text' => 'Failed to update user with ID: ' . $id);
				}
				
				$this->log->save_record($response['text']);
				echo json_encode($response);
				exit;
				
			}
			
		} elseif (isset($_POST['add'])) { //create new staff
			$user = trim($this->input->post('field_1', true));
			$pw = trim($this->input->post('field_2', true));
			$role = $this->input->post('field_3', true);
			
			$id = $this->staff->create_user($user, $pw, $role);
			if ($id) {
				$response = array('id' => $id, 'status' => 'success', 'text' => ucfirst($role).' account created for ' . $user);
			} else $response = array('status' => 'error', 'text' => 'Failed to create staff account');

			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
			
		}
		
		$response = array('status' => 'error', 'text' => 'No ID or expected post vars');
		$this->log->save_record($response['text']);
		echo json_encode($response);
		exit;
		
	}
	
	function members($id = false) {
		if (isset($_POST['view'])) {
			$member = $this->members->member_info($id);
			echo json_encode($member);
			exit;
		} elseif (isset($_POST['edit'])) {
			$success = $this->members->edit_member();
			if ($success >= 0) {
				$response = array('status' => 'success', 'text' => 'The account info for '.$this->input->post('fname').' has been updated.');
			} else {
				$response = array('status' => 'error', 'text' => 'Failed to update account info');
			}
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
			
		} elseif (isset($_POST['delete'])) {
			$deleted = $this->members->delete_member($id);
			if ($deleted) {
				$response = array('status' => 'success', 'text' => 'Member with ID ' . $id .', has been disabled.');
			} else {
				$response = array('status' => 'error', 'text' => 'Failed to disable member with ID: ' . $id);
			}
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
			
		} 
	}
	
	function new_member_check($latest_id) {
		$latest_mem = $this->members->latest_mem($latest_id);
		if (is_array($latest_mem)) {
			$latest_mem['status'] = 'success';
			$latest_mem['text'] = $latest_mem['name'] . ' Has Joined the Club!';
			
			$this->log->save_record($latest_mem['text']);
			echo json_encode($latest_mem);
			exit;
			
		} else return false;
	}
	
	function discounts($id = false) {
		if ($id) { //edit or delete
			if (isset($_POST['delete'])) {
				$deleted = $this->prices->delete_discount($id);
				if ($deleted) {
					$response = array(
						'status' => 'success', 
						'text' => 'Discount deleted.'
					);
				} else $response = array('status' => 'error', 'text' => 'Failed to delete dicount.');
			}
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
			
		} elseif (isset($_POST['add'])) { //create new discount
		
			$desc = trim($this->input->post('field_1', true));
			$operator = $this->input->post('field_2', true);
			$amount = $this->input->post('field_3', true);
			
			$id = $this->prices->create_discount($desc, $operator, $amount);
			if ($id) {
				$response = array(
					'status' => $id,
					'status' => 'success', 
					'text' => "Discount created: \"" . $desc . "\".\n" .
							'Value: ' . $amount . ($operator == 'percent' ? ' percent ' : ' dollars ') . 'off.'
				);
			} else $response = array('status' => 'error', 'text' => 'Failed to create staff account');
			
			$this->log->save_record($response['text']);
			echo json_encode($response);
			exit;
			
		}
		
		$response = array('status' => 'error', 'text' => 'No ID or expected post vars');
		$this->log->save_record($response['text']);
		echo json_encode($response);
		exit;
	}
	
	function get_member_history($id) {
		if (isset($_POST['get'])) {
			echo $this->members->member_history($id);
			exit;
		}
	}
	
	function download_contacts() {
		$ret = $this->members->contacts();
		
		if (isset($_POST['excel'])) { 
			$this->load->plugin('to_excel');
			echo to_excel($ret, 'contacts');
		
		} else {	
			$this->table->set_template(array('table_open' => '<table id=\'contacts_print_table\'>', 'row_alt_start' => '<tr class=\'even\'>'));
			
			$i = 0;
			foreach ($ret['contacts'] as $fields) {
				$j = 0;
				foreach ($fields as $heading => $val) {
					if ($i == 0) $headings[] = $heading;
					$rows[$i][] = $val;
					$j++;
				}
				$i++;
			}
			
			$this->table->set_heading($headings);
			
			foreach ($rows as $row) {
				$this->table->add_row($row);	
			}
			
			$data['table'] = $this->table->generate();
			$this->table->clear();
			
			$data['print_excel_link'] = "<form method='post' action='".base_url()."club/download_contacts'>";
			$data['print_excel_link'] .= "<input type='submit' name='excel' value='Generate Excel Spreadsheet' />";
			$data['print_excel_link'] .= "</form>";
			
			$this->load->view('contacts', $data);
		}
	}
	
	function quick_add() {
		if ($this->input->post('submit')) {
			$error = '';
			$data['type'] = $this->input->post('type', true);
				if ($data['type'] == '') $error .= '<p>Type is required.</p>';
			$data['membership'] = $this->input->post('membership', true);
				if ($data['membership'] == '') $error .= '<p>Membership is required.</p>';
			$data['status'] = $this->input->post('status', true);
				if ($data['status'] == '') $error .= '<p>Status is required.</p>';
			$data['date_joined'] = $this->input->post('date_joined', true);
				if ($data['date_joined'] == '') $error .= '<p>Date joined is required.</p>';
			$data['fname'] = $this->input->post('fname', true);
				if ($data['fname'] == '') $error .= '<p>First name is required.</p>';
			$data['lname'] = $this->input->post('lname', true);
				if ($data['lname'] == '') $error .= '<p>Last name is required.</p>';
			$data['email'] = $this->input->post('email', true);
			$data['bday'] = $this->input->post('bday', true);
				if ($data['bday'] == '') $error .= '<p>Birthday is required.</p>';
			
			if ($data['type'] == 'couple') {
				$data['pfname'] = $this->input->post('fname', true);
					if ($data['pfname'] == '') $error .= '<p>First name is required.</p>';
				$data['plname'] = $this->input->post('lname', true);
					if ($data['plname'] == '') $error .= '<p>Last name is required.</p>';
				$data['pemail'] = $this->input->post('email', true);
				$data['pbday'] = $this->input->post('bday', true);	
					if ($data['fname'] == '') $error .= '<p>Birthday is required.</p>';
				$data['anniv'] = $this->input->post('anniv', true);	
			}
			
			if ($error != '') {
				$this->session->set_flashdata('msg', $error);
				redirect('club/quick_add');
			} else {
				$response = $this->members->create_member($data);
				$this->members->update_member_status($response['id'], $data['status']);
				$this->session->set_flashdata('msg', $data['fname'].' '.$data['lname'].' has been added to the database.');
				redirect('club/quick_add');
			}
		} else {
			$this->load->view('quick_add');	
		}
	}
	
	private function dump($array = NULL, $exit = true) {
		echo "<pre>";
		if ($array) print_r($array);
		else print_r($_POST);
		if ($exit) exit;
	}
	
}

/* End of file club.php */
/* Location: ./controllers/club.php */