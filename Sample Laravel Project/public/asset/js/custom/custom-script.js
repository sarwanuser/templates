/*==============================================================================
	Name: Custome Script
	Version: 1.0
	Author: ENSOBER
	Author URL: http://www.ensoberhotels.com/
================================================================================

*/


jQuery(document).ready(function(){
	
	// Mobile number trim
	jQuery("body").delegate('.mobile_trim', 'blur', function(){
		var mobile = jQuery(this).val().trim().substr(-10);
		jQuery(this).val(mobile);
		
		// For text
		var mobile = jQuery(this).text().trim().substr(-10);
		jQuery(this).text(mobile);
	});
	
	
	// Close alert message
	jQuery("body").delegate('.close', 'click', function(){
		jQuery(".card-alert").hide();
	});
	
	jQuery("select").each(function(){
		jQuery(this).attr('tabindex', 0);
	});
	jQuery(".buttons-csv").addClass("mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange");
	jQuery(".buttons-csv").removeClass("dt-button");
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	baseUrl = '/admin/';
	baseUrlV = '/vender/';
	
	
	// Get activity name by activity cat id.
	jQuery("#activity_cat_id").change(function(){
		var activity_cat_id = jQuery(this).val();
		jQuery.ajax({
			type:'POST',
			url: baseUrl+'getactivityname',
			data: {'activity_cat_id':activity_cat_id},
			success: function(res){
				jQuery(".activity_name").html(res);
				jQuery(".activity_name").addClass("show_select");
			}
		});
	});
	
	// Get state name by country id.
	var country_id = jQuery(".country_id").val();
	jQuery.ajax({
		type:'POST',
		url: baseUrl+'getstatename',
		data: {'country_id':country_id},
		success: function(res){
			jQuery(".region_list").html(res);
			jQuery(".region_list").addClass("show_select");
		}
	});
	jQuery(".country_id").change(function(){
		var country_id = jQuery(this).val();
		jQuery.ajax({
			type:'POST',
			url: baseUrl+'getstatename',
			data: {'country_id':country_id},
			success: function(res){
				jQuery(".region_list").html(res); 
				jQuery(".region_list_hotel").html(res); 
				jQuery(".region_list_activity").html(res); 
				jQuery(".region_list").addClass("show_select"); 
			}
		});
	});
	
	// Get city name by state id.
	jQuery(".region_list").delegate('.state_name', 'change', function(){
		var region_id = jQuery(this).val();
		var country_id = jQuery('.country_id').val();
		jQuery.ajax({
			type:'POST',
			url: baseUrl+'getcityname',
			data: {'region_id':region_id, 'country_id':country_id},
			success: function(res){
				jQuery(".city_list").html(res);
				jQuery(".city_list").addClass("show_select");
			}
		});
	});
	
	// Get city name by state id.
	jQuery(".get_suc_cat").delegate('.city_name', 'change', function(){
		var country_id = jQuery('.country_id').val();
		var region_id = jQuery('#region_id').val();
		var city_id = jQuery(this).val();
		var activity_cat_id = jQuery('.activity_cat_id').val();
		var activity_name_id = jQuery('#activity_name_id').val();
		jQuery.ajax({
			type:'POST',
			url: baseUrl+'getactivitysubcat',
			data: {'country_id':country_id, 'region_id':region_id, 'city_id':city_id, 'activity_cat_id':activity_cat_id, 'activity_name_id':activity_name_id},
			success: function(res){
				jQuery(".activity_subcat_list").html(res);
				jQuery(".activity_subcat_list").addClass("show_select");
			}
		});
	});
	
	// Get city name by state id.
	jQuery(".get_suc_cat").change(function(){
		var country_id = jQuery('.country_id').val();
		var region_id = jQuery('#region_id').val();
		var city_id = jQuery(this).val();
		var activity_cat_id = jQuery('.activity_cat_id').val();
		var activity_name_id = jQuery('#activity_name_id').val();
		jQuery.ajax({
			type:'POST',
			url: baseUrl+'getactivitysubcat',
			data: {'country_id':country_id, 'region_id':region_id, 'city_id':city_id, 'activity_cat_id':activity_cat_id, 'activity_name_id':activity_name_id},
			success: function(res){
				jQuery(".activity_subcat_list").html(res);
				jQuery(".activity_subcat_list").addClass("show_select");
			}
		});
	});
    
    
    // Get state name by country id.
    jQuery(".car_segment_id").change(function(){
        var car_segment_id = jQuery(this).val();
        jQuery.ajax({
            type:'POST',
            url: baseUrl+'getcarmodel',
            data: {'car_segment_id':car_segment_id},
            success: function(res){
                jQuery(".car_model_list").html(res);
                jQuery(".car_model_list").addClass("show_select");
            }
        });
    });
    
    // Get city name by state id.
    jQuery(".car_model_list").delegate('.car_model', 'change', function(){
        var car_model_id = jQuery(this).val();
        var car_segment_id = jQuery('.car_segment_id').val();
        jQuery.ajax({
            type:'POST',
            url: baseUrl+'getcarseats',
            data: {'car_model_id':car_model_id, 'car_segment_id':car_segment_id},
            success: function(res){
                jQuery(".car_seats_list").html(res);
                jQuery(".car_seats_list").addClass("show_select");
            }
        });
    });
    
    jQuery("#car_id").change(function(){
        var car_id = jQuery(this).val();
        jQuery.ajax({
            type:'POST',
            url: baseUrl+'ajaxgetCarDetail',
            cache: false,
            async:true,
            data: {'car_id':car_id},
            success: function(data){
                var data = JSON.parse(data);
                jQuery("#text_segment").html(data.car_segment.name);
                jQuery("#text_model").html(data.car_model.name);
                jQuery("#text_seats").html(data.car_seat.seats);
                jQuery("#car_segment_id").val(data.car_segment.id);
                jQuery("#car_model_id").val(data.car_model.id);
                jQuery("#car_seats_id").val(data.car_seat.id);
            }
        });
    });
	
	
	// Get hotels by city id
	jQuery("#get_hotels").change(function(){
		var city_id = jQuery(this).val();
		jQuery.ajax({
			type: 'post',
			url: baseUrlV+'ajaxgetHotelDetail',
			cache: false,
			async: true,
			data: {'city_id':city_id},
			success: function(res){
				jQuery(".hotel_list").html(res);
				jQuery(".hotel_list").addClass("show_select");
			}
		});
	});
	
	
	
	// Get hotels room type by hotel id
	jQuery(".hotel_list").delegate('#hotel_id', 'change', function(){
		var hotel_id = jQuery(this).val();
		jQuery.ajax({
			type: 'post',
			url: baseUrlV+'ajaxgetHotelRoomTypeDetail',
			cache: false,
			async: true,
			data: {'hotel_id':hotel_id},
			success: function(res){
				jQuery(".room_type_list").html(res);
				jQuery(".room_type_list").addClass("show_select");
			}
		});
	});
	
	
});

