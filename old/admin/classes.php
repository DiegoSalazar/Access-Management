<?php
/****************************************************************************
Diego E. Salazar
Grey Robot, Inc. 2008

	Class FeeCalculator: Calculates prices based on following criteria:
	Version: 1.0b, Oct 3, 2008
	
	Singles:
	*************************************
	Marja Madness
	$190.00 Now Only: $120.00
	
	Monday-Friday
	9AM - 5PM
	$20.00 Daily Membership Fee
	$50.00 Door Fee
	$50.00 Upgrade Fee applies after 5pm
	
	Saturday
	9AM - 5PM
	$20.00 Daily Membership Fee
	$50.00 Door Fee
	Note: Saturday night is for couples only. Select Single males will be permitted on special occasion only.
	
	Saturday Special Occasion Price for Select Single Males
	8PM – 9AM
	Call the Club for Prices
	
	Monthly Membership Fees for Single Men
	One Month Membership Fee - $200.00 
	9am - 5pm
	$50.00 Door Fee
	$30.00 Upgrade Fee applies after 5pm
	$5,000.00 One Year VIP Charter 
	
	Couples:
	***************************************
	September and October Special Pricing!

	Monday-Thursday
	9AM – 4AM!
	$20.00 Includes Door & Membership Fees.
	
	Fridays
	Open 24hrs!
	$20.00 Includes Door & Membership
	Fees before 10PM.
	Arrive after 10PM & Regular Pricing Applies
	$80.00 - w/o Membership
	$50.00 - with Membership
	
	Saturdays
	Open 24hrs!
	$80.00 - w/o Membership
	$50.00 - with Membership
	Note: Saturday is for couples only. Select Single males will be permitted on special occasion.
	
	Sundays
	Open 9AM - 4AM!
	$80.00 - w/o Membership
	$50.00 - with Membership
	
	Membership Fees
	3 Month Membership $150.00
	1 Year Membership$200.00
	
	$3,000.00 One Year VIP Charter

**************************************************************************/

class FeeCalculator {
	var $day;
	var $hr;
	var $mem_type;
	var $mem_num;
	var $mem_length;
	var $gender;
	var $prices;
	
	//Constructor
	function FeeCalculator() {
		$this->day = date("l"); //Full text day "Monday, Tuesday, etc"
		$this->hr = date("G");  //24 Hour, just the hour, no leading zero
		$this->prices = array();
	}
	
	/*
	Call the method below to return calculated fees. If the member is new then replace $num with "new";
	Example:
	$feeCalc = new FeeCalculator;
	$fee = $feeCalc->forWhom($type, $length, $num, $gender);
	echo $fee;
	*/
	function forWhom($mem_type, $mem_length, $mem_num, $gender = "na") {
		$this->mem_type = $mem_type;
		$this->mem_length = $mem_length;
		$this->mem_num = $mem_num;
		$this->gender = $gender;
		$this->switcher();
		return $this->prices;
	}
	
	//switch based on membership status, new or current
	private function switcher() {
		if ($this->mem_type == "single" && $this->mem_type == "female") {
			$this->prices['door_fee'] = 5;
			$this->prices['mem_fee'] = 0;
		}
		else {
			if ($this->mem_num == "new") {
				$this->newMember();
			}
			else {
				$this->currentMember();
			}
		}
	}
	
	private function newMember() {
		//Pick the fee calculator for the current day based on the member type
		if ($this->mem_type == "single") {
			switch ($this->day) {
				case "Monday": $this->mondayNewMaleFee(); break;
				case "Tuesday": $this->tuesdayNewMaleFee(); break;
				case "Wednesday": $this->wednesdayNewMaleFee(); break;
				case "Thursday": $this->thursdayNewMaleFee(); break;
				case "Friday": $this->fridayNewMaleFee(); break;
				case "Saturday": $this->saturdayNewMaleFee(); break;
				case "Sunday": $this->sundayNewMaleFee(); break;
			}
		}
		elseif ($this->mem_type == "couple") {
			switch ($this->day) {
				case "Monday": $this->mondayNewCoupleFee(); break;
				case "Tuesday": $this->tuesdayNewCoupleFee(); break;
				case "Wednesday": $this->wednesdayNewCoupleFee(); break;
				case "Thursday": $this->thursdayNewCoupleFee(); break;
				case "Friday": $this->fridayNewCoupleFee(); break;
				case "Saturday": $this->saturdayNewCoupleFee(); break;
				case "Sunday": $this->sundayNewCoupleFee(); break;
			}
		}
	}
	
