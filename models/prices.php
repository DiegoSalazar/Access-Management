<?php
class Prices extends Model {

	function Prices() {
		parent::Model();
		$this->days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	}
	
	function displayMemberships($type) {
		$fees = $this->get_membership_fees($type);
		$select = "<select name='membership' id='mem_select'>";
		
		switch ($type) {
			case	'couple':
			  $select .= "<option value='3_Months'>Three Months - $" . $fees['3_Months'] . "</option>'";
			  $select .= "<option value='1_Year'>One Year - $" . $fees['1_Year'] . "</option>'";
        //$select .= "<option value='3_Month_VIP'>Three Month VIP - $" . $fees['3_Month_VIP'] . "</option>'";
        $select .= "<option value='1_Yr_Couples_VIP'>One Year VIP - $" . $fees['1_Yr_Couples_VIP'] . "</option>'";
			break;
			case	'male':
				$select .= "<option value='1_Month'>One Month - $" . $fees['1_Month'] . "</option>'";
				$select .= "<option value='1_Year'>One Year - $" . $fees['1_Year'] . "</option>'";
        $select .= "<option value='1_Yr_Singles_VIP'>One Year VIP - $" . $fees['1_Yr_Singles_VIP'] . "</option>'";
			break;
			case	'female':
				$select .= "<option value='3_Months'>Three Months - $" . $fees['3_Months'] . "</option>'";
        $select .= "<option value='1_Yr_Singles_VIP'>One Year VIP - $" . $fees['1_Yr_Singles_VIP'] . "</option>'";
			break;
		}
		$select .= "</select>";
		return $select;
	}
	
	function update_hours($day_start, $day_end, $night_start, $night_end) {
		for ($i = 0; $i < 7; $i++) {
			$data = array(
				'day_start' => $day_start[$i],
				'day_end' => $day_end[$i],
				'night_start' => $night_start[$i],
				'night_end' => $night_end[$i]
			);
			$this->db->where('day', $this->days[$i])->update('hours', $data);
			$updated[] = $this->db->affected_rows();
		}
		return $updated;
	}
	
	function hours_table() {
		$Q = $this->db->query("SELECT day, day_start, day_end, night_start, night_end FROM hours");
		
		//generate the select boxes for the day and night hours
		$pm_opts = array(); $am_opts = array();
		for ($i = 1; $i <= 12; $i++) {
			$pm_opts += array("{$i}pm" => "{$i}pm");
			$am_opts += array("{$i}am" => "{$i}am");
		}
		
		$this->table->set_template(array('table_open' => '<table id=\'hours_table\' cellspacing=\'0\' cellpadding=\'0\'>', 'row_alt_start' => '<tr class=\'even\'>'));
		$this->table->set_heading('Day', 'Day Hours', 'Night Hours');
		
		foreach ($Q->result() as $r) {
			$this->table->add_row(
				$r->day, 
				form_dropdown('day_start[]', $am_opts, $r->day_start).' to '.form_dropdown('day_end[]', $pm_opts, $r->day_end), 
				form_dropdown('night_start[]', $pm_opts, $r->night_start).' to '.form_dropdown('night_end[]', $am_opts, $r->night_end)
			);	
		}
		
		$table = $this->table->generate();
		$this->table->clear();	
		
		return $table;
	}
	
	function get_memberships_or_door_fees($m_or_df) {
		//we are passing in either 'memberships' or 'door_fees'
		$Q = $this->db->get($m_or_df);
		$table = array();
		
		//if arg is door_fees, 1 of the columns from the db wil be 'day'
		$day_or_membership = 'membership';
		if ($m_or_df == 'door_fees') $day_or_membership = 'day';
		
		if ($Q->num_rows() > 0) {
			$results = $Q->result();
			$this->table->set_template(array('table_open' => '<table id=\''.$m_or_df.'_table\' cellspacing=\'0\' cellpadding=\'0\'>', 'row_alt_start' => '<tr class=\'even\'>'));
			$this->table->set_heading(ucfirst(str_replace('_',' ',$m_or_df)), 'Male', 'Female', 'Couple');
			
			foreach ($Q->result_array() as $result) {
				//create text boxes with the alue filled in with current value
				$m = form_input(array('class' => 'num-input', 'name' => 'male-'.$result[$day_or_membership], 'value' => $result['male']));
				$f = form_input(array('class' => 'num-input', 'name' => 'female-'.$result[$day_or_membership], 'value' => $result['female']));
				$c = form_input(array('class' => 'num-input', 'name' => 'couple-'.$result[$day_or_membership], 'value' => $result['couple']));
				$this->table->add_row(str_replace('_', ' ', $result[$day_or_membership]), $m, $f, $c);
			}
			
			$table = $this->table->generate();
			$this->table->clear();	
		}
		return $table;
	}	
		