// Get hotel rate
function hotelRate(){
		$.ajaxSetup({
			headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var hotel_id = jQuery("#hotel_id").val();
		var room_type = jQuery("#room_type").val();
		var date = jQuery("#date").val();
		var meal_plan = jQuery("#meal_plan").val();
		var no_of_room = jQuery("#no_of_room").val();
		var no_of_night = jQuery("#no_of_night").val();
		var adult = jQuery("#adult").val();
		var child = jQuery("#child").val();
		if(hotel_id != ""){
			jQuery(".loader_box").show();
		  $.ajax({
			url: "ajaxgetHotelRate",
			type:"post",
			cache: false,
			async:false,
			data: {'hotel_id':hotel_id,'room_type':room_type,'date':date,'meal_plan':meal_plan, 'no_of_night':no_of_night, 'no_of_room':no_of_room, 'adult':adult, 'child':child},
			success: function(data){
				var data = JSON.parse(data);
				jQuery("#hotel_price").text(data.price);
				jQuery(".hotel_img_area img").attr("src",data.hotel_image);
				console.log(data);    
				jQuery(".loader_box").hide();
				if(data.status == 0){
					jQuery(".moreroomselect").show();
				}else{
					jQuery(".moreroomselect").hide();
				}
			}
		  });
		}
}


function change_status(id, table){
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  $.ajax({
    url: "ajaxChangeStatus",
    type:"post",
    cache: false,
    async:false,
    data: {'id':id,'table':table},
    success: function(data){
        var    data = JSON.parse(data);
           alert(data.msg);       
    }
  });   
}


function change_approvel(id, table){
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  $.ajax({
    url: "ajaxChangeApprovel",
    type:"post",
    cache: false,
    async:false,
    data: {'id':id,'table':table},
    success: function(data){
        var    data = JSON.parse(data);
           alert(data.msg);       
    }
  });   
}