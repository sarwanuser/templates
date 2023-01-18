/*================================================================================
	Name: Itinerary Script
	Version: 1.0
	Author: ENSOBER
	Author URL: http://www.ensoberhotels.com/
================================================================================

NOTE:
------
PLACE HERE ENSOBER ITINERARY JS CODES. */

// Itinerary Next Button
function itiNextBtn(next){
	jQuery(".iti_input_form").removeClass('active');
	jQuery(".iti_input_form .collapsible-body").slideUp("slow");
	jQuery("#"+next).addClass('active');
	jQuery("#"+next+" .collapsible-body").slideDown("slow");
	
	// Scroll Current Input Form
	setTimeout(function(){
		var iti_nect_po = jQuery("#"+next).position().top;
		console.log(iti_nect_po);
		document.body.scrollTop = iti_nect_po;
		document.documentElement.scrollTop = iti_nect_po;
	},700);
}

// Get the difference for and to date.
function getNoOfDay(fromdate, todate){
	var fromdate = new Date(fromdate);
	var todate = new Date(todate);
	var diffTime = Math.abs(todate - fromdate);
	var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
	console.log(diffDays + " days");
	return diffDays;
}


/** Make Quotation **/

	// Add mode info
	function addMore(){
		jQuery("#daywaise_info").clone().appendTo(".daywaise_details");
		jQuery(".quotation_update_rate").html(''); 
	} 
	
	// Remove info
	function remove(e){
		e.parents('.daywaise_info').remove()
	}
	
	// validate lead details
	function validateLeadDetails(){
		var name = jQuery("#name").val();
		var email = jQuery("#email").val();
		var mobile = jQuery("#mobile").val();
		validate_status = true;
		jQuery(".error_msg").text("");
		if(name == ''){
			jQuery(".error_msg").text("Name is required!");
			validate_status = false;
		}
		if(email == ''){
			jQuery(".error_msg").text("Email is required!");
			validate_status = false;
		}else{
			var emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!emailReg.test(email)){
				jQuery(".error_msg").text("Please enter valid email!");
				validate_status = false;
			}
		}
		if(mobile == ''){
			jQuery(".error_msg").text("Mobile number is required!");
			validate_status = false;
		}else{
			if(mobile.length != 10){
				jQuery(".error_msg").text("Please enter valid mobile no!");
				validate_status = false;
			}
		}
		return validate_status;
	}
	
	// Save quotatio details
	function generateQuotation(){
		if(!validateLeadDetails()){
			return false;
		}
		//var editor = CKEDITOR.instances['editor'].getData();
		//alert(editor);
		//return false;
		//var datas = jQuery("#quotation").serialize();
		jQuery(".generate_send_quo").text('Processing...');
		jQuery(".generate_send_quo").css({"color":"#fff"}); 
		jQuery(".generate_send_quo").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/generatequotation',
			cache: false,
			async: true,
			data: jQuery("#quotation").serialize(),
			success: function(res){
				console.log(res);
				jQuery(".send_quotation_msg").hide();
				var obj = JSON.parse(res);
				if(obj.status == false){
					alert(obj.msg);
					jQuery(".generate_send_quo").text('Generate');
					jQuery(".generate_send_quo").prop('disabled', false);
					return false;
				}
				if ($.isFunction(window.redirectToUpdateMode)){
					redirectToUpdateMode(obj.send_quotation_no);
				}
				jQuery(".generate_send_quo").text('Generate');
				jQuery(".generate_send_quo").prop('disabled', false);
				jQuery(".btn_send_quo").show();
				jQuery(".btn_copy_quo").show();
				jQuery(".fgsilement").show();
				jQuery(".email_body").html(obj.send_message);  
				jQuery("#email_message").text(obj.email_body);  
				jQuery("#email_subject").val(obj.subject);  
				jQuery(".quotation_update_rate").html(obj.quotation_rate);
				jQuery(".btn_edit_rate_quo").show();
				jQuery("#send_quotation_no").val(obj.send_quotation_no);  
				jQuery(".final_cost_val").text('Final Cost: '+obj.final_cost_val); 
				jQuery(".update_mode_t_price").text(obj.final_cost_val); 
				jQuery("#total_price").val(obj.final_cost_val); 
				checkFinalCostAply();
				console.log(obj.open_img_popup);
				if(obj.open_img_popup == 1){
					jQuery(".upload_image_popup").bPopup();
				}
				
				ClassicEditor.create( document.querySelector( '.editor_hide' ), { 
					// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
				}).then( editor => {
					window.editor = editor;
				}).catch( err => {
					console.error( err.stack );
				});
			}
		});			
	}
	
	// Generate activity voucher
	function generateActivityVoucher(){
		var mr_mrs = jQuery("#ff_c_name").val();
		jQuery(".mr_mrs_error").text('');
		if(mr_mrs == ''){
			jQuery(".mr_mrs_error").text('Required!');
			return false;
		}
			
		jQuery(".don_voucher").addClass('hide');
		jQuery(".generate_activity_voucher").text('Processing...');
		jQuery(".generate_activity_voucher").css({"color":"#fff"}); 
		jQuery(".generate_activity_voucher").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/generateactivityvoucher',
			cache: false,
			async: true,
			data: jQuery("#avtivity_voucher").serialize(),
			success: function(res){
				console.log(res);
				jQuery(".send_quotation_msg").hide();
				var obj = JSON.parse(res);
				if(obj.status == false){
					jQuery(".generate_activity_voucher").text('Generate');
					jQuery(".generate_activity_voucher").prop('disabled', false);
					return false;
				}
				if ($.isFunction(window.redirectVoucherToUpdateMode)){
					redirectVoucherToUpdateMode(obj.activity_voucher_no);
				}
				jQuery(".generate_activity_voucher").text('Generate');
				jQuery(".don_voucher").removeClass('hide');
				jQuery(".generate_activity_voucher").prop('disabled', false);
				jQuery(".email_body").html(obj.send_message);
				jQuery("#total_bill").val(obj.final_cost_val); 
				jQuery("#activity_voucher_no").val(obj.activity_voucher_no); 
			}
		});			
	}
	
	// Check hotel price available or not
	function checkHotelPriceAvailable(){
		jQuery(".price_not_error").hide();
		var hotel_id = jQuery("#hotel_list").val();
		var checkin = jQuery("#checkin").val();
		var room_type = jQuery("#room_type").val();
		if(checkin == ""){
			jQuery(".price_not_error").show();
			jQuery(".price_not_error").text('Please select checkin date first!');
		}
		jQuery.ajax({
			type: 'post',
			url: '/operator/checkhotelpriceavailable',
			cache: false,
			async: true,
			data: {'checkin':checkin, 'hotel_id':hotel_id, 'room_type':room_type},
			success: function(res){
				console.log();
				if(res == 0){
					jQuery(".price_not_error").show();
					jQuery(".price_not_error").text('Price Not Available!');
				}else{
					jQuery(".price_not_error").hide();
				}
			}
		});			
	}
	
	// Get assigned operator details of contact
	function getAssignedOperatorDetail($contact_id){
		jQuery.ajax({
			type: 'get',
			url: '/admin/getassignedoperator',
			cache: false,
			async: true,
			data: {'contact_id':contact_id},
			success: function(res){
				console.log(res);
				if(res == 0){
					jQuery(".price_not_error").show();
					jQuery(".price_not_error").text('Price Not Available!');
				}else{
					jQuery(".price_not_error").hide();
				}
			}
		});			
	}
	
	// Get payment source by hotel
	function getPaymentSourceByHotelId(hotel_id){
		jQuery.ajax({
			type: 'post',
			url: '/operator/getpaymentsource',
			cache: false,
			async: true,
			data: {'hotel_id':hotel_id},
			success: function(res){
				console.log(res);
				jQuery("#payment_source").html(res);
			}
		});			
	}
	
	// Get hotel details view
	function getHotelDetailView(checkin='', room_type=''){
		var hotel_id = jQuery("#hotel_list").val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/gethoteldetailview',
			cache: false,
			async: true,
			data: {'hotel_id':hotel_id, 'checkin':checkin, 'room_type':room_type},
			success: function(res){
				console.log();
				jQuery(".email_body").html(res);
				if (window.matchMedia('(max-width: 400px)').matches){
					jQuery(".hotel_view_mobile").html(res);
					jQuery(".hotel_view_mobile").bPopup();
				}
			}
		});			
	}
	
	// Update quotatio rate
	function updateQuotationRate(){
		jQuery(".btn_confirm_rate_quo").text('Processing...');
		jQuery(".btn_confirm_rate_quo").prop('disabled', true);
		jQuery(".btn_confirm_rate_quo").text('Confirm');
		jQuery(".btn_confirm_rate_quo").prop('disabled', false);
		jQuery(".btn_confirm_rate_quo").hide();
		jQuery(".btn_edit_rate_quo").show();
		generateQuotation();		
	} 
	
	// Send quotatio details
	function sendQuotation(){
		var email = jQuery("#email").val();
		var email_body = jQuery(".email_body").html();
		var email_subject = jQuery("#email_subject").val();
		var send_quotation_no = jQuery("#send_quotation_no").val();
		var email_message = jQuery("#email_message").val();
		var ccemail = jQuery("#ccemail").val();
		var quotation_type = jQuery("#quotation_type").val();
		var quot_pdf = jQuery("#quot_pdf").val();
		jQuery(".btn_send_quo").text('Processing...');
		jQuery(".btn_send_quo").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/sendquotation',
			cache: false,
			async: true,
			data: {'email':email, 'ccemail':ccemail, 'email_body':email_body, 'email_subject':email_subject, 'send_quotation_no':send_quotation_no, 'quotation_type':quotation_type, 'email_message':email_message,'quot_pdf':quot_pdf},
			success: function(res){
				jQuery(".btn_send_quo").text('Send Quotation');
				jQuery(".btn_send_quo").prop('disabled', false);
				jQuery(".send_quotation_msg").text(res); 
				//location.reload();
			}
		});			
	}
	
	// Check Final cost is greterthan 0 then hide rate calculation rate
	function checkFinalCostAply(){
		var filan_cost = jQuery("#final_cost").val();
		if(filan_cost > 0){
			jQuery(".rate_canculate").hide();
		}else{
			jQuery(".rate_canculate").show();
		}
	}
	
	// Update final cost
	function updateFinalCost(){
		var final_cost = jQuery("#final_cost").val();
		var send_quotation_no = jQuery("#send_quotation_no").val();
		jQuery(".btn_edit_final_cost").text('Processing...');
		jQuery(".btn_edit_final_cost").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/updatefinalcost',
			cache: false,
			async: true,
			data: {'final_cost':final_cost, 'send_quotation_no':send_quotation_no},
			success: function(res){
				jQuery(".btn_edit_final_cost").text('Update Cost');
				jQuery(".btn_edit_final_cost").prop('disabled', false);
				jQuery(".send_quotation_msg").text(res); 
				generateQuotation();
				checkFinalCostAply();
			}
		});			
	}
	
	// Copy html content
	function CopyToClipboard(id){
		jQuery(".btn_copy_quo").text('Copying...');
		var r = document.createRange();
		r.selectNode(document.getElementById(id));
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(r);
		document.execCommand('copy');
		window.getSelection().removeAllRanges();
		setTimeout(function(){
			jQuery(".btn_copy_quo").text("Copied");
		},500);
		setTimeout(function(){
			jQuery(".btn_copy_quo").text("Copy Quotation");
		},1000);
	}
	
	// Copy html content
	function CopyToText(id){
		jQuery(".notify_msg").text('Copying...');
		var r = document.createRange();
		r.selectNode(document.getElementById(id));
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(r);
		document.execCommand('copy');
		window.getSelection().removeAllRanges();
		setTimeout(function(){
			jQuery(".notify_msg").text("Copied");
		},500);
		setTimeout(function(){
			jQuery(".notify_msg").text("");
		},1000);
	}
	
	// This function use for open update quotation page
	function openUpdateQuotationPage(){
		var QuotationID = jQuery("#sendquomo").val();
		var update_page = "/operator/makequotation/"+QuotationID;
		window.location.replace(update_page);
	}
	
	// This function use for download quotation
	function downloadQuotation(){
		var QuotationID = jQuery("#send_quotation_no").val();
		var download_link = "/storage/app/quotations/"+QuotationID+".pdf";
		window.open(download_link, '_blank');
	}
	
	// This function use for download activity voucher
	function downloadActivityVoucher(){
		var VoucherID = jQuery("#activity_voucher_no").val();
		var download_link = "/storage/app/quotations/"+VoucherID+".pdf";
		window.open(download_link, '_blank');
	}
	
	// This function use for edit the rate
	function editQuotationRate(){
		jQuery(".quo_show_fiels").hide();
		jQuery(".btn_edit_rate_quo").hide();
		jQuery(".quo_edit_fiels").show();
		jQuery(".quo_edit_fiels").prop('disabled', false);
		jQuery(".btn_confirm_rate_quo").show();
	}
	
	// Change the send quotation button text as per type
	function changeSendQuotationBtnText(){
		var type = jQuery("#quotation_type").val();
		jQuery(".btn_send_quo").text("Send "+type);
	}
	
	// Add room booking for room inventory
	function addRoomBooking(){
		var hotel = jQuery("#hotel").val();
		var room_type = jQuery("#room_type").val();
		var check_in = jQuery("#check_in").val();
		var check_out = jQuery("#check_out").val();
		var client_name = jQuery("#client_name").val();
		var agent_name = jQuery("#agent_name").val();
		var total_rooms = jQuery("#total_rooms").val();
		var plan = jQuery("#plan").val();
		var adults = jQuery("#adults").val();
		var kids_chargable = jQuery("#kids_chargable").val();
		var infant = jQuery("#infant").val();
		var booked_by = jQuery("#booked_by").val();
		var source = jQuery("#source").val();
		var booking_from = jQuery("#booking_from").val();
		var advance_amount = jQuery("#advance_amount").val();
		var payment_source = jQuery("#payment_source").val();
		var date_of_advance = jQuery("#date_of_advance").val();
		var comment = jQuery("#comment").val();
		var comment_for_advance = jQuery("#comment_for_advance").val();
		var comment_for_balace = jQuery("#comment_for_balace").val();
		jQuery("#addbookingbtn").text('Processing...');
		jQuery("#addbookingbtn").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/addroombookaction',
			cache: false,
			async: true,
			data: {'hotel':hotel, 'room_type':room_type, 'check_in':check_in, 'check_out':check_out, 'client_name':client_name, 'agent_name':agent_name, 'total_rooms':total_rooms, 'plan':plan, 'adults':adults, 'kids_chargable':kids_chargable, 'infant':infant, 'booked_by':booked_by, 'source':source, 'booking_from':booking_from, 'advance_amount':advance_amount, 'payment_source':payment_source, 'date_of_advance':date_of_advance, 'comment':comment, 'comment_for_advance':comment_for_advance, 'comment_for_balace':comment_for_balace},
			success: function(res){
				console.log(res.msg);
				jQuery("#addbookingbtn").text('Submit Room Booing');
				jQuery("#addbookingbtn").prop('disabled', false);
				jQuery("#add_room_msg").text(res); 
				location.reload();
			}
		});			
	}
	
	// This function for date format 2021-07-01
	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) 
			month = '0' + month;
		if (day.length < 2) 
			day = '0' + day;

		return [year, month, day].join('-');
	}
	
	// Get current room booking status
	function getRoomBookingStatus(){
		jQuery(".filter_data_loader").show();
		jQuery(".status_data_main").hide();
		var s_year = jQuery("#s_year").val();
		var s_month = jQuery("#s_month").val();
		var hotel_id = jQuery("#hotel_id").val();
		
		// Set the date limit
		var s_month_1 = s_month-1;
		var firstDay = new Date(s_year, s_month_1, 1);
		var lastDay = new Date(s_year, s_month_1 + 1, 0);
		console.log('s_year:'+s_year+' s_month:'+s_month);
		console.log('firstDay:'+firstDay);
		console.log('lastDay:'+lastDay);
		var min = formatDate(firstDay);
		var max = formatDate(lastDay);
		jQuery("#s_date").attr('min',min);
		jQuery("#s_date").attr('max',max);
		
		var s_date = jQuery("#s_date").val();
		jQuery("#get_room_status_btn").text('Processing...');
		jQuery("#get_room_status_btn").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/getroomstatus',
			cache: false,
			async: true,
			data: {'s_year':s_year, 's_month':s_month, 'hotel_id':hotel_id, 's_date':s_date},
			success: function(res){
				var obj = JSON.parse(res);
				console.log(obj);
				if(jQuery(".cencel_refund_status_popup").is(":visible")){
					jQuery(".cencel_refund_status_popup").bPopup().close();
				}
				jQuery(".filter_data_loader").hide();
				jQuery(".status_data_main").show();
				jQuery("#get_room_status_btn").text('Current Rooms Status');
				jQuery(".follow_title strong").text(obj.hotel_name);
				jQuery("#get_room_status_btn").prop('disabled', false);
				jQuery("#current_room_status_main").html(obj.room_status); 
			}
		});
		
	}
	
	// Get current room available
	function getRoomAvailableStatus(){ 
		jQuery(".filter_data_loader").show();
		jQuery(".status_data_main").hide();
		var s_year = jQuery("#s_year").val();
		var s_month = jQuery("#s_month").val();
		var hotel_id = jQuery("#hotel_id").val();
		
		// Set the date limit
		var s_month_1 = s_month-1;
		var firstDay = new Date(s_year, s_month_1, 1);
		var lastDay = new Date(s_year, s_month_1 + 1, 0);
		console.log('s_year:'+s_year+' s_month:'+s_month);
		console.log('firstDay:'+firstDay);
		console.log('lastDay:'+lastDay);
		var min = formatDate(firstDay);
		var max = formatDate(lastDay);
		jQuery("#s_date").attr('min',min);
		jQuery("#s_date").attr('max',max);
		
		var s_date = jQuery("#s_date").val();
		if(s_date == ''){
			jQuery("#s_date").css({"border":"1px solid red"});
			return false;
		}
		jQuery("#get_room_status_btn").text('Processing...');
		jQuery("#get_room_status_btn").prop('disabled', true);
		jQuery.ajax({
			type: 'post',
			url: '/operator/get-room-available',
			cache: false,
			async: true,
			data: {'s_year':s_year, 's_month':s_month, 'hotel_id':hotel_id, 's_date':s_date},
			success: function(res){
				var obj = JSON.parse(res);
				console.log(obj);
				if(jQuery(".cencel_refund_status_popup").is(":visible")){
					jQuery(".cencel_refund_status_popup").bPopup().close();
				}
				jQuery(".filter_data_loader").hide();
				jQuery(".status_data_main").show();
				jQuery("#get_room_status_btn").text('Current Rooms Status');
				jQuery(".follow_title strong").text(obj.hotel_name);
				jQuery("#get_room_status_btn").prop('disabled', false);
				jQuery("#current_room_status_main").html(obj.room_status); 
			}
		});
		
	}
	
	// Get room booking details by booking_id
	function getRoomBookedDetailsPop(booking_id){
		jQuery.ajax({
			type: 'post',
			url: '/operator/getroombookdetails',
			cache: false,
			async: true,
			data: {'booking_id':booking_id},
			success: function(res){
				console.log();
				jQuery(".room_b_update_pop").html(res);
				jQuery(".room_booked_update_popup").bPopup();
			}
		});			
	}
	
	// Delete room booking details by booking_id 
	function deleteRoomBookedDetails(booked_no){
		jQuery.ajax({
			type: 'post',
			url: '/operator/updateroombookaction',
			cache: false,
			async: true,
			data: {'booked_no':booked_no, 'delete':1},
			success: function(res){
				console.log(res);
				var obj = JSON.parse(res);
				if(obj.status == true){
					jQuery(".booking_delete_msg").text(obj.msg);
					jQuery(".booking_delete_msg").show();
					getRoomBookingStatus();
				}else{
					jQuery(".booking_delete_msg").hide();
				}
			}
		});			
	}
	
	// Delete room booking details by booking_id 
	function cancelRoomBookedDetails(booked_no, reason, cancel_refund, extra_bill='', extra_bill_comment=''){
		jQuery.ajax({
			type: 'post',
			url: '/operator/updateroombookaction',
			cache: false,
			async: true,
			data: {'booked_no':booked_no, 'reason':reason, 'cancel_refund':cancel_refund, 'extra_bill':extra_bill, 'extra_bill_comment':extra_bill_comment, 'cancel_booking':1},
			success: function(res){
				console.log(res);
				var obj = JSON.parse(res);
				jQuery("#cancel_loader_img").hide();
				if(obj.status == true){
					jQuery(".booking_delete_msg").text(obj.msg);
					jQuery(".booking_delete_msg").show();
					getRoomBookingStatus();
				}else{
					jQuery(".booking_delete_msg").hide();
				}
			}
		});			
	}

	// Get the data for room inventory dashboard
	function roomInventoryDashboardData(){
		jQuery(".filter_data_loader").show();
		jQuery(".filter_data_main").hide();
		var custom_tab = jQuery(".custom_tab .active").find(".datamode").val();
		if(custom_tab == '3'){ // This is for Offline
			var post_url = '/operator/roominventorydashboarddataoffline';
		}else if(custom_tab == '2'){ // This is for Online
			var post_url = '/operator/roominventorydashboarddataonline';
		}else{ // This is for Total
			var post_url = '/operator/roominventorydashboarddata';
		}
		var from_date = jQuery("#from_date").val();
		var to_date = jQuery("#to_date").val();
		var log_hotel_id = jQuery("#log_hotel_id").val();
		jQuery.ajax({
			type: 'post',
			url: post_url,
			cache: false,
			async: true,
			data: {'from_date':from_date, 'to_date':to_date, 'log_hotel_id':log_hotel_id},
			success: function(res){
				console.log(res);
				var obj = JSON.parse(res);
				jQuery(".filter_data_loader").hide();
				jQuery(".filter_data_main").show(); 
				
				// Display the advance payment source wise
				jQuery(".payment_details").html(obj.source_wise_payment);
				
				
				// Total Billing
				jQuery("#total_bill").text(obj.das_total_billing_data.total_billing);
				jQuery("#total_bill_booked_r").text(obj.das_total_billing_data.booked_rooms);
				jQuery("#total_bill_total_r").text(obj.das_total_billing_data.total_rooms);
				
				// ARR
				jQuery("#arr").text(obj.das_arr_data.arr);
				jQuery("#arr_total_bill_r").text(obj.das_arr_data.total_bill);
				jQuery("#arr_booked_r").text(obj.das_arr_data.booked_rooms);
				
				// AP ARR
				jQuery("#aparr").text(obj.das_aparr_data.aparr);
				jQuery("#aparr_total_bill_r").text(obj.das_aparr_data.ap_das_total_billing);
				jQuery("#aparr_booked_r").text(obj.das_aparr_data.ap_booked_rooms);
				
				// MAP ARR
				jQuery("#maparr").text(obj.das_maparr_data.maparr);
				jQuery("#maparr_total_bill_r").text(obj.das_maparr_data.map_das_total_billing);
				jQuery("#maparr_booked_r").text(obj.das_maparr_data.map_booked_rooms);
				
				// CP ARR
				jQuery("#cparr").text(obj.das_cparr_data.cparr);
				jQuery("#cparr_total_bill_r").text(obj.das_cparr_data.cp_das_total_billing);
				jQuery("#cparr_booked_r").text(obj.das_cparr_data.cp_booked_rooms);
				
				// EP ARR
				jQuery("#eparr").text(obj.das_eparr_data.eparr);
				jQuery("#eparr_total_bill_r").text(obj.das_eparr_data.ep_das_total_billing);
				jQuery("#eparr_booked_r").text(obj.das_eparr_data.ep_booked_rooms);
				
				// Today Occupancy
				jQuery("#today_acc").text(obj.das_todayocc_data.today_acc);
				jQuery("#today_acc_booked_r").text(obj.das_todayocc_data.today_acc_booked_rooms);
				jQuery("#today_acc_total_r").text(obj.das_todayocc_data.today_acc_total_rooms);
				
				// Occupancy
				jQuery("#acc").text(obj.das_occ_data.acc);
				jQuery("#acc_booked_r").text(obj.das_occ_data.acc_booked_rooms);
				jQuery("#acc_total_r").text(obj.das_occ_data.acc_total_rooms);
				
				// Week Day Occupancy
				jQuery("#weekday_acc").text(obj.das_week_day_occ_data.weekday_acc);
				jQuery("#weekday_acc_booked_rooms").text(obj.das_week_day_occ_data.weekday_acc_booked_rooms);
				jQuery("#weekday_acc_total_rooms").text(obj.das_week_day_occ_data.weekday_acc_total_rooms);
				
				// Weekend Occupancy
				jQuery("#weekend_acc").text(obj.das_week_end_occ_data.weekend_acc);
				jQuery("#weekend_acc_booked_rooms").text(obj.das_week_end_occ_data.weekend_acc_booked_rooms);
				jQuery("#weekend_acc_total_rooms").text(obj.das_week_end_occ_data.weekend_acc_total_rooms);
				
				// Today Pax
				jQuery("#today_total_pax").text(obj.das_todaypax_data.today_total_pax);
				jQuery("#today_noofadult").text(obj.das_todaypax_data.today_noofadult);
				jQuery("#today_noofchield").text(obj.das_todaypax_data.today_noofchield);
				jQuery("#today_noofinfant").text(obj.das_todaypax_data.today_noofinfant);
				
				//Total Adults
				jQuery("#total_adult").text(obj.total_adult);
				
				// Total Chields
				jQuery("#total_chield").text(obj.total_chield);
				
				// Total Infants
				jQuery("#total_infant").text(obj.total_infant);
			}
		});			
	}
	
	// Get room category by hotel id
	function getRoomCatByHotel(){
		var hotel_id = jQuery("#hotel").val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/getRoomTypeById',
			cache: false,
			async: true,
			data: {'hotel_id':hotel_id},
			success: function(res){
				jQuery(".room_type_list").html(res);
			}
		});
	}
	
	// Check Season Hotel Rate Available Or Not
	function checkSeasonHotelRateAvailable(hotel, checkin,room_type){
		jQuery(".rate_no_ava_error").hide();
		if(hotel != '' && checkin != '' && room_type != ''){
			jQuery.ajax({
				type: 'post',
				url: '/operator/checkrateavailable',
				cache: false,
				async: true,
				data: {'hotel':hotel, 'checkin':checkin, 'room_type':room_type},
				success: function(res){
					var obj = JSON.parse(res); 
					if(obj.rate_status == false){
						jQuery(".rate_no_ava_error").slideDown();
						jQuery(".generate_send_quo").prop('disabled', true);
					}else{
						jQuery(".rate_no_ava_error").slideUp();
						jQuery(".generate_send_quo").prop('disabled', false);
					}
				}
			});
		}
	}
	