	private function currentMember() {
		//Pick the fee calculator for the current day based on the member type
		if ($this->mem_type == "single") {
			switch ($this->day) {
				case "Monday": $this->mondayMaleFee(); break;
				case "Tuesday": $this->tuesdayMaleFee(); break;
				case "Wednesday": $this->wednesdayMaleFee(); break;
				case "Thursday": $this->thursdayMaleFee(); break;
				case "Friday": $this->fridayMaleFee(); break;
				case "Saturday": $this->saturdayMaleFee(); break;
				case "Sunday": $this->sundayMaleFee(); break;
			}
		}
		elseif ($this->mem_type == "couple") {
			switch ($this->day) {
				case "Monday": $this->mondayCoupleFee(); break;
				case "Tuesday": $this->tuesdayCoupleFee(); break;
				case "Wednesday": $this->wednesdayCoupleFee(); break;
				case "Thursday": $this->thursdayCoupleFee(); break;
				case "Friday": $this->fridayCoupleFee(); break;
				case "Saturday": $this->saturdayCoupleFee(); break;
				case "Sunday": $this->sundayCoupleFee(); break;
			}
		}
	}
	
	//New Single Male Fee Calculators
	function mondayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect sunday late night fee
				$this->prices['door_fee'] = 120;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
				$this->prices['mem_fee'] = 20;
			}
			if ($this->hr >= 17) { //add upgrade fee
				$this->prices['door_fee'] = 100;
				$this->prices['mem_fee'] = 20;
			}
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function tuesdayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 20;
			if ($this->hr < 9) { //reflect monday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
			}
			if ($this->hr >= 17) { //add upgrade fee
				$this->prices['door_fee'] = 100;
			}
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function wednesdayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 20;
			if ($this->hr < 9) { //reflect tuesday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
			}
			if ($this->hr >= 17) { //add upgrade fee
				$this->prices['door_fee'] = 100;
			}
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function thursdayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 20;
			if ($this->hr < 9) { //reflect wednesday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
			}
			if ($this->hr >= 17) { //add upgrade fee
				$this->prices['door_fee'] = 100;
			}
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function fridayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 20;
			if ($this->hr < 9) { //reflect thursday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
			}
			if ($this->hr >= 17) { //add upgrade fee
				$this->prices['door_fee'] = 100;
			}
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function saturdayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			if ($this->hr < 9) { //reflect friday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
				$this->prices['mem_fee'] = 20;
			}
			else $this->prices['door_fee'] = "?"; //must call for pricing after 8pm
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
	
	function sundayNewMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 120;
			if ($this->hr < 9) { //reflect saturday late night, must call for fee
				$this->prices['door_fee'] = "?";
			}		
			else $this->prices['door_fee'] = 120;
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
		
		//called by day calculators (above)
		//New Male month and year fee calculators
		function newMaleOneMonthFee() {
			$this->prices['mem_fee'] = 200;
			$this->prices['door_fee'] = 50;	
			if ($this->hr < 9 || $this->hr >= 17) {
				$this->prices['door_fee'] = 80; //add upgrade fee
			}	
		}
		
		function newMaleOneYearVIPFee() {
			$this->prices['mem_fee'] = 5000;
			$this->prices['door_fee'] = 0;
		}
	
