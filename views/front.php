<img id="top" src="<?php echo base_url(); ?>images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Deenie's Hideaway - A Private Swingers Club</a></h1>
		<form id="form_57965" class="appnitro"  method="post" action="<?php echo base_url(); ?>front/">
		<div class="form_description">
			<h2>Deenie's Hideaway - A Private Swingers Club</h2>
			<div class="short">
                <p>Application For Membership</p>
                <p>Please Read All The Club Rules</p>
            	</div>
		</div>	
		
		<div class="msg">
		  <?php if($this->session->flashdata('msg')) echo $this->session->flashdata('msg'); ?>
          </div>
							
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Club Rules </label>
		<div>
<pre id="club_rules">
1.  The purchase or sale of alcoholic beverages at Deenie's Hideaway is strictly 
    prohibited.
2.  Our conduct will be lawful and no lewd or lascivious acts will be allowed.
3.  No picture phones or cameras of any kind allowed inside and all bags will be 
    inspected.
4.  No illegal drugs, no gambling, no prostitution, and no one under 21 allowed.
5.  Members will help control club operations.
6.  Members will not exceed 2100 persons.
7.  Only 210 Members will be allowed in at one time.
8.  Long Term Couples Charter Membership: $3000 + tax yearly.
9.  Long term Singles Charter Membership: $5000 + tax yearly.
10. Membership Committee will approve long term Memberships.
11. Membership denied unless you score 25 points.
</pre> 
		</div>
        
        	  <div class="msg_wrapper">
		  <?php if (isset($msg)) echo $msg; ?>
            </div>
        
		</li>		<li id="li_2" >
			<label class="description" for="element_2">Membership Type </label>
			<div>
			<select class="element select medium" id="element_2" name="type"> 
			  <option value="none" selected="selected">::Select::</option>
			  <option value="couple" >Couple</option>
			  <option value="female" >Single Female</option>
			  <option value="male" >Single Male</option>
			</select>
			</div> 
		</li>
        	<li id="li_3">
		<label class="description" for="element_3">Do You Agree To The Rules? </label>
		<span>
		  <input id="element_3_1" name="agree" class="element radio" type="radio" value="yes" />
            <label class="choice" for="element_3_1">Yes!</label>
            <input id="element_3_2" name="agree" class="element radio" type="radio" value="no" />
            <label class="choice" for="element_3_2">No</label>

		</span> 
		</li>
			
		<li class="buttons">
		    <input type="hidden" name="form_id" value="57965" />
			<input id="saveForm" class="button_text" type="submit" name="submit" value="Next" />
		</li>
       </ul>
	</form>	