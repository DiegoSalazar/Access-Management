<?php
class Members extends Model {

	function Members() {
		parent::Model();
	}
	
	function create_member($info) {
		//member number will be X0001, where X is C for Couples, F for Females, or M for Males,
		//and the number is incremented from the most recent member id
		$member_num = strtoupper(substr($info['type'], 0, 1)) . $this->next_id();
		
		$this->db->insert('members', array(
			'member_num' => $member_num, 
			'email' => clean($info['email']), 
			'type' => clean($info['type']),
			'status' => 'newby'
		));
		$id = $this->db->insert_id();
		
		$this->db->insert('member_info', array(
		    'mem_id' => $id, 
		    'fname' => clean($info['fname']), 
		    'lname' => clean($info['lname']),
		    'email' => clean($info['email']),
		    'bday' => clean($info['bday'])
		));
		
		if (!isset($info['date_joined'])) {
			$start = date('Y-m-d');
			$end = $this->get_end_date($info['membership'], $start);
		} else { //when creating a member through the add member page admin page.
			$start = date('Y-m-d', strtotime($info['date_joined']));
			$end = $this->get_end_date($info['membership'], $start);
		}

		$this->db->insert('enroll_period', array(
		    'mem_id' => $id, 
		    'membership' => $info['membership'],
		    'start_date' => $start, 
		    'end_date' => $end,
		));
		
		if ($info['type'] == 'couple') {
			$this->db->insert('partners_info', array(
			    'mem_id' => $id, 
			    'fname' => clean($info['pfname']), 
			    'lname' => clean($info['plname']),
			    'email' => clean($info['pemail']),
			    'anniv' => clean($info['anniv']),
			    'bday' => clean($info['pbday'])
			));
		}
		
		return $id;
	}
	
	function get_end_date($membership, $start) {
		switch ($membership) {
			case '1_Month':
				$end = date('Y-m-d' ,strtotime('+1 month' , strtotime($start)));
			break;
			case '3_Months':
			case '3_Month_VIP':
				$end = date('Y-m-d' ,strtotime('+3 month' , strtotime($start)));
			break;
			case '1_Year':
			case '1_Yr_Couples_VIP':
			case '1_Yr_Singles_VIP':
				$end = date('Y-m-d' ,strtotime('+1 year' , strtotime($start)));
			break;
		}
		return $end;
	}

	function member_banned($fname, $lname) {		
		$Q1 = $this->db->get_where('member_info', array('fname' => $fname, 'lname' => $lname));
		if ($Q1->num_rows() > 0) {
			$Q2 = $this->db->get_where('members', array('id' => $Q1->row()->mem_id));
			return $Q2->row()->status == 'disabled' ? true : false;
		}
		
		$Q3 = $this->db->get_where('partners_info', array('fname' => $fname, 'lname' => $lname));
		if ($Q3->num_rows() > 0) {
			$Q4 = $this->db->get_where('members', array('id' => $Q3->row()->mem_id));
			return $Q4->row()->status == 'disabled' ? true : false;
		}
		return false;
	}
	
	function update_member_enter() {
		$id = $this->input->post('id', true);
		$payment = array(
			'mem_id' => $id,
			'mem_fee' => $this->input->post('mem_fee', true),
			'raw_door_fee' => $this->input->post('raw_door_fee', true),
			'door_fee' => $this->input->post('door_fee', true),	
			'total' => $this->input->post('total', true),	
			'discounts' => $this->input->post('discounts', true)
		);
		$log = array(
			'mem_id' => $id, 
			'date_in' => date('Y-m-d'), 
			'time_in' => date('g:ia'), 
			'staff' => $this->input->post('staff', true)
		);
		
		$error = '';
		$this->db->insert('entrance_log', $log);
		if (!$this->db->insert_id()) $error .= "Failed to log the entrance.\n";
		
		$this->db->insert('payments', $payment);
		if (!$this->db->insert_id()) $error .= "Failed to log the payment.\n";

		if ($error == '') {
			return array('status' => 'success', 'id' => $id);
		}
		return array('status' => 'failed', 'error' => $error);
	}
	
