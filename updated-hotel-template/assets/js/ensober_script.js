
jQuery(document).ready(function(){
	
	// This is for update the price by select meal plane.
	jQuery(".check_meal_type").change(function(){
		var offer_price = jQuery(this).attr('offer_price');
		var total_price = jQuery(this).attr('total_price');
		jQuery(this).parents(".strip_all_tour_list").find(".total_price").text(total_price);
		jQuery(this).parents(".strip_all_tour_list").find(".offer_price").text(offer_price);
		
		console.log("offer_price: "+offer_price);
		console.log("total_price: "+total_price);
		
		var discount_per = (total_price-offer_price)/total_price*100;
		discount_per = discount_per.toFixed(0);
		console.log("discount_per: "+discount_per);
		jQuery(this).parents(".strip_all_tour_list").find(".discount_per").text(discount_per);
	});
});