<?php
// Utility Functions
	function format24hr($time) {
		//time string must look like 4am or 5pm	
		if (strpos($time, 'am')) {
			$hr_num = substr($time, 0, strpos($time, 'am'));
			return $hr_num;
		} else {
			$hr_num = substr($time, 0, strpos($time, 'pm'));
			return $hr_num + 12;
		}
	}
	
	function echoItems($array) {
		if (is_array($array)) {
			foreach ($array as $item) {
				echo $item."\n";
			}
		}
	}
	
	function clean($me) {
		return mysql_real_escape_string(trim($me));
	}
?>