	function member_history($id) {
		$sql = "SELECT payments.date, payments.raw_door_fee, payments.door_fee, payments.discounts, entrance_log.date_in, entrance_log.time_in, entrance_log.staff FROM payments LEFT JOIN entrance_log ON payments.mem_id = entrance_log.mem_id WHERE payments.mem_id = '{$id}' ORDER BY payments.id DESC";
		
		$Q = $this->db->query($sql);
		
		if ($Q->num_rows() > 0) {
			$result = $Q->result(); $Q->free_result();
			$this->table->set_template(array('table_open' => '<table class=\'history_table\'>', 'row_alt_start' => '<tr class=\'even\'>'));
			$this->table->set_heading('Date/Time', 'Total', 'Discounts', 'Paid', 'Staff');
			
			foreach ($result as $r) {
				$this->table->add_row('<span class=\'date-cell\'>'.$r->date.'</span>', '$'.number_format($r->raw_door_fee,2), $r->discounts, '$'.number_format($r->door_fee,2), $r->staff);	
			}
			
			$table = $this->table->generate();
			$this->table->clear();
			
			return $table;
		}
	}
	
	function member_info($id = false) {
		//humongous sql, why did i normalize my tables so!
		$sql = "SELECT members.id, members.email, members.member_num, members.type, members.status";
		$sql .= ", member_info.fname, member_info.lname, member_info.bday";
		$sql .= ", partners_info.fname AS pfname, partners_info.lname AS plname";
		$sql .= ", partners_info.bday AS pbday, partners_info.email AS pemail, partners_info.anniv";
		$sql .= ", enroll_period.start_date, enroll_period.end_date AS expires, enroll_period.membership ";
		$sql .= ", member_comments.comment, member_comments.created_at, member_comments.by_username ";
		$sql .= "FROM members ";
		$sql .= "JOIN member_info ON members.id = member_info.mem_id ";
		$sql .= "JOIN enroll_period ON enroll_period.mem_id = members.id ";
		$sql .= "LEFT JOIN partners_info ON partners_info.mem_id = members.id ";
		$sql .= "LEFT JOIN payments ON payments.mem_id = members.id ";
		$sql .= "LEFT JOIN member_comments ON member_comments.mem_id = members.id ";
		
		if ($id) {
			$sql .= "WHERE members.id = '{$id}' ";
			$sql .= "LIMIT 1";
		} else {
			$sql .= "ORDER BY members.id ";
			$sql .= "DESC";
		}
		
		$Q = $this->db->query($sql);
		
		$members = $Q->result_array();
		$Q->free_result();
		
		return $members;
	}
	
	function members_table() {
		$members = array();
		
		$sql = "SELECT members.id, members.member_num, members.type";
		$sql .= ", member_info.fname, member_info.lname ";
		$sql .= "FROM members ";
		$sql .= "JOIN member_info ON members.id = member_info.mem_id ";
		$sql .= "WHERE members.status != 'disabled' ";
		$sql .= "ORDER BY members.id ";
		$sql .= "DESC ";
		$Q = $this->db->query($sql);
		
		if ($Q->num_rows() > 0) {
			$members = $Q->result();
			$Q->free_result();
			
			$table = "<table id='members_table' class='display' cellspacing='0' cellpadding='0'>\n";
				$table .= "<thead><tr>\n
							<th>Mem #</th>\n
							<th>Name</th>\n
							<th class='checkin-col'></th>\n";
							
				if ($this->session->userdata('role') == 'admin') $table .= "<th class='del-col'></th>\n";
				
				$table .= "</tr></thead><tbody>\n";
			$i = 0;	
			foreach ($members as $member) {
				$even = ($i % 2) ? ' even' : '';
				$table .= "<tr class='table_row".$even."' id='member_row-" . $member->id . "'>\n";
					$table .= "<td class='id'>" . $member->member_num . "</td>\n";
					$table .= "<td class='name'><a id='member-".$member->id."' title=\"View/Edit " . $member->fname . "'s Account\" class='thickbox member_link' href='#TB_inline?height=100&width=500&inlineId=member_info_thickbox'>" . $member->fname . ' ' . $member->lname . "</a></td>\n";
					$table .= "<td class='checkin-col'><a class='thickbox row-btn' id='member-".$member->member_num."' href='#TB_inline?height=350&width=400&inlineId=checkin_thickbox&modal=true' title='Check In'>O</a></td>";
					
					if ($this->session->userdata('role') == 'admin') $table .= "<td class='del-col'>
							   <form method='post' action='" . base_url() . "club/members/" . $member->id . "'>\n
								<div class='del_div' id='user-".$member->id."'>
									<input class='btn del' type='submit' name='delete' value='X' title='Delete this member' />\n
								</div>\n
							   </form>\n
							 </td>";
				$table .= "</tr>\n";
				$i++;
			}
			$table .= "</tbody></table>\n";
			
			return $table;
		}
	}
	