/*
Current Single Male Fee Calculators
*/
	function mondayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect sunday late night fee
				$this->prices['door_fee'] = 80;
			}
			else {
				$this->prices['door_fee'] = 50;
				if ($this->hr >= 17) { //add upgrade fee
					$this->prices['door_fee'] = 100;
				}
			}	
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
		
	function tuesdayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect monday late night fee
				$this->prices['door_fee'] = 100;
			}
			else {
				$this->prices['door_fee'] = 50;
				if ($this->hr >= 17) { //add upgrade fee
					$this->prices['door_fee'] = 100;
				}
			}	
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
	
	function wednesdayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect tuesday late night fee
				$this->prices['door_fee'] = 100;
			}
			else {
				$this->prices['door_fee'] = 50;
				if ($this->hr >= 17) { //add upgrade fee
					$this->prices['door_fee'] = 100;
				}
			}	
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
	
	function thursdayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect wednesday late night fee
				$this->prices['door_fee'] = 100;
			}
			else {
				$this->prices['door_fee'] = 50;
				if ($this->hr >= 17) { //add upgrade fee
					$this->prices['door_fee'] = 100;
				}
			}	
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
	
	function fridayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect thursday late night fee
				$this->prices['door_fee'] = 100;
			}
			else {
				$this->prices['door_fee'] = 50;
				if ($this->hr >= 17) { //add upgrade fee
					$this->prices['door_fee'] = 100;
				}
			}	
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
	
	function saturdayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect friday late night fee
				$this->prices['door_fee'] = 100;
			}		
			elseif ($this->hr >= 9 && $this->hr	< 17) {
				$this->prices['door_fee'] = 50;
			}
			else $this->prices['door_fee'] = "?"; //must call for pricing after 8pm
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->maleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->maleOneYearVIPFee();			
			}
		}
	}
	
	function sundayMaleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 9) { //reflect saturday late night, must call for fee
				$this->prices['door_fee'] = "?";
			}		
			else $this->prices['door_fee'] = 80;
		}
		else {
			if ($this->mem_length == "One Month") {
				$this->newMaleOneMonthFee();	
			}
			elseif ($this->mem_length == "One Year VIP") {
				$this->newMaleOneYearVIPFee();			
			}
		}
	}
		
		//called by day calculators (above)
		//Current member Male month and year fee calculators
		function maleOneMonthFee() {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 50;	
			if ($this->hr < 9 || $this->hr >= 17) {
				$this->prices['door_fee'] = 80; //add upgrade fee
			}	
		}
		
		function maleOneYearVIPFee() {
			$this->prices['mem_fee'] = 5000;
			$this->prices['door_fee'] = 0;
		}
		
	//New Couples Fee Calculators
	function mondayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 4) { //reflect sunday late night fee
				$this->prices['door_fee'] = 80;
			}
			else $this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 150;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 200;				
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function tuesdayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 150;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 200;				
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function wednesdayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 150;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 200;				
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function thursdayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 150;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 200;				
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function fridayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 22) {	
				$this->prices['door_fee'] = 20;
			}
			else $this->prices['door_fee'] = 80;
		}
		elseif ($this->mem_length == "Three Months") {
			if ($this->hr < 22) {
				$this->prices['door_fee'] = 0;
				$this->prices['mem_fee'] = 150;
			} else $this->newCoupleThreeMonthFee();			
		}
		elseif ($this->mem_length == "One Year") {
			if ($this->hr < 22) {
				$this->prices['door_fee'] = 0;
				$this->prices['mem_fee'] = 150;
			} else $this->newCoupleOneYearFee();				
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function saturdayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 80;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->newCoupleThreeMonthFee();			
		}
		elseif ($this->mem_length == "One Year") {
			$this->newCoupleOneYearFee();			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
	
	function sundayNewCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 80;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->newCoupleThreeMonthFee();			
		}
		elseif ($this->mem_length == "One Year") {
			$this->newCoupleOneYearFee();			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->newCoupleOneYearVIPFee();			
		}
	}
		
		//called by day calculators above
		//New Couple month and year fee calculators
		function newCoupleThreeMonthFee() {
			$this->prices['mem_fee'] = 150;
			$this->prices['door_fee'] = 50;
		}
		
		function newCoupleOneYearFee() {
			$this->prices['mem_fee'] = 200;
			$this->prices['door_fee'] = 50;
		}
		
		function newCoupleOneYearVIPFee() {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 3000;
		}
	
	//Current Couples Fee Calculators
	function mondayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 4) { //reflect sunday late night fee
				$this->prices['door_fee'] = 50;
			} else $this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function tuesdayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function wednesdayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function thursdayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function fridayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 20;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function saturdayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			if ($this->hr < 22) {	
				$this->prices['door_fee'] = 20;
			}
			else $this->prices['door_fee'] = 50;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;		
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;			
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;			
		}
	}
	
	function sundayCoupleFee() {
		if ($this->mem_length == "One Day") {
			$this->prices['mem_fee'] = 0;
			$this->prices['door_fee'] = 80;
		}
		elseif ($this->mem_length == "Three Months") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;
		}
		elseif ($this->mem_length == "One Year") {
			$this->prices['door_fee'] = 50;
			$this->prices['mem_fee'] = 0;
		}
		elseif ($this->mem_length == "One Year VIP") {
			$this->prices['door_fee'] = 0;
			$this->prices['mem_fee'] = 0;	
		}
	}
} // END class FeeCalculator

