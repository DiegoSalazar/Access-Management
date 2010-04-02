$(function(){
	//here we hold the page specific code				  
	mySuperObject = new GreyRobot.SuperObject;
	
	//a variable with the same name as a superobject method is placed in the head of each specific page
	mySuperObject[GreyRobot.page]();
			 
});

GreyRobot.SuperObject = function(){};							  
GreyRobot.SuperObject.prototype = {
	common : function(){ 
		var d = new Date();
		var maxYear = d.getFullYear() - 21;
	
		var opts = { 
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: '1910:'+maxYear,
			defaultDate: '-21y',
			buttonImage: GreyRobot.baseUrl+'images/datepicker.gif',
			buttonImageOnly: true
		};
		$(".datefield").datepicker(opts); 
		
		var annivOpts = { 
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: '1930:'+d.getFullYear(),
			defaultDate: '-2y',
			buttonImage: GreyRobot.baseUrl+'images/datepicker.gif',
			buttonImageOnly: true
		};
		$(".annivfield").datepicker(annivOpts);
		
	},
	front : function(){
		this.common();
		
		$("#saveForm").click(function(){
			//validate front form
			var error = '';
			var type = $("select[name=type]").val();
			if (!type || type == 'none') error += "<p>Please choose a membership type to proceed.</p>";
			
			var agree = $("input[@name='agree']:checked").val();
			if (!agree || agree == 'no') error += "<p>You have to agree with the club rules to be a member.</p>";
			
			if (error != '') {
				$(".msg_wrapper").html(error);
				return false;	
			}					
		});
			
	},
	new_member : function(){
		this.common();
		
		$("#saveForm").click(function(){
			//validation
			var error = '';
			var fname = $("input[name=fname]").val();
			if (!fname || fname == '') error += "Please Provide Your First Name.\n";
			
			var lname = $("input[name=lname]").val();
			if (!lname || lname == '') error += "Fill in Your Last Name.\n";
			
			var bday = $("input[name=bday]").val();
			if (!bday || bday == '') error += "Type in a Valid Date of Birth.\n";
			
			if ($("input[name=email]").val() != '') {
				var email = $("input[name=email]").val();
				if (!email || (email.indexOf('@') <= 0 || email.indexOf('.') < 3)) error += "Please Type in a Valid Email.\n";	
			}			
			
			if (GreyRobot.type == 'couple') {
				var pfname = $("input[name=pfname]").val();
				if (!pfname || pfname == '') error += "Enter Your Partner's First Name.\n";
				
				var plname = $("input[name=plname]").val();
				if (!plname || plname == '') error += "Please Enter Your Partner's Last Name.\n";
				
				var pbday = $("input[name=pbday]").val();
				if (!pbday || pbday == '') error += "Please Provide Your Partner's Date of Birth.\n";
				
				if ($("input[name=pemail]").val() != '') {
					var pemail = $("input[name=pemail]").val();
					if (!pemail || (pemail.indexOf('@') <= 0 || pemail.indexOf('.') < 3)) error += "Please Type in a Valid Email for Your Partner.\n";	
				}
			}
			
			var score = 0;
			$("input", ".score_fields").each(function(){
				if ($(this).is(":checked")) score += parseInt($(this).val());					  
			});
			
			if (!score || score < 5) error += "Say no to the questions and agree to the rules to continue.\n";
			
			if (error != '') {
				alert(error);
				return false;	
			}
			//END validation
			
			//off to codeigniter...
		});
		
		//resets the page after 7 minutes
		var redirectDelay = function(action, delay){ 
			return setTimeout(action, delay); 
		}	
		var redirect = function(){
			if (confirm("Start Over?")) {
				window.location = GreyRobot.baseUrl; 
			} else { //keep asking them if they hit cancel
				redirectDelay(redirect, 420000);
			}
		}
		redirectDelay(redirect, 420000);
	},
	welcome : function(){
		//resets the page after 7 seconds
		setTimeout(function(){ window.location = GreyRobot.baseUrl; }, 7000);	
	},
	club: function(){
		this.common();
		var that = this;
		
		//if user has just logged in, slide the whole container open, otherwise just show it
		var auth = $("#authenticated");
		if (GreyRobot.authenticated == 'true' && GreyRobot.logging_in == 'true') auth.slideDown(2800);
		else if (GreyRobot.authenticated == 'true' && GreyRobot.logging_in == 'false') auth.show();
		
		var loader = $("#loader", "#club"); //animated gif
		
		var latest_member_id = $("tr.table_row:first", "#members_table tbody").attr('id').replace('member_row-','');
				
		$('#filter', '#search-div').autocomplete(GreyRobot.baseUrl+'ac.php');
		
	//Event Listeners
		//binds the delete event to the button in either the #staff_table, #members_table
		var bindTableButtonEvent = function(table){ 
			$("input[name=delete]", "#"+table+"_table").click(function(){ 
				var $this = $(this);
				var parent = $this.parent();		
				var id = parent.attr('id').replace('user-','');	
				var row = parent.parent().parent().parent();
				
				if (table == 'staff') {
					var name = parent.parent().parent().prev().prev().text().replace("\n",'').replace("\n",'');
					
				} else if (table == 'members') {
					latest_member_id = $("tr.table_row:first", "#members_table tbody").attr('id').replace('member_row-','');
					var name = parent.parent().parent().prev().prev().text() != '' ? parent.parent().parent().prev().prev().text(): parent.parent().prev().prev().text();
					
				} else if (table == 'discounts') {
					var name = parent.parent().parent().prev().prev().text() != '' ? parent.parent().parent().prev().prev().text() : parent.parent().prev().prev().text();
				}
				
				if (confirm("Delete " + name + "?")) { 
					loader.fadeIn(600); var alerted = false; //the ajax alert happens multiple times for some reason
					$.post(GreyRobot.baseUrl + 'club/'+table+'/' + id, { 'delete': 'X', 'ajax': true }, function(data){
						if (data.status == 'success' && !alerted) {
							row.fadeOut(600, function(){ 
								$(this).remove(); //reapply alternating colors
								$("tr", "#"+table+"_table").removeClass('even');
								$("tr:even", "#"+table+"_table").addClass('even');
							});
							alerted = true;
						} 
						ajax_alert(data, loader);
					}, 'json');
				} 
				return false;
			});
		}
		
		var memberFormEvent = function(){
			$("#update", "#member_form").click(function(){
				$('#updating').fadeIn(600);	
				var form_data = $("#member_form").serialize();
				
				$.ajax({
					type: "POST",
					url: GreyRobot.baseUrl + 'club/members',
					data: form_data,
					dataType: 'json',
					success: function(data){
						ajax_alert(data, $('img', '#updating'));
						$('#notice').remove();
						$('#updating').prepend('<span id=\'notice\'>'+data.text+'</span>').hide().fadeIn(600);
					}
				});				
				return false;
			});	
		}
		
		var memberLinkEvent = function(){
			$(".member_link").click(function(e){ //get member info and populate member_form fields
				$("#member_form").hide();
				var $this = $(this);
				
				//we use either links or the search form to pull up the member_info
				if (e.target.tagName == 'A') {
					var id = $this.attr('id').replace('member-','');
				} else {
					//the value of the autocompleted text field whould look lik name-id, ex: Dan Rather-98
					var input = $this.parent().prev().children('input');
					var id = input.val().split('-')[1];	
					input.val('');
				}
								
				$("#member_loader").fadeIn(); //loading gif inside the member_info_thickbox
				
				$.post(GreyRobot.baseUrl+'club/members/'+id, { 'view': 1 }, function(data){
					var obj = data[0]; //for some reason the json object is returned in an array?
					$("#member_loader").fadeOut(600);
					$('#notice').remove();
					
					var tb_h ='500px', tb_top = '12%'; 	
					//adjust window height if couple
					if (obj.pfname != null || obj.plname != null) {
						var tb_h ='850px', tb_top = '12%'; 	
					}
					
					$("#TB_window").animate({ 'height': tb_h , 'top': tb_top}, 600, function(){
						$("#TB_ajaxContent", "#TB_window").css('height', '92%');
						$("#member_form").fadeIn(600, function(){ 
							//populate the form with the json object						
							if (obj.pfname != null || obj.plname != null) $("#partner-fields").show();
							else $("#partner-fields").hide();
							
							$('a.checkin', this).attr('id', 'member-'+obj.member_num);
							
							//loop over the returned data and set the value of the corresponding form field
							for (var i in obj) {
								if ($("select[name="+i+"]", this).length) {
									select_option(i, obj[i]);	
								} else if ($("textarea[name="+i+"]", this).length) {
									//var str = obj['by_username'] + " on " + obj['created_at'] + ': ' + obj[i];
									$("textarea[name="+i+"]", this).val(obj[i]);
								} else {
									$("input[name="+ i +"]", this).val(obj[i]);
								}
							}
							
							$("option", "select[name=memberships_select]").each(function(){
								var s = $(this);
								if (s.val() == obj.membership) s.attr('selected', 'selected');
								else s.attr('selected', '');
							});
							
							$("option", "select[name=status_select]").each(function(){
								var s = $(this);
								if (s.val() == obj.status) s.attr('selected', 'selected');
								else s.attr('selected', '');
							});
						
						});	
						memberFormEvent();
					});	
					
				}, 'json');
				
				//get history html
				$.post(GreyRobot.baseUrl+'club/get_member_history/'+id, { 'get': 1 }, function(html, status){
					var history = $("#history", "#member_form");
					if (status == 'success') {
						if (!html || html == '') {
							history.text('No history.');
							$("#history").css('height', '80px');
						} else {
							var table = $(html);
							history.html(table);	
							var td = $('tbody', table).children('tr').children('td');
							td.eq(0).css('width', '128px');
							td.eq(1).css('width', '65px');
							td.eq(2).css('width', '105px');
							td.eq(3).css('width', '65px');
							td.eq(4).css('width', '70px');
							
						}
					} else history.text('Error loading history.');
				});
			});
		}
		
		var memberCheckinButton = function(row) {
			var context = row || '#members';
			$(".row-btn", context).click(function(){
				var mem_num = $(this).attr('id').replace('member-', '');
				var type = mem_num.substr(0, 1).toLowerCase();
				
				if (type == 'c') { //couple
					$('#small_opts').show();
					$('input[name=checkin_member_type]', '#small_opts').attr('checked', false);
				} else {
					$('#small_opts').hide();	
				}
				$("input[name=member_num]", "#checkin_form").val(mem_num);
			});
		}
		
		//function to loop, updates the member list when a new member signs up
		var member_list_updater = function(){
			var alerted = false;
			$.post(GreyRobot.baseUrl+'club/new_member_check/'+latest_member_id, {}, function(data){
				if (data.name && (data.id > latest_member_id)) { 
					latest_member_id = data.id;
					
					var cells = "<td class='id'>"+data.member_num+"</td>\n";
					   cells += "<td class='name'>\n";
					   cells += "<a id='member-"+data.id+"' title=\"View/Edit This Account\" class='thickbox member_link' href='#TB_inline?height=100&width=500&inlineId=member_info_thickbox'>"+data.name+"</a></td>\n";
					   cells += "<td class='checkin-col'>\n";
					   cells += "<a class='thickbox row-btn' id='member-"+data.member_num+"' href='#TB_inline?height=350&width=400&inlineId=checkin_thickbox&modal=true'>O</a></td>\n";
					   cells += "<td class='del-row'>\n<form method='post' action='"+GreyRobot.baseUrl+"club/members/"+data.id+"'>\n";
					   cells += "<div class='del-div' id='user-"+data.id+"'>\n";
					   cells += "<input class='btn del' name='delete' value='X' title='Delete this member' type='submit'>\n";
					   cells += "</div>\n</form>\n</td>\n";
					
					var row = $("<tr class='table_row' id='member_row-"+data.id+"'>"+cells+"</tr>");
					
					addColoredRow('members', row);
					
					memberCheckinButton(row);
					memberLinkEvent();
					tb_init('a.thickbox');
					bindTableButtonEvent('members', loader);
				}
				if (!alerted) {
					ajax_alert(data, loader); //also fadesout the loader
					alerted = true;
				}
			}, 'json');
		}
		
	//check for new members every 10 seconds
	var timer = setInterval(member_list_updater, 10000);
	
	
		var checkin_box = $("#checkin_thickbox");
		var checkin_box_html = checkin_box.html();
	
		var checkinEvent = function(){
			$("#go").click(function(){
				var error = '';
				
				var mem_num = $('#member_num-field', '#checkin_form').val();
				if (!mem_num || mem_num == '') error += 'Enter a Member Number\n';
				
				var staff = $("#staff_list", '#checkin_form').val();
				if (!staff || staff == '') error += 'Choose your name from the staff list\n';
				
				if (error != '') {
					alert(error);
					return false;
				}
				loader.fadeIn(600);
				
				var form_data = $("#checkin_form").serialize();
				
				$.ajax({
					type: "POST",
					url: GreyRobot.baseUrl + 'club/checkin',
					data: form_data,
					dataType: 'json',
					success: function(data){
						if (data.status == 'success') {
							var form = $("#checkin_form");
							
							var inputs = "<input type='hidden' name='id' value='"+data.id+"' />";
							inputs += "<input type='hidden' name='name' value='"+data.name+"' />";
							inputs += "<input type='hidden' name='door_fee' value='"+data.door_fee+"' />";
							inputs += "<input type='hidden' name='discounts' value='"+data.discounts+"' />";
							inputs += "<input type='hidden' name='mem_fee' value='"+data.mem_fee+"' />";
							inputs += "<input type='hidden' name='total' value='"+data.total+"' />";
							inputs += "<input type='hidden' name='raw_door_fee' value='"+data.raw_door_fee+"' />";
							inputs += "<input type='hidden' name='staff' value='"+data.staff+"' />";
							inputs += "<input type='hidden' name='status' value='"+data.mem_status+"' />";
							inputs += "<input type='hidden' class='memfee' name='one_month' id='one_month' value='"+data.memfees.one_month+"' />";
							inputs += "<input type='hidden' class='memfee' name='three_months' id='three_months' value='"+data.memfees.three_months+"' />";
							inputs += "<input type='hidden' class='memfee' name='one_year' id='one_year' value='"+data.memfees.one_year+"' />";
							inputs += "<input type='hidden' class='memfee' name='three_month_vip' id='three_month_vip' value='"+data.memfees.three_month_vip+"' />";
							inputs += "<input type='hidden' class='memfee' name='one_year_couples_vip' id='one_year_couples_vip' value='"+data.memfees.one_year_couples_vip+"' />";
							inputs += "<input type='hidden' class='memfee' name='one_year_singles_vip' id='one_year_singles_vip' value='"+data.memfees.one_year_singles_vip+"' />";
							
							if (data.mem_status == 'expired') {
								var renew_opts = "<label for='one_month'>One Month: </label><input type='radio' name='membership' id='one_month' value='1_Month' />";	
								renew_opts += " <label for='three_months'>Three Months: </label><input type='radio' name='membership' id='three_months' value='3_Months' />";
								renew_opts += " <label for='one_year'>One Year: </label><input type='radio' name='membership' id='one_year' value='1_Year' />";
								renew_opts += " <label for='three_month_vip'>Three Month VIP: </label><input type='radio' name='membership' id='three_month_vip' value='3_Month_VIP' />";
								renew_opts += " <label for='one_year_couples_vip'>One Yr Couples VIP: </label><input type='radio' name='membership' id='one_year_couples_vip' value='1_Yr_Couples_VIP' />";
								renew_opts += " <label for='one_year_singles_vip'>Three Months: </label><input type='radio' name='membership' id='one_year_singles_vip' value='1_Yr_Singles_VIP' />";	
								
								inputs += '<div id=\'renew_opts\'>' + renew_opts + '</div>';
								inputs += '<input type=\'hidden\' name=\'renew\' value=\'true\' />';
							} 
							
							inputs += "<input type='submit' name='checkin' class='go-btn' id='finish' value='Finish' />";
							
							var wrap = $("<div id='checkin_details'><p class='status-text'>"+data.text+"</p>"+inputs+"</div>");
							
							form.children().fadeOut(600, function(){
								form.html(wrap);
								if (data.mem_status == 'expired') renewInputEvent(form);
								finishEvent(form, data.mem_status);
							});
							$("#TB_window").animate({ 'height': '180px' }, 600);
						}
						ajax_alert(data, loader);
					}
				 });
				return false;
			});
			
			$("input:checkbox", "#discount_fields").change(function(){
				var $this = $(this);
				if ($this.is(":checked")) {
					$this.parent().addClass('selected');	
				} else $this.parent().removeClass('selected');	
			});
		}
		
		var renewInputEvent = function(form) {
			var original_fee = $('.price', form).text();
			$('#renew_opts input', form).click(function(){ 
				var $this = $(this);
				
				if ($this.data('checked')) {
					$this.attr('checked', '').data('checked', false);
					$('.price').text(original_fee);
					return false;
				}
				
				var membership = $this.attr('id');
				var fee = $('#'+membership, form).val();
				
				if (fee == 'X') {
					$this.attr('checked', '').data('checked', false);
					$('.price').text(original_fee);
					return false;	
				}
				$this.data('checked', true);
				
				var total = parseFloat(fee) + parseFloat(original_fee);
				$('.price').text(total);
			})	
		}
		
		var finishEvent = function(form, status){
			$(".close").fadeOut();
			var form = form || $("#checkin_form");
			$("#finish", "#checkin_details").click(function(){
				if (status == 'expired') {
					var renewing = false;
					$('input[name=membership]', form).each(function(){
						if ($(this).is(':checked')) renewing = true;
					});
					if (!renewing) {
						alert('Must Renew to Continue');
						return false;
					}
				}
				
				loader.fadeIn(600); 
				var alerted = false;
				
				$.ajax({
					type: "POST",
					url: GreyRobot.baseUrl + 'club/checkin',
					data: form.serialize()+'&checkin=Finish',
					dataType: 'json',
					success: function(data){
						$("#checkin_details").fadeOut(600, function(){
							if ($('h2', "#checkin_form").length > 0) {
								$('h2', "#checkin_form").text(data.text);
							} else {
								$("#checkin_form").append("<h2>"+data.text+"</h2>");
							}
							loader.fadeOut(600);
							$("h2", "#checkin_form").hide().fadeIn(2000,function(){
								$(this).fadeOut(1000,function(){
									if (!alerted) {
										alerted = true;
										tb_remove();
										ajax_alert(data, loader);
										checkin_box.html(checkin_box_html);
										checkinEvent();
									}
													    
								});
							});											
						});
					}
				 });
				return false;
			});	
		}
		
		//binds the click event to the button in either the #hours, #memberships, or #door_fees divs
		var pricingUpdateEvent = function(hours_mems_fees) {
			$("input[name=edit]", "#"+hours_mems_fees).click(function(){				
				var form_data = $("form", "#"+hours_mems_fees).serialize();
				
				if (confirm("Update " + hours_mems_fees.replace('_',' ') + "?")) { 
					loader.fadeIn(600);
					 $.ajax({
						type: "POST",
						url: GreyRobot.baseUrl + 'club/'+hours_mems_fees,
						data: 'edit=Update&'+form_data,
						dataType: 'json',
						success: function(data){
							ajax_alert(data, loader);
						}
					 });
				} 
				return false;
			});
		}
		
		var staffOrDiscountsEvent = function(which) {
			$("input[name=add]", "#"+which).click(function(){
				var btn_parent = $(this).parent();
				//validation
				var error = '';
				
				if (which == 'discounts') {
					var desc = btn_parent.next().children('input').val();
						if (!desc || desc == '') return false;
					var operator = btn_parent.next().next().children('div').children('input:checked').val();
						if (!operator || operator == '') error += "Please choose Percent or Minus.\n";
					var amount = btn_parent.next().next().next().children('input').val();
						if (isNaN(amount)) error += "What's the discount value?\n";
					
					var value_str = operator == 'percent' ? "&#37;"+amount+' Off' : '$'+amount+' Off';
					var vars = { 'add': 1, 'field_1': desc, 'field_2': operator, 'field_3': amount };
					var confirm_msg = 'Add discount \"' + desc + "\",\n";
					    confirm_msg += 'with a value of '+amount+(operator == 'percent' ? ' percent ' : ' dollars ')+'off?';
					
				} else if (which == 'staff') {
					var user = btn_parent.next().children('input').val();
						if (!user || user == '') return false;
					var pw = btn_parent.next().next().children('input').val();
						if (!pw || pw == '') error += "Please enter a password for " + user + "\n";
					var role = btn_parent.next().next().next().children('select').val();
						if (!role || role == '' || role == 'Role') error += "Select a role\n";
					
					var vars = { 'add': 1, 'field_1': user, 'field_2': pw, 'field_3': role };
					var confirm_msg = 'Add ' + role + ' account for ' + user + '?';
					
				}
				if (error != '') { alert(error); return false; }
				
				if (confirm(confirm_msg)) {
					loader.fadeIn(600);
					$.post(GreyRobot.baseUrl + 'club/'+which, vars, function(data){
						if (data.status == 'success') {					
							if (which == 'discounts') {
								var row = $("<tr>\n<td><a class='edit-discounts' title='Click to Edit' href='" + GreyRobot.baseUrl + "club/discounts/" + data.id + "'>" + vars.field_1 + "</a></td>\n<td>" + value_str + "</td>\n<td><form method='post' action='"+GreyRobot.baseUrl+"club/discounts/"+data.id+"'><input title='Delete this discount' type='submit' name='delete' class='del' value='X' /></form>\n</td>\n</tr>\n");
							} else if (which == 'staff') {
								var row = $("<tr>\n<td><a class='edit-staff' title='Click to Edit' href='" + GreyRobot.baseUrl + "club/staff/" + data.id + "'>" + vars.field_1 + "</a></td>\n<td>" + vars.field_3 + "</td>\n<td><form method='post' action='"+GreyRobot.baseUrl+"club/staff/"+data.id+"'><input title='Delete this user' type='submit' name='delete' class='del' value='X' /></form>\n</td>\n</tr>\n");	
							}
							
							addColoredRow(which, row);
							bindTableButtonEvent(which, loader);
							
							if (which == 'staff') {
								//clear inputs
								btn_parent.next().children('input').val('');
								btn_parent.next().next().children('input').val('');
								btn_parent.next().next().next()
												    .children('select')
												    .children('option:first').attr('selected', 'selected');
							} else if (which == 'discounts') {
								btn_parent.next().children('input').val('');
								btn_parent.next().next().children('input').val('');	
							}
						} 
						ajax_alert(data, loader);
					}, 'json');
				}
				return false;
			});
		}
		
		// gets called at the end of $("a.edit-staff", "#staff").click()
		var staffEditEvent = function(input, bar){
			$("input[name=edit]", "#staff").click(function(){
				var $this = $(this);
				//validation
				var error = '';
				
				if (!input.user || input.user == '') error += 'Please enter a user name\n';
				if (!input.role || input.role == '' || input.role == 'Role') error += 'Select a role';
				
				if (error != '') {
					alert(error);
					return false;
				}
				
				var pw = $this.parent().next().next().children('input').val();
				
				if (confirm("Update " + input.user + "'s account?")) { 
					loader.fadeIn(600);
					$.post(GreyRobot.baseUrl+'club/staff/'+input.id, 
						{ 'edit': 'Edit', 'id': input.id, 'field_1': input.user, 'field_2': pw, 'field_3': input.role }, 
						function(data){
							bar.css('background', 'none'); 
							ajax_alert(data, loader);
						}, 
						'json'
					);
				}
				return false;
			});
		}
		
	//Call Event Listeners
		memberLinkEvent();
		memberCheckinButton();
		checkinEvent();
		pricingUpdateEvent('hours');
		pricingUpdateEvent('memberships');
		pricingUpdateEvent('door_fees');
		staffOrDiscountsEvent('staff');
		staffOrDiscountsEvent('discounts');
		bindTableButtonEvent('discounts', loader);
		bindTableButtonEvent('staff', loader);
		bindTableButtonEvent('members', loader);
		staffEditEvent();
		
		$("a.edit-staff", "#staff").click(function(){
			var $this = $(this);
			var form = $("form", "#btns-bar");
			
			var input = {};
			input.id = $this.attr('href').replace(GreyRobot.baseUrl+'club/staff/','');
			input.user = $this.text().replace("\n", '');
			input.role = $this.parent().next().text();
			
			//change inputs to edit and fill in text fields with user info
			var edit_btn = $(".left input", form).unbind('click')
										  .attr('name', 'edit')
										  .attr('id', 'edit-btn')
										  .attr('value', 'Edit');
										  
			$(".mid input", form).val(input.user);
			
			$(".right select", form).children('option').each(function(){ alert($(this).val());
				if ($(this).val() == input.role) $(this).attr('selected', 'selected');						    
			});
			
			var bar = $("#btns-bar", "#staff");
			//highlight the form
			bar.append("<input type='hidden' name='id' value='"+input.id+"' />")
			   .addClass('highlight')
			   .animate({ 'opacity': '1' });
			
			
			staffEditEvent(input, bar);
			return false;								   
		});
		
		$("#login-btn").click(function(){
			var error = '';
			
			var user = $("input[name=user]", "#login").val();
			if (!user || user == '') error += 'Type in your user name.';
			
			var pw = $("input[name=pw]", "#login").val();
			if (!pw || pw == '') error += 'Enter a password.';
			
			if (error != '') {
				$("#login_error").html(error);
				return false;
			}
		});
		
		$("#logout").click(function(){
			loader.fadeIn(600);
			$.post(GreyRobot.baseUrl+'club/logout', {}, function(data){
				if (data == 'logged out') {
					loader.fadeOut(600);
					$("#authenticated").slideUp(2100).children().fadeOut(1400);
					$("#logout").fadeOut(700, function(){
						$("#login").fadeIn(700);							
					});
				}
			});
		});
		
		
		$(".close", "#checkin_thickbox").live('click', function(){ 
			tb_remove();
			loader.fadeOut();
			return false;
		});
		
		$("#checkin-btn").click(function(){
			$("input", "#checkin_form").each(function(){
				var $this = $(this);
				if ($this.is(":checked")) $this.attr('checked', '');
				else if ($this.attr('class') == 'resetable') $this.val('');
			});						   
		});		
		
	}
	
} //END SuperObject.prototype