	function get_member($id) {
		$sql = "SELECT members.member_num, members.status, members.type, members.date_created, enroll_period.membership";
		$sql .= ", enroll_period.start_date, enroll_period.end_date";
		$sql .= ", CONCAT(member_info.fname, ' ', member_info.lname) AS name";
		$sql .= " FROM members, member_info, enroll_period";
		$sql .= " WHERE members.id = '{$id}' AND (members.id = member_info.mem_id AND members.id = enroll_period.mem_id)";
		$Q = $this->db->query($sql);
		
		if ($Q->num_rows() == 1) {
			$mem = $Q->row(); $Q->free_result();
			$data = array(
				'id' => $id,
				'member_num' => $mem->member_num,
				'name' => $mem->name,
				'status' => $mem->status,
				'date_created' => $mem->date_created,
				'type' => $mem->type,
				'start' => $mem->start_date,
				'exp' => $mem->end_date,
				'membership' => $mem->membership
			);
			return $data;
		}
	}
	
	function renew_membership() {
		//we are only update the end_date to preserve the original start_date of the member
		$membership = $this->input->post('membership', true);
		$end = $this->get_end_date($membership, date('Y-m-d'));

		$id = $this->input->post('id', true);
		
		$this->db->where('mem_id', $id);
		$this->db->update('enroll_period', array('end_date' => $end));
		$updated = $this->update_member_status($id, 'active');
				
		return $updated;
	}
	
	function update_member_status($id, $status) {
		$this->db->where('id', $id);
		$this->db->update('members', array('status' => $status));	
		return $this->db->affected_rows();
	}
	
	function latest_mem($latest_id) { //used by the member updater
		$current_id = $this->next_id(0, true);
		//echo $latest_id . ' ' . $current_id; exit;
		if ($latest_id < $current_id) {
			return $this->get_member($current_id);
		} else {
			return false;
		}
	}
	
	function edit_member() {
		$id = $this->db->select('id')->where('member_num', $this->input->post('member_num', true))->get('members')->row()->id;
		
		if ($this->input->post('type') == 'couple') {
			$partners_info = array(
				'fname' => $this->input->post('pfname', true),	
				'lname' => $this->input->post('plname', true),
				'bday' => $this->input->post('pbday', true),
				'email' => $this->input->post('pemail', true),
				'anniv' => $this->input->post('anniv', true)
			);
			$this->db->where('mem_id', $id)->update('partners_info', $partners_info);
		}
		
		$comment = array(
			'comment' => $this->input->post('comment', true),
			'by_username' => $this->session->userdata('user')
		);
		$this->update_or_create($id, $comment);
		
		$expire = $this->input->post('recalculate', true) ? $this->get_end_date($this->input->post('membership'), $this->input->post('start_date')) : $this->input->post('expires');
		$enroll_period = array(
			'membership' => $this->input->post('membership'),	
			'start_date' => $this->input->post('start_date'),
			'end_date' => $expire
		);
		$this->db->where('mem_id', $id)->update('enroll_period', $enroll_period);
		
		$member = array(
			'email' => $this->input->post('email'),
			'member_num' => $this->input->post('member_num'),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status')			
		);	
		$this->db->where('id', $id)->update('members', $member);
		
		$member_info = array(
			'fname' => $this->input->post('fname'),		
			'lname' => $this->input->post('lname'),
			'email' => $this->input->post('email'),
			'bday' => $this->input->post('bday')				 
		);
		$this->db->where('mem_id', $id)->update('member_info', $member_info);		
		
		return $this->db->affected_rows();
	}
	
