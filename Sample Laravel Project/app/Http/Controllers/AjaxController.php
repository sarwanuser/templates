<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse; 

use DB;
use Storage;
 
use App\Admin;
use App\Vender;
use App\Hotel;
use App\Operator;
use App\HotelGallery;
use App\HotelAmenity;
use App\Amenity;
use App\RoomCategory;
use App\HotelSeasonRate;
use App\PaidAmenity;
use App\HotelGroupSeasonRate;
use App\ActivityCat;
use App\ActivityName;
use App\ActivitySubCat;
use App\Country;
use App\Region;
use App\City;
use App\Lead;
use App\Quotation;
use App\Sale;
use App\RoomTypes;
use App\Car;
use App\CarSegment;
use App\CarModel;
use App\CarSeats;
use App\AssignContacts;
use App\Contacts;
use App\BulkEmailSendReport;
use App\BulkEmailSend;
use App\EmailTemplat;
use App\EmailCampaign;
use App\EmailList;
use App\Transport;
use App\Via;
use App\Activity;
use App\DayWiseDetail;
use App\ITIRoute;
use App\ITIBasicInfo;
use App\ITITransport;
use App\ITIHotel;
use App\ITIActivity;
use App\ITIPrice;
use App\ITIDayWiseItinerary;
use App\ITIActivitiPriceList;
use App\ITIHotelPriceList;
use App\ITITranportPriceList;