	function update_memberships_or_door_fees($m_or_df, $type, $val, $membership) {
		//if arg is door_fees, 1 of the columns from the db wil be 'day'
		$day_or_membership = 'membership';
		if ($m_or_df == 'door_fees') $day_or_membership = 'day';
		
		$this->db->where($day_or_membership,  $membership);
		$this->db->update($m_or_df, array($type => $val));
		return $this->db->affected_rows();
	}
	
	function get_membership_fees($type, $stringify = false) {
		$str = "membership, {$type}";
		$this->db->select($str);
		$Q = $this->db->get('memberships');
		
		$fee_array = array();
		foreach ($Q->result_array() as $fee) {
			if ($stringify) {
				switch ($fee['membership']) {
					case '1_Month':
						$mem = 'one_month';
					break;
					case '3_Months':
						$mem = 'three_months';
					break;
					case '1_Year':
						$mem = 'one_year';
					break;
					case '3_Month_VIP':
						$mem = 'three_month_vip';
					break;
					case '1_Yr_Couples_VIP':
						$mem = 'one_year_couples_vip';
					break;
					case '1_Yr_Singles_VIP':
						$mem = 'one_year_singles_vip';
					break;
				}
			} else $mem = $fee['membership'];
			$fee_array += array($mem => $fee[$type]);
		}
		return $fee_array;	
	}
	
	function get_mem_fee($type, $membership) {
		$mem_fee = $this->prices->get_membership_fees($type);
		return $mem_fee[$membership];
	}
	
	function get_door_fee($type, $force_day = false) {
		$today = date('l'); //Monday, Tuesday etc.
		$hr = date('G'); //24 hr format
		
		$prices = $this->get_prices($type);		
		$hours = $this->day_night_array();
		
		for ($i = 0; $i < 7; $i++) {
			if ($hours['days'][$i] == $today) {
				$index = $i; //to reference the index as it was when the loop broke out
				$d['dco'] = $hours['days_cut_off'][$i];
				$d['nco'] = $hours['nights_cut_off'][$i];
				break;
			}
		}
		
		if ($type == 'couple') {
			return $prices['day'][$index];
		}
		
		list($day['start'], $day['end']) = explode(' to ', $d['dco']);
		list($night['start'], $night['end']) = explode(' to ', $d['nco']);
		
		if ($force_day) return $prices['day'][$index]; // to get night fee - day fee = upgrade fee
		
		if ($hr >= format24hr($day['start']) && $hr < format24hr($day['end'])) {
			$fee = $prices['day'][$index];
		} elseif ($hr <= format24hr($night['end']) || $hr > format24hr($night['start'])) {
			$fee = $prices['night'][$index];	
		} else $fee = 0;
				
		return $fee;
	}
	
	function discounts() {
		//table to display in the club page
		$Q = $this->discounts_query();
		
		$table = "<table id='discounts_table' cellspacing='0' cellpadding='0'>\n";
		$table .= "<tr>\n<th>Discount</th><th colspan='2'>Value</th>\n</tr>\n";
				
		if ($Q->num_rows() > 0) {
			$discounts = $Q->result();
			$Q->free_result(); $i = 0;
			foreach ($discounts as $d) {
				//each discount value is stored as 'operator,XX' where operator is either a minus sign or percent
				//we must split it and form a human friendly value string
				list($operator, $amt) = explode(',',$d->amt);
				$value_str = ($operator == 'percent') ? (htmlentities('%').$amt.' Off') : ('$'.$amt.' Off');
			
			$table .= ($i % 2) ? '<tr class=\'even\'>' : '<tr>';
				$table .= "<td>".$d->desc."</td>\n";
				$table .= "<td>".$value_str."</td>\n";
				$table .= "<td>\n
							<form method='post' action='".base_url()."club/discounts/".$d->id."'>\n
								<div class='del_div' id='user-".$d->id."'>\n
									<input type='submit' title='Delete this discount' name='delete' class='del' value='X' />\n
								</div>\n
							</form>
						</td>\n
					</tr>\n";
				$i++;
			}
			$table .= '</table>';
			
			return $table;
		}
	}
	
	function discount_opts() {
		//discounts to choose when checking out
		$Q = $this->discounts_query();
		
		if ($Q->num_rows() > 0) {
			$discounts = $Q->result();
			$Q->free_result();
			$i = 1; $discount_opts = '';
			foreach ($discounts as $d) {
				$discount_opts .= "<li>\n<label for='check_".$i."'>\n" . $d->desc ."</label>\n<input type='checkbox' id='check_".$i."' name='discounts[]' value='" . $d->amt . "\' />\n</li>\n";
				$i++;
			}
			return $discount_opts;
		}
	}
	