	function pays_only_upgrade_fee($id, $mem_type) {
		if ($mem_type == 'male' && $this->is_night_hours() && $this->already_payed_todays_fee($id)) return true;
		return false;
	}
	
	function already_payed_todays_fee($id) {
		$todays_date = date('Y-m-d'); // 2009-12-31
		
		$Q = $this->db->where(array('mem_id' => $id, 'date_in' => $todays_date))->
										order_by('id DESC')->
										limit(1)->get('entrance_log');
		
		if ($Q->num_rows() > 0) {
			$time_in = format24hr($Q->row()->time_in);
			return $time_in >= $this->get_hour('day_start') && $time_in < $this->get_hour('day_end')  ? true : false;
		}	else return false;
	}
	
	function get_hour($shift, $hr24 = true) { // night_start, night_end, etc..
		$today = date('l'); // full text day, 'Sunday'
		$Q = $this->db->select($shift)->where('day', $today)->get('hours');
		return $hr24 ? format24hr($Q->row()->$shift) : $Q->row()->$shift;
	}
	
	function clean_timestamp($t) {
		$t = explode(':', $t);
		return $t[0];
	}
	
	function is_night_hours() {
		$hour = date('G'); // 24 hr
		$meridian = date('a'); // am
		$today = date('l'); // full text day
		$Q = $this->db->where('day', $today)->get('hours');
		$hours = $Q->row();
		if (($meridian == 'am' && $hour < format24hr((int)$hours->night_end)) || 
				($meridian == 'pm' && $hour >= format24hr((int)$hours->night_start)) ) {
			return true;
		}
		return false;
	}
	
	function update_or_create($id, $data_array) {
		if ($this->db->get_where('member_comments', array('mem_id' => $id))->num_rows) {
			$this->db->where('mem_id', $id)->update('member_comments', $data_array);
		} else {
			$data_array['mem_id'] = $id;
			$this->db->insert('member_comments', $data_array);
		}
	}
	
	function delete_member($id) {
		$this->db->where('id', $id);
		$this->db->update('members', array('status' => 'disabled'));
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	function next_id($next = 1, $counting = false) {
		if ($counting) $this->db->not_like('status', 'disabled');
		$this->db->select('id')->order_by('id', 'desc')->limit(1);
		$Q = $this->db->get('members');
		$result = $Q->row();
		return $result->id + $next;
	}
	
	function contacts($order = 'member_info.lname') {
		$sql = "SELECT members.member_num";
		$sql .= ", CONCAT(member_info.fname,' ',member_info.lname) AS name";
		$sql .= ", member_info.email, member_info.bday";
		$sql .= ", CONCAT(partners_info.fname,' ',partners_info.lname) AS pname";
		$sql .= ", partners_info.email AS pemail, partners_info.bday AS pbday , partners_info.anniv";
		$sql .= ", members.type, enroll_period.membership, enroll_period.start_date, enroll_period.end_date AS expires";
		$sql .= " FROM members";
		$sql .= " JOIN member_info ON members.id = member_info.mem_id";
		$sql .= " JOIN enroll_period ON members.id = enroll_period.mem_id";
		$sql .= " LEFT JOIN partners_info ON members.id = partners_info.mem_id";
		$sql .= " ORDER BY ".$order;
		$sql .= " ASC";
		
		$Q = $this->db->query($sql);
		$n = $Q->num_rows();
		
		if ($n > 0) {
			$results = $Q->result();
			foreach ($results as $num => $c) {
				$data[] = array(
					'Name' => $c->name, 
					'Email' => $c->email, 
					'Birthday' => $c->bday, 
					'Partner\'s Name' => $c->pname, 
					'Partner\'s Email' => $c->pemail, 
					'Partner\'s Birthday' => $c->pbday, 
					'Anniversary' => $c->anniv, 
					'Type' => $c->type, 
					'Membership' => $c->membership, 
					'Date Joined' => $c->start_date, 
					'Expires' => $c->expires
				);	
			}
			$ret['contacts'] = $data;
			$ret['resource'] = $Q;
			return $ret;
		}
	}
	
	function dump($var = false) {
		echo "<pre>";
		if ($var) print_r($var);
		else print_r($_POST);
		exit;
	}
	
}
//END users model