use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
	
	public function showhotel(Request $request)
    {       
        try {
            $hotel = Hotel::findOrFail($request->id);
            //$amenities = Amenity::All();
            //$hotelamenity = HotelAmenity::where('hotel_id', $request->id)->get();
            $hotelamenity = HotelAmenity::select('name')
                            ->join('amenities', 'amenities.id', '=', 'hotel_amenities.amenity_id')
                            ->where('hotel_amenities.hotel_id', $request->id)
                            ->get();
            $hotelroomcategoires = RoomCategory::where('hotel_id', $request->id)->get(); 
            $hotelgalleries = HotelGallery::where('hotel_id', $request->id)->get(); 
           echo json_encode(array('hotel'=>$hotel,'hotelamenity'=>$hotelamenity,'hotelroomcategoires'=>$hotelroomcategoires,'hotelgalleries'=>$hotelgalleries));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	/**
	 * This function use for get activity name by activity cat id
	 *
	 * @return html
	 */
	public function getActivityNameByACatID(Request $request){
		$ActivityNames = ActivityName::where('activity_cat_id', $request->activity_cat_id)->where('status', 'ACTIVE')->get();
		$html = '<label>Activity Name</label><select name="activity_name_id" class="validate invalid activity_name" aria-required="true" id="activity_name_id"><option value="">Select Activity Name</option>';
		foreach($ActivityNames as $ActivityName){
			$html .= '<option value="'.$ActivityName->id.'">'.$ActivityName->activity_name.'</option>';
		}
		$html .= "</select>";
		echo $html;
	}
	
	/**
	 * This function use for send sms by fast2sms 
	 *
	 * @return array
	 */
	public function sendSMS($otp, $mobile){
		
		
		$fields = array(
			"sender_id" => "ENSOBE",
			"message" => "OTP IS: $otp",
			"language" => "english",
			"route" => "p",
			"numbers" => $mobile,
		);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($fields),
		  CURLOPT_HTTPHEADER => array(
			"authorization: yRtz8IAjqOlZB5mdUCT7ngWVav3uNeK91ikLJDpFbhwfHSQMY6siXlfI462YaSLV09zpeQhjHRUBkwuC",
			"accept: */*",
			"cache-control: no-cache",
			"content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		
		$response = json_decode($response);
		
		if($response->return === true){
			return $response->message[0];
		}else{
			return $response->message;
		}
		
	}
	
	public function verifyUser(Request $request){
		$otp = '7656';
		$mobile = $request->verify_number;
		$itinerary_no_val = $request->itinerary_no_val;
		$this->itiBasicInfoAddOTP($itinerary_no_val, $otp);
		$status = $this->sendSMS($otp, $mobile);
		echo $status;
	}

	
	/**
	 * This function use for get state name by country id
	 *
	 * @return html
	 */
	public function getStateNameByCountryID(Request $request){
		$RegionNames = Region::where('country_id', $request->country_id)->where('status', 'ACTIVE')->get();
		$html = '<label>State</label><select id="region_id" name="region_id" class="validate invalid state_name" aria-required="true"><option value="">Select State</option>';
		foreach($RegionNames as $RegionName){
			$html .= '<option value="'.$RegionName->id.'">'.$RegionName->name.'</option>';
		}
		$html .= "</select>";
		echo $html;
	}
	
	/**
	 * This function use for get city name by state id
	 *
	 * @return html
	 */
	public function getCityNameByStateID(Request $request){
		$CityNames = City::where('country_id', $request->country_id)->where('region_id', $request->region_id)->where('status', 'ACTIVE')->get();
		$html = '<label>City</label><select id="city_id" name="city_id" class="validate invalid city_name " aria-required="true"><option value="">Select City</option>';
		foreach($CityNames as $CityName){
			$html .= '<option value="'.$CityName->id.'">'.$CityName->name.'</option>';
		}
		$html .= "</select>";
		echo $html;
	}
	
	/**
	 * This function use for get city name by state id
	 *
	 * @return html
	 */
	public function getActivitySubCat(Request $request){
		//$ActivitySubCats = ActivitySubCat::where('activity_cat_id', $request->activity_cat_id)->where('activity_name_id', $request->activity_name_id)->where('country_id', $request->country_id)->where('region_id', $request->region_id)->where('city_id', $request->city_id)->where('status', 'ACTIVE')->get();
		
		$ActivitySubCats = ActivitySubCat::where('activity_cat_id', $request->activity_cat_id)->where('status', 'ACTIVE')->get();
		$html = '<label>Activity Sub Cat</label><select id="activity_subcat_id" name="activity_subcat_id" class="validate invalid activity_subcat_id" aria-required="true"><option value="">Select Activity Sub Cat</option>';
		foreach($ActivitySubCats as $ActivitySubCat){
			$html .= '<option value="'.$ActivitySubCat->id.'">'.$ActivitySubCat->activity_subcat.'</option>';
		}
		$html .= "</select>";
		echo $html;
	}
    
    public function GetMobile(Request $request){
        $mobiles = Lead::where('mobile','like', '%'. $request->keyword.'%')->get();
        $html = '';
        if(!empty($mobiles)) {
            $html ='<ul id="mobile-list">';
        foreach($mobiles as $mobile){
            $html .='<li onClick="selectMobile('.$mobile->mobile.');">'.$mobile->mobile.'</li>';
        }
        $html .= '</ul>';
        }
        
        if($html==''){
                echo json_encode(array('status'=>false,'html'=>$html));
            }else{
                echo json_encode(array('status'=>true,'html'=>$html));
            }
       
    }

public function GetLeadDetail(Request $request){
        $lead = Lead::where('mobile',$request->mobile)->orderBy('id', 'DESC')->first();
        
        $RegionNames = Region::where('country_id', $lead->country_id)->where('status', 'ACTIVE')->get();
        $region_html = '<label>State</label><select id="region_id" name="region_id" class="validate invalid state_name" aria-required="true"><option value="">Select State</option>';
        foreach($RegionNames as $RegionName){
                 if($RegionName->id == $lead->region_id){ $regin_selected = "selected"; }else{ $regin_selected =""; }
            $region_html .= '<option value="'.$RegionName->id.'" '.$regin_selected.'>'.$RegionName->name.'</option>';
        }
        $region_html .= "</select>";
        
        $CityNames = City::where('country_id', $lead->country_id)->where('region_id', $lead->region_id)->where('status', 'ACTIVE')->get();
        $city_html = '<label>City</label><select id="city_id" name="city_id" class="validate invalid city_name " aria-required="true"><option value="">Select City</option>';
        foreach($CityNames as $CityName){
            if($CityName->id == $lead->city_id){ $city_selected = "selected"; }else{ $city_selected =""; }
            $city_html .= '<option value="'.$CityName->id.'" '.$city_selected.'>'.$CityName->name.'</option>';
        }
        $city_html .= "</select>";

        echo json_encode(array('lead'=>$lead,'region_html'=>$region_html,'city_html'=>$city_html));
    }
        
 public function ChangeStatus(Request $request)
    {       
        try {
			$table = 'App\\'.$request->table;
			
            $post = $table::where('id', $request->id)->first(); 
            if($post->status == 'ACTIVE'){
              $data = array("status"=>'INACTIVE',"updated_at"=> date('Y-m-d H:i:s'));
            }else{
              $data = array("status"=>'ACTIVE',"updated_at"=> date('Y-m-d H:i:s'));
            }
            
            $update = $table::where('id', $request->id)->update($data);
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Status is updated'));
            }else{
                echo json_encode(array('status'=>fasle,'msg'=>'Status is not updated'));
            }
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    
    public function MakeQuatation(Request $request){
        
        $quotation = Quotation::where('lead_id', $request->id)->get();
        $quotation_count = $quotation->count();
            if($quotation_count==0){
                try {
        
                $lead = Lead::where('id', $request->id)->first(); 
                $data=array("lead_no"=>$lead->lead_no,
                            "lead_id"=>$lead->id,
                            "hotel_id"=>$lead->hotel_id,
                            "mobile"=>$lead->mobile,
                            "email"=>$lead->email,
                            "name"=>$lead->name,
                            "location"=>$lead->location,
                            "customer_type"=>$lead->customer_type,
                            "lead_priority"=>$lead->lead_priority,
                            "trip_type"=>$lead->trip_type,
                            "hotel_type"=>$lead->hotel_type,
                            "city_id"=>$lead->city_id,
                            "region_id"=>$lead->region_id,
                            "country_id"=>$lead->country_id,
                            "start_date"=>$lead->start_date,
                            "end_date"=>$lead->end_date,  
                            "no_nights"=>$lead->no_nights,  
                            "no_room"=>$lead->no_room,  
                            "sharing"=>$lead->sharing,  
                            "pax"=>$lead->pax,  
                            "kids"=>$lead->kids,  
                            "infant"=>$lead->infant,  
                            "create_date"=>$lead->create_date, 
                            "assign_to" => $lead->assign_to,
                            "status"=>'ACTIVE',  
                            "quotation_status"=>'QUOTATION');
                Quotation::create($data);
               $updatedata = array("lead_status"=>'QUOTATION',"make_quatation"=>'1',"updated_at"=> date('Y-m-d H:i:s'));
               $update = Lead::where('id', $lead->id)->update($updatedata);
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Quatation is made. Please See Quatation Page'));
            }else{
                echo json_encode(array('status'=>false,'msg'=>'Quatation is made. But Status is not Updated'));
            }
                
                } catch (ModelNotFoundException $e) {
            return $e;
        }
            
            }else{
                $updatedata = array("lead_status"=>'QUOTATION',"make_quatation"=>'1',"updated_at"=> date('Y-m-d H:i:s'));
                $update = Lead::where('id', $request->id)->update($updatedata);
                echo json_encode(array('status'=>false,'msg'=>'Quatation is already made. Please check in Quatation Page.'));
            }
        
    }
 
 public function MakeSale(Request $request){
        
        $sale = Sale::where('quotation_id', $request->id)->get();
        $sale_count = $sale->count();
            if($sale_count==0){
                try {
        
                $Quotation = Quotation::where('id', $request->id)->first(); 
                if((int)$Quotation->price > 0){
                $data=array("quotation_id"=>$Quotation->id,
                            "lead_id"=>$Quotation->lead_id,
                            "operator_id"=>$Quotation->assign_to,
                            "total_amount"=>$Quotation->price
                            );
                Sale::create($data);
               $updatedata = array("quotation_status"=>'SALE',"make_sale"=>'1',"updated_at"=> date('Y-m-d H:i:s'));
               $update = Quotation::where('id', $Quotation->id)->update($updatedata);
                if($update){
                        echo json_encode(array('status'=>true,'msg'=>'Sale is made. Please See Sale Page'));
                    }else{
                        echo json_encode(array('status'=>true,'msg'=>'Sale is made. But Status is not Updated'));
                    }
                 }else {
                     echo json_encode(array('status'=>false,'msg'=>'Please Enter the Quotation price greater than Zero'));
                 }
                        
                } catch (ModelNotFoundException $e) {
                     return $e;
                 }
            
            }else{
                $updatedata = array("quotation_status"=>'SALE',"make_sale"=>'1',"updated_at"=> date('Y-m-d H:i:s'));
                $update = Quotation::where('id', $request->id)->update($updatedata);
                echo json_encode(array('status'=>true,'msg'=>'Sale is already made. Please check in Sale Page.'));
            }
        
    }
    
    public function SearchHotel(Request $request){
        $query = Hotel::query();
        if($request->hotel_name!=''){
          $query->where('hotel_name','like', '%'. $request->hotel_name.'%');
        }
        if( $request->country_id!=''){
          $query->where('country_id', $request->country_id );
        }
        if($request->region_id!=''){
        $query->where('region_id', $request->region_id );
        }
        if($request->city_id!=''){
         $query->where('city_id', $request->city_id );
        }          
        $hotels = $query->orderBy('id' , 'desc')->get();
                        
        $hotel_count = $hotels->count();
        if($hotel_count>0){
            $html ='';
            foreach($hotels as $hotel){
                 if($hotel->vender_approved==0) { $vender_approved = 'Vender Not Approved'; }else { $vender_approved='';}
                     
                  $html .= '<div class="col s4 hotel_item">
                    <div id="basic-form" class="card card card-default scrollspy">
                       <div > '.$vender_approved.'</div>
                        <div class="hotel_img">
                            <img src="'. url('/storage/app/'.$hotel->hotel_image) .'" class="img-responsive" />
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">'. $hotel->hotel_name.'</h3>
                            <div class="Hotel_description">
                                <p>'.$hotel->address.'</p>
                            </div>
                            
                            <div class="button_area">
                            <form action="'. route('hotel.destroy', $hotel->id).'" method="POST" style="display: inline-block;vertical-align: top;">
                        '.csrf_field() .'
                               <input type="hidden" name="_method" value="DELETE">
                                <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange car_delete gradient-shadow" title="Delete" onclick="return confirm(\'Are you sure?\')">
                                    <i class="material-icons">delete_sweep</i>
                                </button>
                                </form>
                                <a href="'.url('admin/viewhotel/'.$hotel->id) .'" )">
                                <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan car_delete gradient-shadow" >
                                    <i class="material-icons">remove_red_eye</i>
                                </button>
                                </a>
                                <a href="'. route('hotel.edit',$hotel->id) .'">
                                    <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-green-teal gradient-shadow"><i class="material-icons">brush</i></button>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>';
                
            }
            echo json_encode(array('status'=>true,'html'=>$html));

        }else{
            echo json_encode(array('status'=>false,'html'=>'Please search different criteria'));

        }
                      
    }
    
    public function VenderSearchHotel(Request $request){
        $query = Hotel::query();
        if($request->hotel_name!=''){
          $query->where('hotel_name','like', '%'. $request->hotel_name.'%');
        }
        if( $request->country_id!=''){
          $query->where('country_id', $request->country_id );
        }
        if($request->region_id!=''){
        $query->where('region_id', $request->region_id );
        }
        if($request->city_id!=''){
         $query->where('city_id', $request->city_id );
        } 
        if($request->hotel_name!='' || $request->country_id!='' || $request->region_id!='' || $request->city_id!=''){
          $query->where('vender_id', $request->vender_id );  
        }         
        $hotels = $query->orderBy('id' , 'desc')->get();
                        
        $hotel_count = $hotels->count();
        if($hotel_count>0){
            $html ='';
            foreach($hotels as $hotel){
                  $html .= '<div class="col s4 hotel_item">
                    <div id="basic-form" class="card card card-default scrollspy">
                        <div class="hotel_img">
                            <img src="'. url('/storage/app/'.$hotel->hotel_image) .'" class="img-responsive" />
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">'. $hotel->hotel_name.'</h3>
                            <div class="Hotel_description">
                                <p>'.$hotel->address.'</p>
                            </div>
                            
                            <div class="button_area">
                            <form action="'. route('hotels.destroy', $hotel->id).'" method="POST" style="display: inline-block;vertical-align: top;">
                        '.csrf_field() .'
                               <input type="hidden" name="_method" value="DELETE">
                                <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange car_delete gradient-shadow" title="Delete" onclick="return confirm(\'Are you sure?\')">
                                    <i class="material-icons">delete_sweep</i>
                                </button>
                                </form>
                                <a href="'.url('vender/viewhotel/'.$hotel->id) .'" )">
                                <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan car_delete gradient-shadow" >
                                    <i class="material-icons">remove_red_eye</i>
                                </button>
                                </a>
                                <a href="'. route('hotels.edit',$hotel->id) .'">
                                    <button class="mb-6 btn-floating waves-effect waves-light gradient-45deg-green-teal gradient-shadow"><i class="material-icons">brush</i></button>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>';
                
            }
            echo json_encode(array('status'=>true,'html'=>$html));

        }else{
            echo json_encode(array('status'=>false,'html'=>'Please search different criteria'));

        }
                      
    }
    
    public function GetSeasonRate(Request $request){
		DB::enableQueryLog();
       $hotelseasonrate = HotelSeasonRate::where('start_date','<=', $request->date)
                                            ->where('end_date','>=', $request->date)
                                            ->where('status', 'ACTIVE')
                                            ->where('hotel_id',$request->id)
                                            ->where('room_type_id',$request->room_type_id)
                                            ->orderBy('id', 'DESC')->first();
		//return DB::getQueryLog(); 
		if($hotelseasonrate){
			$hotelseasonrate_count = $hotelseasonrate->count();
		}else{
			$hotelseasonrate_count = 0;
		}
        
        if($hotelseasonrate_count>0){
            echo json_encode(array('status'=>true,'hotelseasonrate'=>$hotelseasonrate));

        }else{
            echo json_encode(array('status'=>false,'hotelseasonrate'=>''));

        } 
    }
	
	public function GetHotelSeasonRate(Request $request){
		DB::enableQueryLog(); 
		
		// date time convert
		if($request->has('arrival_date_time')){
			$request->arrival_date = date('Y-m-d', strtotime($request->arrival_date_time));
		}
		
		$hotel = Hotel::where('id', $request->hotel_id)->first();
		
		$hotelseasonrate = HotelSeasonRate::select($request->meal_plan)->where('start_date','<=', $request->arrival_date)->where('end_date','>=', $request->arrival_date)->where('status', 'ACTIVE')->where('hotel_id',$request->hotel_id)->where('room_type_id',$request->room_type)->orderBy('id', 'DESC')->first();
		
	   
		if($hotelseasonrate == null){
			$data = array("status" => 0, "hotel" => $hotel, 'message' => 'Rate not added in given data range!'); 
			echo json_encode($data);
			exit;
		}
		
		$child_extra_cost = $hotel->child_extra_cost;
		$adult_extra_cost = $hotel->adult_extra_cost;
		$price = $hotelseasonrate[$request->meal_plan];
		$child_cost = $price*$child_extra_cost/100;
		$adult_cost = $price*$adult_extra_cost/100;
		$totle_room_cost = $price*$request->no_of_room;
		$total_able_adult = $request->no_of_room*2;
		if($request->adult > $total_able_adult){
			$no_adult = $request->adult - $total_able_adult;
			$total_adult_cost = $no_adult*$adult_cost;
			$total_child_cost = $request->child*$child_cost;
		}else{
			$no_adult = $request->adult - $total_able_adult;
			$total_adult_cost = 0;
			$total_child_cost = $no_adult+$request->child*$child_cost;
		}
		
		$total_price = $totle_room_cost+$total_adult_cost+$total_child_cost;
		
		$hotel_name = $hotel['hotel_name'];
		$hotel_id = $hotel['id'];
		
		$hotel_image = '/storage/app/'.$hotel['hotel_image']; 
		
		$total_night_price = $total_price*$request->no_of_night;
		
		$hotel_link = "/admin/viewhotel/".$hotel_id;
		
		$maximum_peoples = $request->no_of_room*4;
		$totle_peoples = $request->adult+$request->child;
		
		if($totle_peoples <= $maximum_peoples){
			$data = array("status" => 1, "hotel_name" => $hotel_name, "hotel_id" => $hotel_id, "hotel_link" => $hotel_link, "hotel_image" => $hotel_image, "price" => $total_night_price);

			// Save Itinerary Hotel
			ITIHotel::where('itinerary_no', $request->itinerary_no_val)->where('distination', $request->distination)->delete();
            ITIDayWiseItinerary::where('itinerary_no', $request->itinerary_no_val)->where('distination', $request->distination)->where('pickup','0')->where('dropup','0')->delete();

			$savedata=array(
			"itinerary_no"=>$request->itinerary_no_val,
			"distination"=>$request->distination,
			"hotel"=>$request->hotel_id,
			"room_type"=>$request->room_type,
			"meal_plan"=>$request->meal_plan,
			"no_of_rooms"=>$request->no_of_room,
			"no_of_nights"=>$request->no_of_night,
			"arrival_date"=>$request->arrival_date,
			"rate"=>$total_night_price);
			$update = ITIHotel::create($savedata); 

            // Get day wise details
            $daywisedetals = DayWiseDetail::where('distination', $request->distination)->where('day', $request->no_of_night)->get();
           
			foreach($daywisedetals as $daywise){
                $total_day = ITIDayWiseItinerary::where('itinerary_no', $request->itinerary_no_val)->count();
                // For change the destination day count 
                if($total_day > 2){
                    $c_desdi = ITIDayWiseItinerary::where('itinerary_no', $request->itinerary_no_val)->where('change_des','1')->count();
                    $total_day = $total_day-$c_desdi;
                }
                $route = ITIRoute::where('itinerary_no', $request->itinerary_no_val)->where('start_distination', $request->distination)->first(); 
                
                // Change the dynamic data
                $HOTELDESTI = $this->getCityNameById($request->distination);
                $HOTELNAME = $hotel_name;
                $MEALPLANE = $this->getMealFullNameByCode($request->meal_plan);
                
                if($route){
                    $PICKLOCA = $this->getCityNameById($request->distination);
                    $DROPLOCA = $this->getCityNameById(@$route->to_distination);
                    $DISTACE = $route->distance.' KM';
                    $DURATION = $route->duration; 
                }else{
                    $PICKLOCA = '';
                    $DROPLOCA = '';
                    $DISTACE = '';
                    $DURATION = ''; 
                }
                

                $daywisedesc = $this->changeDynamicData($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION, $HOTELDESTI, $HOTELNAME, $MEALPLANE, $daywise->description);
                
                $daywisedata=array(
                    "itinerary_no"=>$request->itinerary_no_val,
                    "day"=>$total_day-1,
                    "image"=>$daywise->image,
                    "distination"=>$request->distination,
                    "description"=>$daywisedesc,
                    "change_des"=>$daywise->change_des
                );
                //if($daywise->change_des != 1 || ($PICKLOCA != '' && $DROPLOCA != '')){
                    ITIDayWiseItinerary::create($daywisedata);
               // }
            }
			//return DB::getQueryLog(); 
		}else{
			$data = array("status" => 0, "hotel_name" => $hotel_name, "hotel_id" => $hotel_id, "hotel_link" => $hotel_link, "hotel_image" => $hotel_image, "price" => 0, 'message' => 'Minimum Rooms requirement not matching, please add more rooms!'); 
			
			//Minimum 4 rooms to be selected for 12 adults
		}
		
		
		
		echo json_encode($data);
		
    }
	
	// Regenerate day wise itinerary 
	public function regenerateDayWiseIti($itinerary_no){
		ITIDayWiseItinerary::where('itinerary_no', $itinerary_no)->whereNotIn('day', [0,999])->delete();
		$hotels = ITIHotel::where('itinerary_no', $itinerary_no)->get();
		
		foreach($hotels as $hotel){
			$hotel_details = Hotel::where('id', $hotel->hotel)->first();
			// Get day wise details
			$daywisedetals = DayWiseDetail::where('distination', $hotel->distination)->where('day', $hotel->no_of_nights)->get();
		   
			foreach($daywisedetals as $daywise){
				$total_day = ITIDayWiseItinerary::where('itinerary_no', $itinerary_no)->count();
				// For change the destination day count 
				if($total_day > 2){
					$c_desdi = ITIDayWiseItinerary::where('itinerary_no', $itinerary_no)->where('change_des','1')->count();
					$total_day = $total_day-$c_desdi;
				}
				$route = ITIRoute::where('itinerary_no', $itinerary_no)->where('start_distination', $hotel->distination)->first(); 
				
				// Change the dynamic data
				$HOTELDESTI = $this->getCityNameById($hotel->distination);
				$HOTELNAME = $hotel_details->hotel_name;
				$MEALPLANE = $this->getMealFullNameByCode($hotel->meal_plan);
				
				if($route){
					$PICKLOCA = $this->getCityNameById($hotel->distination);
					$DROPLOCA = $this->getCityNameById(@$route->to_distination);
					$DISTACE = $route->distance.' KM';
					$DURATION = $route->duration; 
				}else{
					$PICKLOCA = '';
					$DROPLOCA = '';
					$DISTACE = '';
					$DURATION = ''; 
				}
				

				$daywisedesc = $this->changeDynamicData($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION, $HOTELDESTI, $HOTELNAME, $MEALPLANE, $daywise->description);
				
				$daywisedata=array(
					"itinerary_no"=>$itinerary_no,
					"day"=>$total_day-1,
					"image"=>$daywise->image,
					"distination"=>$hotel->distination,
					"description"=>$daywisedesc,
					"change_des"=>$daywise->change_des
				); 
				
				ITIDayWiseItinerary::create($daywisedata);
			}
		}
		
		echo "<center><b style='color:green'>Regenerated the daywise ititnerary successfully!</b></center><br><center><a href='".\URL::to('vender/itinerarymanage/'.$itinerary_no)."'><button type='button'>Go Back</button></a></center>";
	}
    
    public function GetRoomCategory(Request $request){
        $roomcategories = RoomCategory::select('room_type_id as id','id as room_category_id', 'room_type_id','type','name')->where('hotel_id', $request->hotel_id)->where('status', 'ACTIVE')->get();
        $roomcategories_count = $roomcategories->count();
        if($roomcategories_count>0){
            echo json_encode(array('status'=>true,'roomcategories'=>$roomcategories));
        }else{
            echo json_encode(array('status'=>false,'roomcategories'=>''));
        }
    }
    
     public function ChangeApprovel(Request $request)
    {       
        try {
            $table = 'App\\'.$request->table;
            
            $post = $table::where('id', $request->id)->first(); 
            if($post->vender_approved == 0){
              $data = array("vender_approved"=>'1',"updated_at"=> date('Y-m-d H:i:s'));
            }else{
              $data = array("vender_approved"=>'0',"updated_at"=> date('Y-m-d H:i:s'));
            }
            
            $update = $table::where('id', $request->id)->update($data);
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Data is updated'));
            }else{
                echo json_encode(array('status'=>fasle,'msg'=>'Data is not updated'));
            }
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    /**
     * This function use for get car model by car segmant id
     *
     * @return html
     */
    public function getCarModelByCarSegmentID(Request $request){
        $car_models = CarModel::where('car_segment_id', $request->car_segment_id)->get();
            $html = '<label for="car_model_id" class="">Car Model</label><select id="car_model_id" name="car_model_id" class="validate invalid car_model" aria-required="true"><option value="">Select Car Model</option>';
        foreach($car_models as $car_model){
            $html .= '<option value="'.$car_model->id.'">'.$car_model->name.'</option>';
        }
        $html .= "</select>";
        echo $html;
    }
	
	
	/**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelsByCity(Request $request){
		DB::enableQueryLog();
        $hotels = Hotel::where('city_id', $request->city_id)->get();
		$que = DB::getQueryLog();
            $html = '<label for="hotel_id" class="active">Hotel</label><select id="hotel_id" name="hotel_id" class="validate invalid" aria-required="true" onchange="hotelRate();"><option value="">Select Hotel</option>';
        foreach($hotels as $hotel){
            $html .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.' ('.$hotel->start_category.' STAR)</option>';
        }
        $html .= "</select>";
        echo $html;
    }
	
	/**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelsByCityAw(Request $request){
		DB::enableQueryLog();
        $hotels = Hotel::where('city_id', $request->city_id)->get();
		$que = DB::getQueryLog();
            $html = '<label for="hotel_id" class="active">Hotel</label><select name="hotel_id" class="validate invalid hotel_id_aw" aria-required="true" onchange="hotelRateAW($(this));" id="hotel_id"><option value="">Select Hotel</option>';
        foreach($hotels as $hotel){
            $html .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.' ('.$hotel->start_category.' STAR)</option>';
        }
        $html .= "</select>";
        echo $html;
    }
	
	/**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelRoomTypeById(Request $request){
		DB::enableQueryLog();
        $roomtypes = RoomCategory::where('hotel_id', $request->hotel_id)->get();
		$que = DB::getQueryLog();
            $html = '<label for="room_type" class="active">Room Type</label><select id="room_type" name="room_type" class="validate invalid" aria-required="true" onchange="hotelRate();"><option value="">Select Room Type</option>';
        foreach($roomtypes as $roomtype){
            $html .= '<option value="'.$roomtype->room_type_id.'">'.$roomtype->type.' ('.$roomtype->name.')</option>';
        }
        $html .= "</select>";
        echo $html;
    }
	
	/**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelRoomTypeByIdAw(Request $request){
		DB::enableQueryLog();
        $roomtypes = RoomCategory::where('hotel_id', $request->hotel_id)->get();
		$que = DB::getQueryLog();
            $html = '<label for="room_type" class="active">Room Type</label><select id="room_type" name="room_type" class="validate invalid" aria-required="true" onchange="hotelRateAW($(this));"><option value="">Select Room Type</option>';
        foreach($roomtypes as $roomtype){
            $html .= '<option value="'.$roomtype->room_type_id.'">'.$roomtype->type.' ('.$roomtype->name.')</option>';
        }
        $html .= "</select>";
        echo $html;
    }
	
	
    
    /**
     * This function use for get car seats by car model id
     *
     * @return html
     */
    public function getCarSeatsByCarModelID(Request $request){ 
        $car_seats = CarSeats::where('car_model_id', $request->car_model_id)->where('car_segment_id', $request->car_segment_id)->get();
            
        $html = '<label for="car_seats_id" class="">Car Seats</label><select id="car_seats_id" name="car_seats_id" class="validate invalid car_seats " aria-required="true"><option value="">Select Car Seats</option>';
        foreach($car_seats as $car_seat){
            $html .= '<option value="'.$car_seat->id.'">'.$car_seat->seats.'</option>';
        }
        $html .= "</select>";
        echo $html;
    }
    
    /**
     * This function use for get car details by car id on tranport page
     *
     * @return data
     */
    public function getCarDetail(Request $request)
    {       
        try {
            $car = Car::findOrFail($request->car_id);
            $car_segment = CarSegment::where('id', $car->car_segment_id)->first();
            $car_model = CarModel::where('id', $car->car_model_id)->first();
            $car_seat = CarSeats::where('id', $car->car_seats_id)->first();
             echo json_encode(array('car_segment'=>$car_segment,'car_model'=>$car_model,'car_seat'=>$car_seat));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    
    /**
     * This function use for assiging the contacts value to assign_contacts tabel with opereator id
     *
     * @return data
     */
    public function AsignContacts(Request $request)
    {       
        try {
            $found_record = 0;
			
			if ( ($request->has('location') && $request->input('location')!= '') || ($request->has('contact_type') && $request->input('contact_type')!= '') || ($request->has('source') && $request->input('source')!= '') ) {
				$query = Contacts::query();
				if($request->has('location') && $request->input('location')!= ''){
					$query->where('location','like', '%'. $request->input('location').'%');
				}
				if( $request->has('contact_type') && $request->input('contact_type')!= ''){
					$query->where('contact_type', $request->input('contact_type') );
				}
				if( $request->has('source') && $request->input('source')!= ''){
					$query->where('source', $request->input('source') );
				}
				$Contacts = $query->with('asignContact')->where('assigned_status', 'UNASSIGNED')->where('status', 'ACTIVE')->orderBy('id' , 'desc')->get();
			}else{ 
				$Contacts = Contacts::with('asignContact')->where('assigned_status', 'UNASSIGNED')->where('status', 'ACTIVE')->orderBy('id' , 'desc')->get();
			}
			
			foreach($Contacts as $Contact){
				
				if($request->assign_contact_no > $found_record){
					// Save Data in Assign contact table
					$assign_contact = new AssignContacts();
					$assign_contact->mobile        =   $Contact->mobile;
					$assign_contact->email         =   $Contact->email;
					$assign_contact->name          =   $Contact->name;
					$assign_contact->location      =   $Contact->location;
					$assign_contact->contact_type      =   $Contact->contact_type;
					$assign_contact->category      =   $Contact->category;
					$assign_contact->website      =   $Contact->website;
					$assign_contact->additional_info      =   $Contact->additional_info;
					$assign_contact->agency_name      =   $Contact->agency_name;
					$assign_contact->source      =   $Contact->source;
					$assign_contact->contact_id      =   $Contact->id;
					$assign_contact->operator_id      =   $request->assign_to;
					$assign_contact->status        =   $Contact->status;
					$assign_contact->save(); 
					
					// Update the status of contact in contacts table
					$Contact->assigned_status = 'ASSIGNED';
					$Contact->save();
					
					
					$found_record++;
				}
            }
            $message = $found_record.' contacts successfully assigned.';
           echo json_encode(array('message'=>$message));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	/**
     * This function use for assiging the contacts value to assign_contacts tabel with opereator id
     *
     * @return data
     */
    public function AsignContacts_old(Request $request)
    {       
        try {
            $found_record = 0;
            $not_found = 0;
            if(!empty($request->contact_ids)){
                
                foreach($request->contact_ids as $contact_id){
                    
                    $assign_contact = AssignContacts::where('contact_id', $contact_id)->where('status', 'ACTIVE')->first();
                    if($assign_contact){
                        $found_record++;
                    }else{
                      $post = Contacts::findOrFail($contact_id);
                        if( $post ) {
                            $assign_contact = new AssignContacts();
                            $assign_contact->mobile        =   $post->mobile;
                            $assign_contact->email         =   $post->email;
                            $assign_contact->name          =   $post->name;
                            $assign_contact->location      =   $post->location;
                            $assign_contact->contact_type      =   $post->contact_type;
                            $assign_contact->category      =   $post->category;
                            $assign_contact->website      =   $post->website;
                            $assign_contact->additional_info      =   $post->additional_info;
                            $assign_contact->agency_name      =   $post->agency_name;
                            $assign_contact->source      =   $post->source;
                            $assign_contact->contact_id      =   $contact_id;
                            $assign_contact->operator_id      =   $request->assign_to;
                            $assign_contact->status        =   $post->status;
                            $assign_contact->save(); 
                            $not_found++;
                            }
                    }
                    
                } 
            }
            $message = $found_record.' contacts already assigned and '.$not_found.' contacts successfully assigned.';
           echo json_encode(array('message'=>$message));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	
	/**
     * This function use for assiging the contacts value to assign_contacts tabel with opereator id
     *
     * @return data
     */
    public function createCampaign(Request $request)
    {       
        try {
            $assign_contact = new EmailCampaign();
			$assign_contact->title        =   $request->title;
			$assign_contact->contact_ids  =   implode(',',$request->contact_ids);
			$assign_contact->sr_location  =   $request->location;
			$assign_contact->sr_contact_type    =   $request->contact_type;
			$assign_contact->sr_source    =   $request->source; 
			$assign_contact->save(); 
			foreach($request->contact_ids as $contact_id){
				$contact = Contacts::where('id', $contact_id)->first();
				$EmailList = new EmailList();
				$EmailList->email_campaign_id = $assign_contact->id;
				$EmailList->contact_id = $contact->id;
				$EmailList->co_name = $contact->name;
				$EmailList->co_email = $contact->email;
				$EmailList->co_mobile = $contact->mobile;
				$EmailList->status = 'ACTIVE';
				$EmailList->save();
			}
            $message = 'Email Campaign Create successfully!';
           echo json_encode(array('message'=>$message));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	
	/**
     * This function use for assiging the contacts value to assign_contacts tabel with opereator id
     *
     * @return data
     */
    public function AsignContactsByMobile(Request $request)
    {       
        try {
			$post = $request->all();
            if(!empty($request->mobile)){
				$contact = Contacts::where('mobile', $post['mobile'])->first();
				if( $contact ) {
					$assign_contact = new AssignContacts();
					$assign_contact->mobile        =   $contact->mobile;
					$assign_contact->email         =   $contact->email;
					$assign_contact->name          =   $contact->name;
					$assign_contact->location      =   $contact->location;
					$assign_contact->contact_type      =   $contact->contact_type;
					$assign_contact->category      =   $contact->category;
					$assign_contact->source      =   $contact->source;
					$assign_contact->contact_id      =   $contact->id;
					$assign_contact->operator_id      =   $post['assign_to'];
					$assign_contact->status        =   $contact->status;
					$assign_contact->save(); 
				}
            }
            $message = 'Contacts successfully assigned.';
           echo json_encode(array('message'=>$message));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	
	/**
     * This function use for assiging the contacts value to assign_contacts tabel with opereator id
     *
     * @return data
     */
    public function CreateContactAndAsignContacts(Request $request)
    {    
	
        try {
            $post = $request->all();
			$con_operator_id = $post['con_operator_id'];
			$contact = Contacts::where('mobile', $post['mobile'])->first();
			$returndata = '';
			if(!$contact){
				$post['status'] = 'ACTIVE'; 
				$res = Contacts::create( $post );
				$assign_contact = new AssignContacts();
				$assign_contact->mobile        =   $res->mobile;
				$assign_contact->email         =   $res->email;
				$assign_contact->name          =   $res->name;
				$assign_contact->location      =   $res->location;
				$assign_contact->contact_type      =   $res->contact_type;
				$assign_contact->category      =   $res->category;
				$assign_contact->source      =   $res->source;
				$assign_contact->contact_id      =  $res->id;
				$assign_contact->operator_id      =   $con_operator_id;
				$assign_contact->status        =   $res->status;
				$assign_contact->website        =   $res->website;
				$assign_contact->agency_name        =   $res->agency_name;
				$assign_contact->additional_info        =   $res->additional_info;
				$assign_contact->type        =   'CREATE';
				$returndata = $assign_contact->save(); 
				$msg = 'Contact Added Successfull!';
			}else{
				$msg = 'Mobile Number Already Exist!';
			}
           echo json_encode(['message'=>$msg, 'returndata' => $returndata]);
        } catch (ModelNotFoundException $e) {
            echo json_encode(['message'=> $e, 'returndata' => '']);
        }
    }
	
	
	/**
     * This function use check mobile number exist or not
     *
     * @return data
     */
    public function contactExist(Request $request)
    {    
	
        try {
            $post = $request->all();
			$contact = Contacts::where('mobile', $post['mobile'])->first();
			$asigncontact = AssignContacts::where('mobile', $post['mobile'])->first();
			
			if($contact){
				$msg = 'Mobile Number Already Exist!';
				$status = 1;
				$assmsg = '';
			}else{
				$msg = '';
				$status = 0;
				$assmsg = '';
			}
			
			if($asigncontact){
				$operator = Operator::findOrFail($asigncontact->operator_id);
				$asignmsg = 'Mobile Number Already Assigned!';
				$assmsg = 'Assigned TO:'.$operator->name;
				$asignstatus = 1;
			}else{
				$asignmsg = '';
				$assmsg = '';
				$asignstatus = 0;
			}
			
			
			
           echo json_encode(['message'=>$msg, 'assmsg'=>$assmsg, 'status' => $status, 'asignmsg' => $asignmsg, 'asignstatus' => $asignstatus]);
        } catch (ModelNotFoundException $e) {
            echo json_encode(['message'=> $e, 'status' => '', 'asignmsg' => '', 'asignstatus' => '']);
        }
    }
	
	
	// Itinerary Basic Info
	public function itiBasicInfo(Request $request){
        try {
			if($request->itinerary_no_val != ""){
				$itinerary_no_val = $request->itinerary_no_val;
			}else{
				$itinerary_no_val = rand(100000,999999);
			}
			// date time convert
			if($request->has('arrival_date_time')){
				$request->arrival_date = date('Y-m-d', strtotime($request->arrival_date_time));
				$request->arrival_time = date('H:i:s', strtotime($request->arrival_date_time));
				
				$request->drop_date = date('Y-m-d', strtotime($request->drop_date_time));
				$request->drop_time = date('H:i:s', strtotime($request->drop_date_time));
			}
			
            // Total Niight
            $tnight = $this->difToDate($request->arrival_date, $request->drop_date);
			$data=array(
				"itinerary_no"=>$itinerary_no_val,
				"adult"=>$request->adult,
				"kids"=>$request->kids,
				"infant"=>$request->infant,
				"tour_type"=>$request->tour_type,
				"arrival_date"=>$request->arrival_date,
				"arrival_time"=>$request->arrival_time,
				"arrival_city"=>$request->arrival_city,
				"drop_date"=>$request->drop_date,
				"drop_time"=>$request->drop_time,
				"drop_city"=>$request->drop_city,
				"rate_show"=>$request->rate_show,
				"name"=>$request->name,
				"mobile"=>$request->mobile,
				"comment"=>$request->comment,
				"total_night"=>$tnight,
				"created_by"=>'??');
				
				if($request->itinerary_no_val != ""){
					$update = ITIBasicInfo::where('itinerary_no', $itinerary_no_val)->update($data);
				}else{
					$update = ITIBasicInfo::create($data);
				}
				
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Save', 'itinerary_no'=>$itinerary_no_val));
            }else{
                echo json_encode(array('status'=>false,'msg'=>'Not Save'));
            }
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	// Itinerary Basic Info Update OTP
	public function itiBasicInfoAddOTP($itinerary_no_val,$otp){
        try {
			$data=array("otp"=> $otp);
			$update = ITIBasicInfo::where('itinerary_no', $itinerary_no_val)->update($data);
				
            if($update){
                return true;
            }else{
                return false;
            }
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	// Itinerary Add Transport
	public function itiAddTransport(Request $request){
        try {
			ITITransport::where('itinerary_no', $request->itinerary_no_val)->delete();
            ITIPrice::where('itinerary_no', $request->itinerary_no_val)->where('price_type', 'transport')->delete();
			$transport_data = '<tr style="background-color: #ff4081;color: #fff;line-height: 30px;">
									<th>Car Name</th>
									<th>Total Seat</th>
									<th>Max KM</th>
									<th>Per KM</th>
									<th>Day Fare</th>
									<th>Car Pic</th>
									<th>#</th>
								</tr>';
			$car_ids = explode(',',$request->selected_tran);
			foreach($car_ids as $car_id){
				$transport = Transport::where('id' , $car_id)->with('car')->with('venderName')->with('car_segment')->with('car_model')->with('car_seats')->with('countryName')->with('stateName')->with('cityName')->get();
				
				
				$data=array(
					"itinerary_no"=>$request->itinerary_no_val,
					"transport_id"=>$car_id,
					"fare"=>$transport[0]['fare'],
					"perday_km"=>$transport[0]['perday_km'],
					"perkm_fare"=>$transport[0]['perkm_fare'],
				);

				$update = ITITransport::create($data);

				

                
				$transport_data .= '<tr> 
									<td>'.$transport[0]['car']['car_name'].'</td>
									<td class="car_seats">'.$transport[0]['car_seats']['seats'].'</td>
									<td>'.$transport[0]['perday_km'].'</td>
									<td>'.$transport[0]['perkm_fare'].'</td>
									<td>'.$transport[0]['fare'].'</td>
									<td><img src="'.url('/storage/app/'.$transport[0]['car']['car_image']).'" width="100px"></td>
									<td style="position: relative;"><i class="material-icons delete_transport" delid="'.$update->id.'">delete</i><img style="width: 16px;    display: none;position: absolute;left: 7px;top: 38px;" src="'.url('public/asset/images/loader/loader.gif').'" class="img-responsive del_trans_loader"></td>
									
								</tr>';
			}
			
			
				
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Added Transport', 'itinerary_no'=>$request->itinerary_no_val, 'transport_data'=>$transport_data));
            }else{
                echo json_encode(array('status'=>false,'msg'=>'Not Add Transport'));
            }
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	// Itinerary Add Transport
	public function itiDeleteTransport(Request $request){
        try {
			ITITransport::where('id', $request->del_id)->delete();
            //ITIPrice::where('itinerary_no', $request->itinerary_no_val)->where('price_type', 'transport')->delete();
			$transport_data = '<tr style="background-color: #ff4081;color: #fff;line-height: 30px;">
									<th>Car Name</th>
									<th>Total Seat</th>
									<th>Max KM</th>
									<th>Per KM</th>
									<th>Day Fare</th>
									<th>Car Pic</th>
									<th>#</th>
								</tr>';
								
			$cars = ITITransport::where('itinerary_no', $request->itinerary_no_val)->get();
			foreach($cars as $car){
				$transport = Transport::where('id' , $car->transport_id)->with('car')->with('venderName')->with('car_segment')->with('car_model')->with('car_seats')->with('countryName')->with('stateName')->with('cityName')->get();
				
				
				$transport_data .= '<tr> 
									<td>'.$transport[0]['car']['car_name'].'</td>
									<td>'.$transport[0]['car_seats']['seats'].'</td>
									<td>'.$transport[0]['perday_km'].'</td>
									<td>'.$transport[0]['perkm_fare'].'</td>
									<td>'.$transport[0]['fare'].'</td>
									<td><img src="'.url('/storage/app/'.$transport[0]['car']['car_image']).'" width="100px"></td>
									<td style="position: relative;"><i class="material-icons delete_transport" delid="'.$transport[0]['id'].'">delete</i><img style="width: 16px;    display: none;position: absolute;left: 7px;top: 38px;" src="'.url('public/asset/images/loader/loader.gif').'" class="img-responsive del_trans_loader"></td>
									
								</tr>';
			}
				
            echo json_encode(array('status'=>true,'msg'=>'Added Transport', 'itinerary_no'=>$request->itinerary_no_val, 'transport_data'=>$transport_data));
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	
	// Itinerary Get Routes
	public function itiGetRoutes(Request $request){
        try {
			DB::enableQueryLog();
			$routes = Via::where('start_destination' , $request->start_distination)->where('to_destination' , $request->to_distination)->where('status' , 'ACTIVE')->get();
			//return DB::getQueryLog();
			$route_data = '<select class="route_id"><option>Select Via</option>';
			foreach($routes as $route){
				$route_data .= '<option value="'.$route['id'].'" vname="'.$route['via'].'">'.$route['via'].'</option>';
			}
			$route_data .= '</select>';
			echo json_encode(array('status'=>true,'msg'=>'Route List', 'route_data'=>$route_data, 'distance'=>$routes[0]['distance'], 'duration' => $routes[0]['duration']));
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	// Itinerary Get Routes 
	public function itiGetRoutesDetails(Request $request){
        try {
			DB::enableQueryLog();
			$routes = Via::where('id' , $request->route_id)->get();
			ITIRoute::where('itinerary_no', $request->itinerary_no_val)->where('start_distination', $routes[0]['start_destination'])->where('to_distination', $routes[0]['to_destination'])->delete();
			$data=array(
				"itinerary_no"=>$request->itinerary_no_val,
				"start_distination"=>$routes[0]['start_destination'],
				"to_distination"=>$routes[0]['to_destination'],
				"via"=>$routes[0]['via'],
				"distance"=>$routes[0]['distance'],
				"duration"=>$routes[0]['duration']);
				
				$update = ITIRoute::create($data);
				
			echo json_encode(array('status'=>true,'msg'=>'Route List', 'distance'=>$routes[0]['distance'], 'duration' => $routes[0]['duration']));
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    // Itinerary Get Routes 
	public function addItiRoutesDetails(Request $request){
        try {
			DB::enableQueryLog();
			if($request->route_id != ''){
                $routes = Via::where('id' , $request->route_id)->get();
            }else{
                $routes = Via::where('start_destination' , $request->start_distination)->where('to_destination', $request->to_distination)->get();
            }
            
			ITIRoute::where('itinerary_no', $request->itinerary_no_val)->where('start_distination', $request->start_distination)->delete();
			$data=array(
				"itinerary_no"=>$request->itinerary_no_val,
				"start_distination"=>$routes[0]['start_destination'],
				"to_distination"=>$routes[0]['to_destination'],
				"via"=>$routes[0]['via'],
				"distance"=>$routes[0]['distance'],
				"duration"=>$routes[0]['duration'],
				"pickup"=>$request->pickup,
				"dropup"=>$request->dropup
            );
			
            $update = ITIRoute::create($data);
            
             // Add pickup itinerary details
             if($request->pickup == 1){
                $PICKLOCA = $this->getCityNameById($routes[0]['start_destination']);
                $DROPLOCA = $this->getCityNameById($routes[0]['to_destination']);
                $DISTACE = $routes[0]['distance'].'KM';
                $DURATION = $routes[0]['duration'];
                $daywisedesc = $this->addPickupItineraryDetails($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION);
                $daywisedata=array(
                    "itinerary_no"=>$request->itinerary_no_val,
                    "day"=>0,
                    "image"=>'',
                    "distination"=>$routes[0]['start_destination'],
                    "description"=>$daywisedesc,
                    "pickup"=>1,
                    "dropup"=>0,
                    );
                ITIDayWiseItinerary::create($daywisedata);
             }

             // Add dropup itinerary details
             if($request->dropup == 1){
                $PICKLOCA = $this->getCityNameById($routes[0]['start_destination']);
                $DROPLOCA = $this->getCityNameById($routes[0]['to_destination']);
                $DISTACE = $routes[0]['distance'].'KM';
                $DURATION = $routes[0]['duration'];
                $daywisedesc = $this->addDropupItineraryDetails($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION);
                $daywisedata=array(
                    "itinerary_no"=>$request->itinerary_no_val,
                    "day"=>999,
                    "image"=>'',
                    "distination"=>$routes[0]['start_destination'],
                    "description"=>$daywisedesc,
                    "pickup"=>0,
                    "dropup"=>1,
                    );
                ITIDayWiseItinerary::create($daywisedata);
             }
				
			echo json_encode(array('status'=>true,'msg'=>'Route List', 'distance'=>$routes[0]['distance'], 'duration' => $routes[0]['duration']));
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	
	// Itinerary Get Routes with city
	public function getRouteCity(Request $request){
		$cities = ITIRoute::select('iti_routes.*','cities.id as city_id','cities.name as name')->join('cities', 'iti_routes.to_distination', '=', 'cities.id')->where('iti_routes.itinerary_no', $request->itinerary_no_val)->get();
        
		$route_data = '<option>Select City</option>';
        $list_dist = 0;
		$selected_city = [];
		foreach($cities as $city){
			$selected_city[]  = $city['to_distination'];
            $selected_cities_con = ITIHotel::where('itinerary_no', $request->itinerary_no_val)->where('distination', $city['to_distination'])->count();
            if($selected_cities_con < 1){
                $route_data .= '<option value="'.$city['to_distination'].'">'.$city['name'].'</option>';
                $list_dist++;
            }
		}
		
		$cities = ITIRoute::select('iti_routes.*','cities.id as city_id','cities.name as name')->join('cities', 'iti_routes.start_distination', '=', 'cities.id')->where('iti_routes.itinerary_no', $request->itinerary_no_val)->get();
		
		foreach($cities as $city){
			if(!in_array($city['start_distination'], $selected_city)){
				$selected_cities_con = ITIHotel::where('itinerary_no', $request->itinerary_no_val)->where('distination', $city['start_distination'])->count();
				if($selected_cities_con < 1){
					$route_data .= '<option value="'.$city['start_distination'].'">'.$city['name'].'</option>';
					$list_dist++;
				}
			}
		}
		
        echo json_encode(array('status'=>true,'msg'=>'', 'itinerary_no'=>$request->itinerary_no_val, 'data' => $route_data, 'list_dist' => $list_dist));
		//echo $route_data;
	}
	
	// Itinerary Get all Routes with city
	public function getAllRouteCity(Request $request){
		$cities = ITIRoute::select('iti_routes.*','cities.id as city_id','cities.name as name')->join('cities', 'iti_routes.to_distination', '=', 'cities.id')->where('iti_routes.itinerary_no', $request->itinerary_no_val)->get();
        
		$route_data = '<option>Select City</option>';
        $list_dist = 0;
		$selected_city = [];
		foreach($cities as $city){
			$selected_city[]  = $city['to_distination'];
            $route_data .= '<option value="'.$city['to_distination'].'">'.$city['name'].'</option>';
            $list_dist++;
		}
		
		$cities = ITIRoute::select('iti_routes.*','cities.id as city_id','cities.name as name')->join('cities', 'iti_routes.start_distination', '=', 'cities.id')->where('iti_routes.itinerary_no', $request->itinerary_no_val)->get();
		
		foreach($cities as $city){
			if(!in_array($city['start_distination'], $selected_city)){
				$route_data .= '<option value="'.$city['start_distination'].'">'.$city['name'].'</option>';
				$list_dist++;
			}
		}
		
		$pdateddate = ITIBasicInfo::select('arrival_date','drop_date')->where('itinerary_no', $request->itinerary_no_val)->first();
		$arrival_date = $pdateddate->arrival_date;
		$drop_date = $pdateddate->drop_date;
		
        echo json_encode(array('status'=>true,'msg'=>'', 'itinerary_no'=>$request->itinerary_no_val, 'data' => $route_data, 'list_dist' => $list_dist, 'arrival_date' => $arrival_date, 'drop_date' => $drop_date));
		//echo $route_data;
	}
	
	// Remove added hotels by itinory_no
	public function deleteItiHotels(Request $request){
		ITIHotel::where('itinerary_no', $request->itinerary_no_val)->delete();
        echo json_encode(array('status'=>true,'msg'=>'Added hotels remove successfully', 'itinerary_no'=>$request->itinerary_no_val));
	}
	
	// Remove added hotels by destination id
	public function deleteItiHotelByDestiId(Request $request){
		ITIHotel::where('itinerary_no', $request->itinerary_no_val)->where('distination', $request->route_citied)->delete();
        echo json_encode(array('status'=>true,'msg'=>'Remove hotels successfully', 'itinerary_no'=>$request->itinerary_no_val));
	}
	
	/**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelsByCityId(Request $request){
		DB::enableQueryLog();
        $hotels = Hotel::where('city_id', $request->city_id)->get();
		$que = DB::getQueryLog();
            $html = '<option value="">Select Hotel</option>';
        foreach($hotels as $hotel){
            $html .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.' ('.$hotel->start_category.' STAR)</option>';
        }
        //$html .= "</select>";
        echo $html;
    }
	
	/**
     * This function use for get activity by city id
     *
     * @return html
     */
    public function getActivityByCityId(Request $request){
        $activities = Activity::where('city_id', $request->city_id)->where('activity_cat_id', $request->activity_id)->with('activityCat')->with('activitySubCat')->get();
            $html = '<option value="">Select Activity</option>';
        foreach($activities as $activity){
            $html .= '<option value="'.$activity->id.'">'.@$activity->activitySubCat->activity_subcat.'</option>';
        }
        echo $html;
    }
	
	/**
     * This function use for get activity time by slot
     *
     * @return html
     */
    public function getTimeBySlot(Request $request){
        $activity_t = Activity::where('id', $request->activity_id)->select($request->slot,'price','actual_price')->first();
        echo json_encode(array("slot" => $activity_t[$request->slot],"price" => $activity_t['price'], "actual_price" => $activity_t['actual_price']));
    }
	
	
	
    /**
     * This function use for get hotels by city id
     *
     * @return html
     */
    public function getHotelRoomTypeByIdITI(Request $request){
		DB::enableQueryLog();
        $roomtypes = RoomCategory::where('hotel_id', $request->hotel_id)->get();
		$que = DB::getQueryLog();
            $html = '<option value="">Select Room Type</option>';
        foreach($roomtypes as $roomtype){
            $html .= '<option value="'.$roomtype->room_type_id.'">'.$roomtype->type.' ('.$roomtype->name.')</option>';
        }
        //$html .= "</select>";
        echo $html;
    }
	
	
	/**
     * This function use for activities by city id
     *
     * @return html
     */
    public function getActivitiesByCity(Request $request){
		DB::enableQueryLog();
        $activities = Activity::where('city_id', $request->activity_city)->where('status', 'ACTIVE')->orderBy('id' , 'desc')->with('activityCat')->with('countryName')->with('stateName')->with('cityName')->with('venderName')->with('activityName')->with('activitySubCat')->get();
		$que = DB::getQueryLog();
            $html = '<option value="">Select Activity</option>';
        foreach($activities as $activity){
            $html .= '<option value="'.$activity->id.'">'.$activity->activityCat->activity_cat.' '.$activity->activitySubCat->activity_subcat.'</option>';
        }
        //$html .= "</select>";
        echo $html;
    }

    /**
     * This function use for activities by city id
     *
     * @return html
     */
    public function getActivityTimeById(Request $request){
		DB::enableQueryLog();
        $activity = Activity::where('id', $request->activity_id)->where('status', 'ACTIVE')->first();
		
        $html = '<option value="">Activity Time</option>';
        $html .= '<option value="'.$activity->morning_slot.'">'.$activity->morning_slot.'</option>';
        $html .= '<option value="'.$activity->evening_slot.'">'.$activity->evening_slot.'</option>';
        
        echo $html;
    }
	
	/**
     * This function use for activities price by activity id
     *
     * @return html
     */
    public function getActivityPrice(Request $request){
		DB::enableQueryLog();
        $activities = Activity::where('id', $request->activity_id)->where('status', 'ACTIVE')->orderBy('id' , 'desc')->with('activityCat')->with('countryName')->with('stateName')->with('cityName')->with('venderName')->get();
		$que = DB::getQueryLog();
        echo $activities[0]['price'];
    }
	
	// Itinerary Basic Info
	public function addActivities(Request $request){
        try {
			//ITIActivity::where('itinerary_no', $request->itinerary_no_val)->where('city_id', $request->city_id)->where('activity_id', $request->activity)->delete();
			ITIActivity::where('itinerary_no', $request->itinerary_no_val)->where('activity_id', $request->activity)->delete();

			$data=array(
				"itinerary_no"=>$request->itinerary_no_val,
				"city_id"=>$request->city_id,
				"activity_id"=>$request->activity,
				"price"=>$request->activiti_price,
				"activity_date"=>$request->activity_date,
				"activity_time"=>$request->activity_time
			);
			$update = ITIActivity::create($data);
			
			
			
			
            if($update){
                echo json_encode(array('status'=>true,'msg'=>'Save', 'itinerary_no'=>$request->itinerary_no_val));
            }else{
                echo json_encode(array('status'=>false,'msg'=>'Not Save'));
            }
                
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    // Add itinerary price 
    public function calculateItineraryPrince(Request $request){
        $itinerary_no = $request->itinerary_no_val;
        ITIPrice::where('itinerary_no', $request->itinerary_no_val)->delete();

        // Transort price
        $transorts = ITITransport::where('itinerary_no', $itinerary_no)->get();
        foreach($transorts as $transort){
            $tnght = ITIBasicInfo::select('total_night')->where('itinerary_no', $itinerary_no)->first();
            //$transport = Transport::where('id' , $transort->transport_id)->get();

            $tnght = $tnght->total_night+1;
            //$transport_price = $transport[0]['fare']*$tnght;
            $transport_price = $transort->fare*$tnght;
            $this->addItineraryPrince($itinerary_no, 'transport', $transport_price);
        }

        // Hotel Price
        $hotels = ITIHotel::where('itinerary_no', $itinerary_no)->get();
        foreach($hotels as $hotel){
            $this->addItineraryPrince($itinerary_no, 'hotel', $hotel->rate);
        }

        // Activity Price
        $activities = ITIActivity::where('itinerary_no', $itinerary_no)->get();
        foreach($activities as $activity){
            $this->addItineraryPrince($itinerary_no, 'activity', $activity->price);
        }

        // Total price
        $tprice = ITIPrice::where('itinerary_no', $itinerary_no)->first();
        $tprice = $tprice->total_price;


		// Transport
		$trans_price = 0;
		$ITITranportPriceLists = ITITranportPriceList::where('itinerary_no', $request->itinerary_no_val)->get();
		
		$transport = '<div class="col m2"></div><div class="col m4">
								Transport Price
								<hr>
								<table class="iti_price_tbl">
									<tr class="iti_price_head">
										<td>Fleet Name</td>
										<td>Daily Fare</td>
									</tr>';
		foreach($ITITranportPriceLists as $ITITranportPriceList){
			$trans_price += $ITITranportPriceList->fare;
			$transport .= '<tr>
							<td>'.$ITITranportPriceList->car_name.'</td>
							<td><input type="text" onblur="updateItineraryPrice('."'transport'".','.$ITITranportPriceList->id.', this.value)" value="'.$ITITranportPriceList->fare.'" /></td>
						</tr>';
		}
		$transport .= '<tr>
							<td>Total Cost</td>
							<td>'.$trans_price.'</td>
						</tr>';
		$transport .= '</table>
							</div>';
		
		
		// Hotel
		$hotel_price = 0;
		$ITIHotelPriceLists = ITIHotelPriceList::where('itinerary_no', $request->itinerary_no_val)->get();
		
		$hotelp = '<div class="col m12">
								Hotel Rooms Price
								<hr>
								<table class="iti_price_tbl">
									<tr class="iti_price_head">
										<td>Hotel</td>
										<td>Room Type</td>
										<td>Meal Plan</td>
										<td>Rates</td>
									</tr>';
		foreach($ITIHotelPriceLists as $ITIHotelPriceList){
			$hotel_price += $ITIHotelPriceList->rate;
			$hotelp .= '
					<tr>
						<td>'.$ITIHotelPriceList->hotel_name.' ('.$ITIHotelPriceList->start_category.' STAR)</td>
						<td>'.$ITIHotelPriceList->type.'</td>
						<td>'.$ITIHotelPriceList->meal_plan.'</td>
						<td><input type="text" onblur="updateItineraryPrice('."'hotel'".','.$ITIHotelPriceList->id.', this.value)" value="'.$ITIHotelPriceList->rate.'" /></td>
					</tr>';
		}	
		$hotelp .= '
					<tr>
						<td colspan="3">Total Cost</td>
						<td>'.$hotel_price.'</td>
					</tr>';		
		$hotelp .='</table>
							</div>';
			
		// Activity
		$activity_t_price = 0;
		$ITIActivitiPriceLists = ITIActivitiPriceList::where('itinerary_no', $request->itinerary_no_val)->get();
		
		$activityp ='<div class="col m4">
								Activities Price
								<hr>
								<table class="iti_price_tbl">
									<tr class="iti_price_head">
										<td>Activity</td>
										<td>Rates</td>
									</tr>';
		foreach($ITIActivitiPriceLists as $ITIActivitiPriceList){		
			$activity_t_price += $ITIActivitiPriceList->price;
			$activityp .='
					<tr>
						<td>'.$ITIActivitiPriceList->activity_name.'</td>
						<td><input type="text" onblur="updateItineraryPrice('."'activity'".','.$ITIActivitiPriceList->id.', this.value)" value="'.$ITIActivitiPriceList->price.'" /></td>
					</tr>';
		}
		$activityp .='
					<tr>
						<td>Total Cost</td>
						<td>'.$activity_t_price.'</td>
					</tr>';
		$activityp .='</table>
							</div>';
		
		
		// Total Price
		$ITIPrice = ITIPrice::where('itinerary_no', $request->itinerary_no_val)->first();
		
		$total_price = '<div class="col m12 center">
								Total Price - <span style="color:green;font-size:18px;">'.$ITIPrice->total_price.' /-</span><br><br>
							</div>';
		
		$price_list = $total_price.$transport.$activityp.$hotelp;

        $view_url = \URL::to('/').'/vender/itinerarymanage/'.$request->itinerary_no_val;
        echo json_encode(array('status'=>true,'msg'=>'Save', 'tprice' => $tprice, 'itinerary_no'=>$request->itinerary_no_val, 'view_url'=> $view_url, 'price_list'=>$price_list));
    }

    // Add itinerary price 
    public function addItineraryPrince($itinerary_no, $price_type, $price){
        $total_price = '';

        $data=array(
            "itinerary_no"=>$itinerary_no,
            "price_type"=>$price_type,
            "price"=>$price,
            "total_price"=>$total_price
        );
        $price = ITIPrice::create($data);
        $this->updateItineraryTotalPrince($itinerary_no);
        return true;
    }

    // Add itinerary price 
    public function updateItineraryTotalPrince($itinerary_no){
        $total_price = ITIPrice::where('itinerary_no',$itinerary_no)->sum('price');

        $data=array(
            "total_price"=>$total_price
        );
        $update = ITIPrice::where('itinerary_no', $itinerary_no)->update($data);
        $update1 = ITIBasicInfo::where('itinerary_no', $itinerary_no)->update($data);
        return true;
    }
	
	// update itinerary price 
    public function updateItineraryPrince(Request $request){
		$updatetype = $request->updatetype;
		$updateid = $request->updateid;
		$value = $request->value;
		
        if($updatetype == 'transport'){
			$data=array(
				"fare"=>$value
			);
			$update = ITITransport::where('id', $updateid)->update($data);
		}elseif($updatetype == 'hotel'){
			$data=array(
				"rate"=>$value
			);
			$update = ITIHotel::where('id', $updateid)->update($data);
		}elseif($updatetype == 'activity'){
			$data=array(
				"price"=>$value
			);
			$update = ITIActivity::where('id', $updateid)->update($data);
		}
		if($update){
			echo json_encode(array('status'=>true,'msg'=>'Price updated'));
		}
    }
	
	// Get the difference between two dates 
    public function difToDate($date1, $date2, $type = 'd'){
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        if($type == 'd'){
            return $days;
        }elseif($type == 'm'){
            return $months;
        }elseif($type == 'y'){
            return $years;
        }        
    }
}
