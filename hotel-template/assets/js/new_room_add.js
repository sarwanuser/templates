function add_card_ep(id){
		jQuery('#ep_price_'+id).css('display','block');
		jQuery('#select-room-classic_'+id).css('display','none');
		jQuery('#room_ep_detail_'+id).css('display','block');
		// jQuery('.room_no1').text(1);
		//jQuery('#epprice').val(2599);
		jQuery('#epprice_text_'+id).text(id);
		jQuery('#eppricenmrg_text_'+id).text(jQuery('#eppricenmrg_'+id).val());
		var htmlLoad = `<div class="row row_id" id="room_no_det_1">
                            <div class="col-sm-4"><span class="meal_type_des">Room <b>1</b></span> </div>
                            <div class="col-sm-4">
                                <label class="meal_type_des adults_label" style="width: 30%;">Adults</label>
                               <select class="form-control meal_type_des adults_kids" name="adults" id="adults_1" style="width: 70%;">
                                   <option value="1">1</option>
                                   <option value="2" selected>2</option>
                                   <option value="3">3</option>
                               </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="meal_type_des adults_label" style="width: 30%;">Kids</label>
                               <select class="form-control meal_type_des adults_kids" name="kids" id="kids_1" style="width: 70%;">
                                    <option value="">Kids</option>
                                   <option value="1">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                               </select>
                            </div>
                        </div>`;
		var btnplus=`<span class="minus_count" onclick="minusCounter(${id});">
                        <i class="icon-minus-circled"></i>
                    </span>
                    <span class="no_counter" id="room_no1_${id}">
                        1
                    </span>
                    <input type="hidden" class="hide_input" name="classic_room_only" value="0">
                    <input type="hidden" class="hide_price" name="classic_room_only_price" value="0">
                    <input type="hidden" class="hide_adult" id="classic_room_only_hide_adult_id" name="classic_room_only_adult" value="0">
                    <input type="hidden" class="hide_kids" id="classic_room_only_hide_kids" name="classic_room_only_kids" value="0">
                    <span class="plus_count" onclick="plusCounter(${id});">
                        <i class="icon-plus-circled"></i>
                    </span>`;          

      jQuery('#room_ep_detail_'+id).append(htmlLoad);
      jQuery('#ep_price_'+id).html(btnplus);   
	// }else{
	// 	jQuery('#ep_price_'+id).css('display','block');
	// 	jQuery('#select-room-classic_'+id).css('display','none');
	// 	jQuery('#room_ep_detail_'+id).css('display','block');
	// }
}
var id = 2;
function plusCounter(i){
	//alert(jQuery('.room_no1').text());
	if(jQuery('#room_no1_'+i).text() >0){
		var id=jQuery('#room_no1_'+i).text();
		var epprice=parseInt(jQuery('#epprice_'+i).val());
		var epprice_mrg=parseInt(jQuery('#eppricenmrg_'+i).val());
		id++;
		var val=epprice * id;
		var val_mrg=epprice_mrg * id;
		jQuery('#room_no1_'+i).text(id);
		// jQuery('#epprice').val(val);
		jQuery('#epprice_text_'+i).text(val);
		jQuery('#eppricenmrg_text_'+i).text(val_mrg);
		var htmlLoad = `<div class="row row_id" id="room_no_det_${id}">
		                <div class="col-sm-4"><span class="meal_type_des">Room <b>${id}</b></span> </div>
		                <div class="col-sm-4">
		                    <label class="meal_type_des adults_label" style="width: 30%;">Adults</label>
		                   <select class="form-control meal_type_des adults_kids" name="adults" id="adults_${id}" style="width: 70%;">
		                       <option value="1">1</option>
		                       <option value="2" selected>2</option>
		                       <option value="3">3</option>
		                   </select>
		                </div>
		                <div class="col-sm-4">
		                    <label class="meal_type_des adults_label" style="width: 30%;">Kids</label>
		                   <select class="form-control meal_type_des adults_kids" name="kids" id="kids_${id}" style="width: 70%;">
		                        <option value="">Kids</option>
		                       <option value="1">1</option>
		                       <option value="2">2</option>
		                       <option value="3">3</option>
		                   </select>
		                </div>
		            </div>`;
		            

      	$('#room_ep_detail_'+i).append(htmlLoad); 
	}
	    
}
function minusCounter(id){
	var room_no=jQuery('#room_no1_'+id).text();
	var price=parseInt(jQuery('#epprice_text_'+id).text());
	var pricmrge=parseInt(jQuery('#eppricenmrg_text_'+id).text());
	var price_pe= price / room_no;
	var pricemrg=pricmrge/room_no;
	jQuery('#room_no_det_'+room_no).remove();
	 // $('#ep_price_'+id).remove();
	room_no--;
	jQuery('#room_no1_'+id).text(room_no);
	//jQuery('#epprice').val(price_pe * room_no);
	jQuery('#epprice_text_'+id).text(price_pe * room_no);
	jQuery('#eppricenmrg_text_'+id).text(pricemrg * room_no);
	if(room_no == 0){
		jQuery('#room_ep_detail_'+id).html('');
		jQuery('#ep_price_'+id).css('display','none');
		jQuery('#epprice_text_'+id).text(jQuery('#epprice_'+id).val());
		jQuery('#eppricenmrg_text_'+id).text(jQuery('#eppricenmrg_'+id).val());
		jQuery('#select-room-classic_'+id).css('display','inline-block');
	}
}