<?php
class Staff extends Model {

	function Staff() {
		parent::Model();
	}
	
	function authenticate($user, $pw) {
		$Q = $this->db->get_where('users', array('username' => clean($user), 'hashed_pw' => sha1($pw)), 1);
		
		if ($Q->num_rows() == 1) {
			$info = $Q->row();
			$user_info['user'] = $user;
			$user_info['role'] = $info->type;
			
			$this->session->set_userdata($user_info);
			return $user_info;
		} 
		return false;
	}
	
	function create_user($user, $pw, $role = 'staff') {
		$user_array = array(
			'username' => clean($user), 
			'hashed_pw' => sha1($pw), 
			'type' => clean($role)
		);
		$this->db->insert('users', $user_array);
		return $this->db->insert_id();
	}	
	
	function update_staff($id, $user = false, $pw = false, $role = false) {
		$data = array('username' => clean($user), 'hashed_pw' => sha1($pw), 'type' => clean($role));
		if ($user || $user != '') $data['username'] = clean($user);
		if ($pw || $pw != '') $data['hashed_pw'] = sha1($pw);
		if ($role || $role != '' || $role != 'Role') $data['type'] = clean($role);
		
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return $this->db->affected_rows();
	}
	
	function staff_table() {
		$Q = $this->db->get('users');
		if ($Q->num_rows() > 0) {
			$this->table->set_template(array('table_open' => '<table id=\'staff_table\' cellspacing=\'0\' cellpadding=\'0\'>', 'row_alt_start' => '<tr class=\'even\'>'));
			$this->table->set_heading('Name', 'Role', '');
			foreach ($Q->result() as $result) {
				$this->table->add_row("<a class='edit-staff' title='Click to Edit' href='".base_url()."club/staff/".$result->id."'>\n".$result->username."</a>\n", $result->type, "<form style='display:inline-block' method='post' action='".base_url()."club/staff/".$result->id."'>\n<div class='del_div' id='user-".$result->id."'>\n<input type='submit' title='Delete this user' name='delete' class='del' value='X' />\n</div>\n</form>\n");
			}
			$table = $this->table->generate();
			$this->table->clear();	
		}
		return $table;
	}	
	
	function staff_names() {
		$Q = $this->db->select('id, username')->get('users');
		$opts = '';
		foreach ($Q->result_array() as $row) {
			$opts .= '<option value=\''.$row['username'].'\'>'.$row['username'].'</option>';
		}
		return $opts;
	}
	
	function delete_user($id) {
		$this->db->where('id', $id);
		$this->db->delete('users');
		return ($this->db->affected_rows() > 0) ? true : false;	
	}
}
//END users model