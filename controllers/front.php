<?php
class Front extends Controller {

	function Front() {
		parent::Controller();
		$this->load->model('members');
		$this->load->model('prices');
		$this->load->model('discounts');
	}
		
	function index() { 
		$data['title'] = 'Welcome to Deenie\'s Hideaway';
		
		if (isset($_POST['submit'])) { 
			$error = '';
			if (!isset($_POST['agree']) || $_POST['agree'] == 'no') $error .= '<p>You must agree to the rules to join.</p>';
			if ($_POST['type'] == 'none') $error .= '<p>You must select a membership type to proceed.</p>';
			
			if ($error == '') {
				$there = 'front/new_member/' . $this->input->post('type', true); 
				redirect($there);
			} else {
				$data['vars']['msg'] = $error;
				$data['title'] = 'Correct some errors';
			}
		}
		
		$data['title'] = 'Welcome to Deenie\'s Hideaway';
		$data['view'] = 'front';
		$data['page'] = 'front';
		$data['vars'] = 0;
		$this->load->view('common/layout', $data);	
	}
	
	function new_member($type) {
		if (isset($_POST['submit']) && ($type == 'couple' || $type == 'male' || $type == 'female')) {
			$info['fname'] = ucfirst($this->input->post('fname'));
			$info['lname'] = ucfirst($this->input->post('lname'));
			$info['email'] = $this->input->post('email');
			$info['bday'] = $this->input->post('bday');
			
			if ($this->members->member_banned($info['fname'], $info['lname'])) {
				$this->session->set_flashdata(array('msg' => 'A person with the name of '.$info['fname'].' '.$info['lname'].' has been previously banned from the club. If you\'re not this person please speak to the manager.'));
				redirect('front');	
			}
			
			if ($type == 'couple') {
				$info['pfname'] = ucfirst($this->input->post('pfname'));	
				$info['plname'] = ucfirst($this->input->post('plname'));
				$info['pemail'] = $this->input->post('pemail');
				$info['pbday'] = $this->input->post('pbday');
				$info['anniv'] = $this->input->post('anniv');
								
				if ($this->members->member_banned($info['pfname'], $info['plname'])) {
					$this->session->set_flashdata(array('msg' => 'The membership of a person with the name of '.$info['pfname'].' '.$info['plname'].' has been previously disabled from the club. If you\'re not this person please speak to the manager.'));
					redirect('front');	
				}				
			}
			
			//counts up the answers to the questionaire
			$pass = $this->evaluate($_POST['score']);
			if (!$pass) {
				$this->session->set_flashdata(array('msg' => '*You didn\'t fulfill the criteria.'));
				redirect('front/new_member/' . $type);
			}
			
			$info['membership'] = $this->input->post('membership'); //one year, three months, etc.
			$info['type'] = $type; //male, female, couple
			$info['door_fee'] = $this->prices->get_door_fee($type); //for that day and time
			//calculate membership costs, array('door_fee', 'mem_fee')
			$info['mem_fee'] = $this->prices->get_mem_fee($type, $info['membership']);
			
			$this->session->set_userdata('member', $info);
			$this->confirm($info);		
		} else { // display new_member form
			$data['prices'] = $this->prices->displayPrices($type);
			$data['memberships'] = $this->prices->displayMemberships($type);
			$data['vars']['type_heading'] = ucfirst($type);
			$data['vars']['type'] = $type;
			
			$data['title'] = ucfirst($type) . '\'s Membership Application';
			$data['view'] = 'new_member';
			$data['page'] = 'new_member';
			$this->load->view('common/layout', $data);
		}	
	} // END new_member()
	
	function confirm() {
		$info = $this->session->userdata('member');
		if (isset($_POST['join'])) {
			
			if ($this->members->create_member($info)) {
			 	redirect('front/welcome');
			} else die('Error creating member');
			
		} else {			
			$h = $info['type'] == 'couple' ? 
				  'Hi ' . $info['fname'] . ' and ' . $info['pfname'] :
				  'Hi ' . $info['fname'];
			$msg = '<h3>' . $h . '</h3>';
			
			$this->table->set_template(array('table_open' => '<table class=\'confirm_table\'>'));
			$this->table->set_heading('Membership', 'One Time Fee', 'Door Fee');
			$this->table->add_row(
				str_replace('_', ' ', $info['membership']), 
				'$'.number_format($info['mem_fee']), 
				'$'.number_format($info['door_fee'])
			);
			$this->table->add_row(
				'', 
				'<strong>Total:</strong> ', 
				'$' . number_format($info['mem_fee'] + $info['door_fee'])
			);
			$table = $this->table->generate();
			$this->table->clear();
			
			$data['vars']['details'] = $table;
			$data['vars']['msg'] = $msg;
			$data['vars']['type'] = $info['type'];
			
			$data['title'] = 'Confirm Membership Details';
			$data['page'] = 'confirm';
			$this->load->view('common/layout', $data);
		}
	}
	
	function welcome() {
		$info = $this->session->userdata('member');
		$msg = $info['type'] == 'couple' ? 
			  'Welcome to The Club ' . $info['fname'] . ' and ' . $info['pfname'] :
			  'Welcome to The Club ' . $info['fname'];
		$data['title'] = $msg;
		$data['vars']['msg'] = $msg;
		$data['page'] = 'welcome';
		$this->load->view('common/layout', $data);	
	}
	
	private function evaluate($values) {
		$score = 0;
		foreach ($values as $val) {
			$score += (int)$val;	
		}
		return $score == 5 ? true : false;
	}
	
	private function dump($array = NULL) {
		echo "<pre>";
		if ($array) print_r($array);
		else print_r($_POST);
		exit;
	}
	
}

/* End of file users.php */
/* Location: ./controllers/users.php */