	function get_dropdown($field, $table) {
		$fields = $this->db->distinct($field)->get($table)->result();
		foreach ($fields as $key => $val) {
			$opts[$val->$field] = str_replace('_',' ',ucwords($val->$field)).' ';	
		}
		$select = form_dropdown($field, $opts);
		return $select;
	}
	
	function create_discount($desc, $operator, $amount) {
		$this->db->insert('discounts', array('desc' => clean($desc), 'operation' => $operator, 'amount' => $amount));	
		return $this->db->insert_id();
	}
	
	function discounts_query() {
		return $this->db->query("SELECT CONCAT(operation,',',amount) amt, discounts.desc, discounts.id FROM discounts ORDER BY operation ASC");
	}
	
	function delete_discount($id) {
		$this->db->delete('discounts', array('id' => $id));
		return $this->db->affected_rows();
	}
	
	function displayPrices($type) {
		switch ($type) {
			case	'couple':
				//array index is day of week; [0] => mon, [1] => tues, etc...
				$prices = $this->get_prices('couple');
 				$prices_table = $this->make_table($prices, 'couple');
			break;
			case	'male':
				$prices = $this->get_prices('male');
				$prices_table = $this->make_table($prices, 'male');
			break;
			case	'female':
				$prices = $this->get_prices('female');
				$prices_table = $this->make_table($prices, 'female');
			break;
		}
		return $prices_table;
	}
	
	function get_prices($type) {
		$Q = $this->db->select($type)->get('door_fees');
		
		//array index is day of week; [0] => monday's price, [1] => tues, etc...
		foreach ($Q->result() as $p) {
			list($day[], $night[]) = explode(',', $p->$type);	
		}
		
		return array('day' => $day, 'night' => $night);
	}
	
	function get_hours($t) {
		//select string should look like 'day_start, day_end'
		$str = "{$t}_start, {$t}_end";
		$this->db->select($str);
		$Q = $this->db->get('hours');
		
		$hours = array();
		foreach ($Q->result_array() as $hr) {
			$hours[] = $hr[$t . '_start'] . ' to ' . $hr[$t . '_end'];	
		}
		
		return $hours;
	}
	
	function day_night_array() {
		$day_hour = $this->get_hours('day');
		$night_hour = $this->get_hours('night');
		return array('days_cut_off' => $day_hour, 'nights_cut_off' => $night_hour, 'days' => $this->days);
	}
	
	private function make_table($prices, $type) {
		$day_hour = $this->get_hours('day');
		$night_hour = $this->get_hours('night');
		
		$this->table->set_template(array('table_open' => '<table class=\'prices_table\'>', 'row_alt_start' => '<tr class=\'even\'>'));
		
		if ($type == 'couple') {
			$this->table->set_heading('Couple\'s Day Fee', 'Night Fee');
			for ($i = 0; $i < 7; $i++) {
				$this->table->add_row('<span class=\'dcell\'>' . $this->days[$i] . '</span> ' . $day_hour[$i] . ' - $' . number_format($prices['day'][$i]), $night_hour[$i] . ' - $' . number_format($prices['night'][$i]));	
			}
		} elseif ($type == 'male') {
			$this->table->set_heading('Gentlemen\'s Day Fee', 'Night Fee');
			for ($i = 0; $i < 7; $i++) {
				$this->table->add_row('<span class=\'dcell\'>' . $this->days[$i] . '</span> ' . $day_hour[$i] . ' - $' . number_format($prices['day'][$i]), $night_hour[$i] . ' - ' . ($prices['night'][$i] != 0 ? '$'.number_format($prices['night'][$i]) : 'N/A') );	
			}
		} elseif  ($type == 'female') {
			$this->table->set_heading('Women\'s Day Fee', 'Night Fee');
			for ($i = 0; $i < 7; $i++) {
				$this->table->add_row('<span class=\'dcell\'>' . $this->days[$i] . '</span> ' . $day_hour[$i] . ' - $' . number_format($prices['day'][$i]), $night_hour[$i] . ' - $' . number_format($prices['night'][$i]));	
			}
		}
		$table =  $this->table->generate();
		$this->table->clear();
		return $table;
	}
	
	private function dump($array = NULL, $exit = true) {
		echo "<pre>";
		if ($array) print_r($array);
		else print_r($_POST);
		if ($exit) exit;
	}
	
}
//END users model