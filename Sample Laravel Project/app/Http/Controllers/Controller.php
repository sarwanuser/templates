<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Storage;
use App\SMTPEmail;
use App\HotelSeasonRate;
use PHPMailer\PHPMailer;
use App\RoomCategory;
use App\Hotel;
use App\City;
use App\SendQuotation;
use App\SendQuotationRate;
use App\RoomBookedDetails;
use App\RoomInventory;
use App\Activity;
use App\Vender;
use App\ActivityVoucher;
use App\AgentContact;
use App\PaymentSource;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	//Send Email
	public function send($message, $subject, $from, $to, $pdf_name='', $ccemail=''){ 
		$text             = $message;
        $mail             = new PHPMailer\PHPMailer(); // create a n
        //$mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "Sales@ensoberhotels.com"; 
        $mail->Password = "new4321raj#"; 
        $mail->SetFrom($from, 'Ensober');
        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->AddAddress($to, "");
		if($ccemail != ''){
			$mail->AddAddress($ccemail);
		}
		if($pdf_name != ''){
			//$mail->addAttachment('storage/app/quotations/'.$pdf_name); 
			$mail->addAttachment($pdf_name); 
		}
        if ($mail->Send()) {
            return 'Email Sent Successfully';
        } else {
            return 'Failed to Send Email';
        }
	}
	
	//Send Email
	public function sendAdmin($message, $subject, $from){ 
		$text             = $message;
        $mail             = new PHPMailer\PHPMailer(); // create a n
        //$mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail tsl
        $mail->Host       = "smtp.google.com";
        $mail->Port       = 587; // or 587
        $mail->IsHTML(true);
        $mail->Username = "Sales@ensoberhotels.com"; 
        $mail->Password = "new4321raj#";
        $mail->SetFrom($from, 'Ensober');
        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->AddAddress("info@ensoberhotels.com", "");
        //$mail->AddAddress("sarwanmawai@gmail.com", "");
        //$mail->AddAddress(env('ADMIN1'), "");
        //$mail->AddAddress(env('ADMIN2'), "");
		try {
			$status = $mail->send();
			//echo $mail->ErrorInfo;
		} catch (Exception $e) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		
        /* if ($mail->Send()) {
            return 'Email Sended Successfully';
        } else {
            return 'Failed to Send Email';
        } */
	}
	
	// Get hotel season rate
	public function GetSeasonHotelRate($checkin, $hotel_id, $room_type){
		DB::enableQueryLog();
       $hotelseasonrate = HotelSeasonRate::where('start_date','<=', $checkin)
						->where('end_date','>=', $checkin)
						->where('status', 'ACTIVE')
						->where('hotel_id',$hotel_id)
						->where('room_type_id',$room_type)
						->orderBy('id', 'DESC')->first();
		//dd(DB::getQueryLog());			
        if($hotelseasonrate){ 
            return array('status'=>true,'hotelseasonrate'=>$hotelseasonrate);
        }else{
            return array('status'=>false,'hotelseasonrate'=>'');
        } 
    }
	
	/**
     * This function use for get hotel details by id
     *
     * @return html
     */
    public function getHotelDetailsById($hotel_id){
        $hotel = Hotel::where('id', $hotel_id)->first();
        return $hotel;
    }
	
	/**
     * This function use for get hotel details by id with full info
     *
     * @return html
     */
    public function getHotelDetailsByIdWithFullInfo($hotel_id){
		//dd($hotel_id);
        $hotel = Hotel::where('id', $hotel_id)->with('RoomCategory')->with('HotelAmenity')->with('HotelGallery')->first();
        return $hotel;
    }
	
	/**
     * This function use for get the room type by id
     *
     * @return html
     */
    public function getRoomTypeById($hotel_id, $room_type_id){ 
        $RoomCategory = RoomCategory::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->first();
        return $RoomCategory->name;
    }
	
	
	/**
     * This function use for get city name by id
     *
     * @return html
     */
    public function getCityNameById($city_id){ 
        $city = City::where('id', $city_id)->first();
        return $city->name;
    }
	
	/**
     * This function use for get activity name by id
     *
     * @return html
     */
    public function getActivityNameById($activity_id){ 
		$activity = Activity::where('id',$activity_id)->with('activityCat')->with('activitySubCat')->first();
        return $activity->ActivityCat->activity_cat.' '.$activity->ActivitySubCat->activity_subcat;
    }
	
	/**
     * This function use for get activity name with details by id
     *
     * @return html
     */
    public function getActivityNameWCById($activity_id){ 
		$activity = Activity::where('id',$activity_id)->with('activityCat')->with('activitySubCat')->first();
		$array = array('name' => $activity->ActivityCat->activity_cat.' '.$activity->ActivitySubCat->activity_subcat, 'cat' => $activity->ActivityCat->activity_cat, 'sub_cat' => $activity->ActivitySubCat->activity_subcat);
        return $array;
    }
	
	/**
     * This function use for get activity full details by id
     *
     * @return html
     */
    public function getActivityDetailsById($activity_id){ 
		return $activity = Activity::where('id',$activity_id)->with('activityCat')->with('activitySubCat')->first();
    }
	
	/**
     * This function use for get vendor name by id
     *
     * @return html
     */
    public function getVendorNameById($vendor_id){ 
        $vender = Vender::where('id', $vendor_id)->first();
        return $vender->name;
    }
	
	/**
     * This function use for get no of dinner,breakfast,lunch by meal plan
     *
     * @return array
     */
    public function getNoOfBLD($cp, $map, $ap){
		/*
		Note:
		EP = 0Breakfast, 0Lunch, 0Dinner
		CP = 1Breakfast
		MAP = 1Breakfast, 1Dinner
		AP = 1Breakfast, 1Lunch, 1Dinner
		*/ 
		$breakfast = $cp+$ap;
		$lunch = $map+$ap;
		$dinner = $map+$ap;
		
		return $result = array('breakfast' => $breakfast, 'lunch' => $lunch, 'dinner' => $dinner);
    }
	
	/**
     * This function use for get meal plan full name by code
     *
     * @return string
     */
    public function getMealFullNameByCode($meal_plan){
		if($meal_plan == 'ep_price'){
			$plan_name = 'EP (Room Only)';
		}elseif($meal_plan == 'cp_price'){
			$plan_name = 'CP (Room with Breakfast)';
		}elseif($meal_plan == 'map_price'){
			$plan_name = 'MAP (Room with Brkfst & Dnr)';
		}elseif($meal_plan == 'ap_price'){
			$plan_name = 'AP (Room with all meals plan)';
		}else{
			$plan_name = '';
		}
		return $plan_name;
    }
	
	/**
     * This function use for get meal plan short name by code
     *
     * @return string
     */
    public function getMealShortNameByCode($meal_plan){
		if($meal_plan == 'ep_price'){
			$plan_name = 'EP';
		}elseif($meal_plan == 'cp_price'){
			$plan_name = 'CP';
		}elseif($meal_plan == 'map_price'){
			$plan_name = 'MAP';
		}elseif($meal_plan == 'ap_price'){
			$plan_name = 'AP';
		}else{
			$plan_name = '';
		}
		return $plan_name;
    }
	
	/**
     * This function use for check this quotation no is valid or not
     *
     * @return count
     */
    public function checkQuotationNoIsValid($send_quotation_no){
        $SendQuotation = SendQuotation::where('send_quotation_no', $send_quotation_no)->count();
        return $SendQuotation;
    }
	
	/**
     * This function use for check this activity voucher no is valid or not
     *
     * @return count
     */
    public function checkActivityVoucherNoIsValid($activity_voucher_no){
        $ActivityVoucher = ActivityVoucher::where('voucher_no', $activity_voucher_no)->count();
        return $ActivityVoucher;
    }
	
	/**
	 * This function use for get the number of days witbeen two date 
	 *
	 * @para 0=all, 1=weekday, 2=weekend
	 * @return room inventory dashboard page
	 */
	public function getNoOfDays($startDate, $endDate,$type=0){ 
		  
		$resultDays = array('Monday' => 0,
		'Tuesday' => 0,
		'Wednesday' => 0,
		'Thursday' => 0,
		'Friday' => 0,
		'Saturday' => 0,
		'Sunday' => 0);
	  
		// change string to date time object
		$startDate = new \DateTime($startDate);
		$endDate = new \DateTime($endDate);
	  
		// iterate over start to end date
		while($startDate <= $endDate ){
			// find the timestamp value of start date
			$timestamp = strtotime($startDate->format('d-m-Y'));
	  
			// find out the day for timestamp and increase particular day
			$weekDay = date('l', $timestamp);
			$resultDays[$weekDay] = $resultDays[$weekDay] + 1;
	  
			// increase startDate by 1
			$startDate->modify('+1 day');
		}
	  
		// return the result
		if($type == 0){ // All Days
			$days = array($resultDays['Monday'],$resultDays['Tuesday'],$resultDays['Wednesday'],$resultDays['Thursday'],$resultDays['Friday'],$resultDays['Saturday'],$resultDays['Sunday']);
		}elseif($type == 1){ // Weekdays Only
			$days = array($resultDays['Monday'],$resultDays['Tuesday'],$resultDays['Wednesday'],$resultDays['Thursday'],$resultDays['Friday']);
		}elseif($type == 2){ // Weekend Only
			$days = array($resultDays['Saturday'],$resultDays['Sunday']);
		}
		return array_sum($days);
	}
	
	/**
     * This function use for delete the quotation with related data
     *
     * @return html
     */
    public function deleteQuotationWithAllRelatedData(Request $request){
		$quotation_nos = explode(',',$request->no);
		$return_message = '';
		foreach($quotation_nos as $quotation_no){
			// send_quotations
			$SendQuotation = SendQuotation::where('send_quotation_no', $quotation_no)->delete();
			if($SendQuotation){
				$return_message .= 'SendQuotation table deleted quotation_no-'.$quotation_no.'<br>';
			}
			
			// room_booked_details
			$RoomBookedDetails = RoomBookedDetails::where('send_quotation_no', $quotation_no)->delete();
			if($RoomBookedDetails){
				$return_message .= 'RoomBookedDetails table deleted quotation_no-'.$quotation_no.'<br>';
			}
			
			// room_inventory
			$RoomInventory = RoomInventory::where('send_quotation_no', $quotation_no)->delete();
			if($RoomInventory){
				$return_message .= 'RoomInventory table deleted quotation_no-'.$quotation_no.'<br>';
			}
			
			// send_quotation_rates
			$SendQuotationRate = SendQuotationRate::where('send_quotation_no', $quotation_no)->delete();
			if($SendQuotationRate){
				$return_message .= 'SendQuotationRate table deleted quotation_no-'.$quotation_no.'<br>';
			}
			echo $return_message .= '<br><br>';
		}
    }
	
	// Check agent email or contact dublicate or not
	function checkAgentContact($email,$mobile){
		return $aget_count = AgentContact::where('email', $email)->where('mobile',$mobile)->count();
	}

	// Delete the S3 file
	function deleteS3File($url){
		$url = 'https://ensober.s3.ap-south-1.amazonaws.com/activity/96XucHAdnnrIshPpML0NY1d8or8uDnPxWIed5XmM.jpg';
		$path = str_replace('https://ensober.s3.ap-south-1.amazonaws.com/','', $url);
		$dstatus = Storage::disk('s3')->delete($path); 
		return $dstatus;
	}

	/**
     * This function use change the dynamic data 
     *
     * @return string
     */
    public function changeDynamicData($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION, $HOTELDESTI, $HOTELNAME, $MEALPLANE, $daywisedata){
		//__PICKLOCA__
		//__DROPLOCA__
		//__DISTACE__
		//__DURATION__
		//__HOTELDESTI__
		//__HOTELNAME__
		//__MEALPLANE__
		$daywisedata = str_replace('__PICKLOCA__', $PICKLOCA, $daywisedata);
		if($DROPLOCA == ''){
			$daywisedata = str_replace('__DROPLOCA__', 'Drop Location', $daywisedata);
		}else{
			$daywisedata = str_replace('__DROPLOCA__', $DROPLOCA, $daywisedata);
		}
		$daywisedata = str_replace('__DISTACE__', $DISTACE, $daywisedata);
		$daywisedata = str_replace('__DURATION__', $DURATION, $daywisedata);

        $daywisedata = str_replace('__HOTELDESTI__', $HOTELDESTI, $daywisedata);
        $daywisedata = str_replace('__HOTELNAME__', $HOTELNAME, $daywisedata);
        return $daywisedata = str_replace('__MEALPLANE__', $MEALPLANE, $daywisedata);
    }

	/**
     * This function use add the pickup itinerary details 
     *
     * @return string
     */
    public function addPickupItineraryDetails($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION){
		//__PICKLOCA__
		//__DROPLOCA__
		//__DISTACE__
		//__DURATION__
		$content = '<b>__PICKLOCA__</b> to <b>__DROPLOCA__</b>  – (<b>__DISTACE__</b>/<b>__DURATION__</b>)
		Our hospitality start upon our Meet & Greet on your pickup location. After comfortable pickup we proceed for a road journey to our first Destination that is <b>__DROPLOCA__</b>.
		';
        $content = str_replace('__PICKLOCA__', $PICKLOCA, $content);
        $content = str_replace('__DROPLOCA__', $DROPLOCA, $content);
        $content = str_replace('__DISTACE__', $DISTACE, $content);
        return $content = str_replace('__DURATION__', $DURATION, $content);
    }

	/**
     * This function use add the dropup itinerary details 
     *
     * @return string
     */
    public function addDropupItineraryDetails($PICKLOCA, $DROPLOCA, $DISTACE, $DURATION){
		//__PICKLOCA__
		//__DROPLOCA__
		//__DISTACE__
		//__DURATION__
		$content = '<b>__PICKLOCA__</b> to <b>__DROPLOCA__</b> (Approx. <b>__DISTACE__</b>/<b>__DURATION__</b>)
		After Breakfast Check-out with best memories from the Hotel to proceed to next destination.
		';
        $content = str_replace('__PICKLOCA__', $PICKLOCA, $content);
        $content = str_replace('__DROPLOCA__', $DROPLOCA, $content);
        $content = str_replace('__DISTACE__', $DISTACE, $content);
        return $content = str_replace('__DURATION__', $DURATION, $content);
    }
	
	/**
     * This function use for get the payment source id by source name
     *
     * @return html
     */
    public function getPaymentSourceId($hotel_id, $pay_source){ 
		$pay_source = PaymentSource::where('hotel_id',$hotel_id)->where('source', $pay_source)->first();
		return $pay_source->id;
    }
}