/** /Make Quotation **/
jQuery(document).ready(function(){	
	// Get room cat by hotel
	//getRoomCatByHotel(); 
	
	// check das in no of geust
	jQuery(".check_das").keyup(function(event){
		if(event.which == '189'){
			jQuery(this).val("");
		}
	});
	
	// Check Season Hotel Rate Available Or Not
	jQuery(".check_hotel_rate_available").change(function(){
		var result = '';
		var checkin = jQuery(this).parent().parent().parent().find("#checkin").val();
		var room_type = jQuery(this).parent().parent().parent().find("#room_type").val();
		var hotel = jQuery(".hotel_list").val();
		checkSeasonHotelRateAvailable(hotel, checkin, room_type);
		
	});
	
	
	jQuery("body").delegate(".open_room_details","click", function(){
		jQuery(this).parent().toggleClass('active');
		jQuery(this).parent().find(".collapsible-body").slideToggle();
	});
	
	// Open popup for update booking
	jQuery("body").delegate(".update_room_book_details","click", function(){
		var booking_id = jQuery(this).attr('booking_id');
		getRoomBookedDetailsPop(booking_id);
	});
	
	// Delete room booking details by booking_id
	jQuery("body").delegate(".delete_room_book_details","click", function(){
		var conf = confirm("Are You Sure You Want To Delete?");
		if(conf == true){
			var booking_id = jQuery(this).attr('booking_id');
			deleteRoomBookedDetails(booking_id);
		}
	});
	
	// Change refund status the hide show extra charge details	
	jQuery(".refund_status_btn").change(function(){
		var refund_status = jQuery(this).val();
		if(refund_status == 'N'){
			jQuery(".extra_charge_details").show();
		}else{
			jQuery(".extra_charge_details").hide();
		}
	});
	
	// Cancel room booking details by booking_id
	jQuery("body").delegate("#cancel_booking_details","click", function(){
		jQuery("#cancel_loader_img").show();
		var booking_id = jQuery("#cancel_booking_id").val();
		var reason = jQuery("#cancel_reason").val();
		var extra_bill = jQuery("#extra_bill").val();
		var extra_bill_comment = jQuery("#extra_bill_comment").val();
		var cancel_refund = 'Y';
		jQuery(".refund_status_btn").each(function(){
			var status_r = jQuery(this).prop("checked");
			if(status_r == true){
				cancel_refund = jQuery(this).val()
			}			
		});
		cancelRoomBookedDetails(booking_id, reason, cancel_refund, extra_bill, extra_bill_comment);
	});
	
	// Cancel room booking details by booking_id
	jQuery("body").delegate(".cancel_room_book_details","click", function(){
		var reason = prompt("Please enter cancel reason", "");
		if(reason != null){
			var booking_id = jQuery(this).attr('booking_id');
			jQuery("#cancel_booking_id").val(booking_id);
			jQuery("#cancel_reason").val(reason);
			jQuery(".cencel_refund_status_popup").bPopup();
			return false;
			/* var cancel_refund = confirm("Are you refund advance payment? (Yes=OK)");
			if(cancel_refund == true) {
			  cancel_refund = "Y";
			}else{
			  cancel_refund = "N";
			}
			cancelRoomBookedDetails(booking_id, reason, cancel_refund); */
		}
	});
	
	
	// Change the send quotation button text as per type
	changeSendQuotationBtnText(); 
	
	// Get how many days stay by from and to date
	jQuery("body").delegate("#checkin","change", function(){
		var checkin = jQuery(this).val();
		var checkout = jQuery(this).parent().parent().find("#checkout").val();
		var noofnight = getNoOfDay(checkin,checkout);
		jQuery(this).parent().parent().find("#night").val(noofnight);
	});
	
	jQuery("body").delegate("#checkout","change", function(){
		var checkout = jQuery(this).val();
		var checkin = jQuery(this).parent().parent().find("#checkin").val();
		var noofnight = getNoOfDay(checkin,checkout);
		jQuery(this).parent().parent().find("#night").val(noofnight);
	});
	
	// Get hotel details with price
	jQuery("body").delegate("#room_type","change", function(){
		var room_type = jQuery(this).val();
		var checkin = jQuery(this).parents(".daywaise_info").find("#checkin").val();
		getHotelDetailView(checkin, room_type);
	});
	
	// Check uncheck for final cost
	jQuery("#final_cost_check").change(function(){
		var check_status = jQuery(this).prop("checked");
		if(check_status == false){
			if(!confirm("Are You Sure Remove Final Cost?, OK or Cancel.")){
				jQuery(this).prop("checked", true);
				return false;
			}else{
				jQuery(".final_cost_area").hide();
				jQuery("#final_cost").val(0);
			}
		}else{
			jQuery(".final_cost_area").show();
		}
		
	});
	
	jQuery("#checkin").change(function(){
		jQuery("#checkout").attr("min", jQuery(this).val()); 
	});
	jQuery(".quo_edit_fiels").hide();
	/** Make Quotation **/
	// Get Hotel By City Id
	jQuery("body").delegate(".distination","change", function(){
		var city_id = jQuery(this).val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/getHotelById',
			cache: false,
			async: true,
			data: {'city_id':city_id},
			success: function(res){
				jQuery(".hotel_list").html(res); 
			}
		});
	});
	
	// Get hotels room type by hotel id for added row
	jQuery("body").delegate('.hotel_list', 'change', function(){
		var hotel_id = jQuery(this).val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/getRoomTypeById',
			cache: false,
			async: true,
			data: {'hotel_id':hotel_id},
			success: function(res){
				jQuery(".room_type_list").html(res);
			}
		});
	});
	/** /Make Quotation **/
	
	// Check room availability 
	jQuery("body").delegate(".checkRoomAvailability", 'change', function(){
		thisdiv = jQuery(this);
		var noofrooms = jQuery(this).parents('.mul_cat_room_details').find("#noofrooms").val();
		var check_in = jQuery(this).parents('.mul_cat_room_details').find("#check_in").val();
		var room_type = jQuery(this).parents('.mul_cat_room_details').find("#room_type").val();
		var hotel = jQuery("#hotel").val();
		
		jQuery.ajax({
			type: 'post',
			url: '/operator/checkroomavailibility',
			cache: false,
			async: true,
			data: {'noofrooms':noofrooms, 'check_in':check_in, 'room_type':room_type, 'hotel':hotel},
			success: function(res){
				console.log(res);
				var obj = JSON.parse(res);
				if(obj.status == false){
					thisdiv.parents('.mul_cat_room_details').find(".check_room_error").text(obj.msg);
					thisdiv.parents('.mul_cat_room_details').find("#noofrooms").val('');
					jQuery("#addbookingbtn").prop('disabled', true);
				}else{
					thisdiv.parents('.mul_cat_room_details').find(".check_room_error").text('');
					jQuery("#addbookingbtn").prop('disabled', false);
				}
			}
		});	
	});
	
	
	/**===== Activity Voucher =====**/
	// Get the time by slot
	jQuery("body").delegate('#slot', 'change', function(){
		var slot = jQuery(this).val();
		var activity_id = jQuery("#activity_list").val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/gettimebyslot',
			cache: false,
			async: true,
			data: {'activity_id':activity_id, 'slot':slot},
			success: function(res){
				var obj = jQuery.parseJSON(res);
				jQuery("#slot_time").val(obj.slot);
				jQuery("#total_bill").val(obj.price);
				jQuery("#actual_cost").val(obj.actual_price);
			}
		});
	});
	
	
	// Get Hotel By City Id
	jQuery("body").delegate(".activity_distination","change", function(){
		var city_id = jQuery(this).val();
		var activity_id = jQuery("#activity_id").val();
		jQuery.ajax({
			type: 'post',
			url: '/operator/getactivitybycity',
			cache: false,
			async: true,
			data: {'city_id':city_id, 'activity_id':activity_id},
			success: function(res){
				jQuery(".activity_list").html(res); 
			}
		});
	});
	/**===== /Activity Voucher =====**/
	
});