//utility functions
function select_option(select_name, value) {
	$("option", "select[name="+select_name+"]").each(function(){
		var s = $(this);
		if (s.val() == value) s.attr('selected', 'selected');
		else s.attr('selected', '');
	});	
}

function ajax_alert(d, loader) { 
	if (d.status == 'success') {
		var date = new Date();
		var dateString = "<span class='timestamp'>"+
						date.toLocaleString().replace(' GMT-0400 (Eastern Daylight Time)','')+": </span>";
		
		//remove the inputs that are returned when a membership is expired
		d.text = d.text.replace('<div><label for=\'membership\'>Membership: </label><select name=\'membership\' id=\'membership\'><option value=\'1_Month\'>One Month</option><option value=\'3_Month\'>Three Months</option><option value=\'1_Year\'>One Year</option></select></div><div><input type=\'submit\' name=\'renew\' value=\'Renew\' /></div>', '');
		
		var msg = $("<p class='success'>" + dateString + d.text + "</p>");
		$("#msg_box").prepend(msg);
		msg.slideDown(600);	
	} else alert(d.status + ': ' + d.text); 
	loader.fadeOut(600);
}

function addColoredRow(table, row) {
	row.css('display','none');
	$("tr", "#"+table+"_table").removeClass('even');
	$("tr:first","#"+table+"_table").after(row);
	row.fadeIn(600);
	$("tr:even", "#"+table+"_table").addClass('even');	
}