class MemSeriesNumberGenerator {
	
	/* 
	returns the next Member Series Number
	example: series_num = E0501;
			returns E0502;
	if the number is X1000; where X is any letter,
	the next alphabetical letter and 0001 is returned
	example: series_num = F1000;
			returns G0001;
			
	EXAMPLE USAGE:
		$ng = new MemSeriesNumberGenerator;
		$mem_series_num = "E0501"; //fetched from db
		$new_num = $ng->nextMemSeries();
		echo $new_num;
		// prints: "E0502"
	*/
	
	var $currentSeries;
	var $newNum;
	
	//constructor, sets the $currentSeries public property to the value fetched by getCurrentSeries()
	//then sets the newNum property to the next consecutive member series number
	function MemSeriesNumberGenerator() {
		$this->currentSeries = $this->getCurrentSeries();
		$this->newNum = $this->nextMemSeries();
	}	
	
	public function getCurrentSeries() {
		$sql = "SELECT mem_series FROM members WHERE mem_series != 'none' ORDER BY member_num DESC LIMIT 1";
		$result = mysql_query($sql) or die("Get Current Series Query Failed. " . mysql_error());
		$set = mysql_fetch_assoc($result);
		return $set['mem_series'];
	}
	
	public function getNextChar() {
		//find the letter in the number and put it in $f
		preg_match_all('/^[A-Z]/', $this->currentSeries, $f);
		//get the actual result which has been buried in a multidimensional array in $f
		//turn it into an ASCII decimal code
		//also typecast it into an integer so we can increment it
		(int)$f = ord($f[0][0]);
		//this is where we increment
		$n = $f + 1;
		//we convert the incremented number into the letter it represents in ASCII and return it 
		return chr($n);
	}
	
	public function getNextNum() {
		//strip the letter from the series_num and typecast it into an integer
		(int)$e = preg_replace('/^[A-Z]/', '', $this->currentSeries);
		//increment it
		$e++;
		//reset it if it passes 1000
		if ($e > 1000) { $e = "001"; }
		return $e;
	}
	
	public function nextMemSeries() {
		//start by getting the letter in the series_num
		preg_match_all('/^[A-Z]/', $this->currentSeries, $chr);
		//take it out of the array
		$chr = $chr[0][0];
		//get the incremented number 
		$num = $this->getNextNum();
		//if the number had to be reset, we now need to go to the next letter
		if ($num == "001") {
			$chr = $this->getNextChar();
		}
		//put the new letter and number together
		//lets compensate for typecasting stripping 0s from the number 
		//unless the number reached 1000, then dont include a zero in between the letter and the number
		if ($num < 1000) {
			$next = $chr."0".$num;
		} else $next = $chr . $num;
		return $next;
	}
	
} // END class MemSeriesNumberGenerator

?>