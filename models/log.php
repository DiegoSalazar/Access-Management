<?php
class Log extends Model {

	function Log() {
		parent::Model();
	}
	
	function save_record($text) {
		$timestamp = date('D M d G:i:s Y'); // eg Wed Oct  7 20:27:59 2009
		$data = array('username' => $this->session->userdata('user'), 'text' => $text, 'timestamp' => $timestamp);
		$this->db->insert('log', $data);
	}
	
	function logs() {
		$data = array();
		$Q = $this->db->order_by('created_at DESC')->get('log');
		
		if ($Q->num_rows() > 0) {
			$data = $Q->result();
			$Q->free_result();
		} 
		
		return $data;
	}
	
}
//END log model