<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use DB;
use Mail;
use PHPMailer\PHPMailer;
use Storage;
use View;
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
use App\Lead;
use App\Quotation;
use App\Sale;
use App\Contacts;
use App\AdminRequest;
use App\AssignContacts;
use App\BulkEmailSendReport;
use App\BulkEmailSend;
use App\EmailTemplat;
use App\EmailCampaign;

use Illuminate\Support\Facades\Session;

class CommanController extends Controller
{
	
	public function __construct(){
		//its just a dummy data object.
		$requests = AdminRequest::orderBy('id' , 'desc')->where('status','OPEN')->with('operator')->get();

		// Sharing is all view of admincontroller
		View::share('requests', $requests); 
	}
	
	/**
	 * This function use for load admin login view
	 *
	 * @return admin login page
	 */
	public function index(){
		//return view('admin.login');
	}
	
	/**
	 * This function use for view hotel details
	 *
	 * @return array
	 */
	public function viewHotel($id){
        
        $Hotel = Hotel::select('hotels.*', 'cities.name as city', 'countries.name as country', 'regions.name as region')
                       ->join('countries', 'countries.id', '=', 'hotels.country_id')
                       ->join('regions', 'regions.id', '=', 'hotels.region_id')
                       ->join('cities', 'cities.id', '=', 'hotels.city_id')
                       ->where('hotels.id', $id)->first();
         $hotelamenity = HotelAmenity::select('name')
                            ->join('amenities', 'amenities.id', '=', 'hotel_amenities.amenity_id')
                            ->where('hotel_amenities.hotel_id', $id)
                            ->get();
         $hotelroomcategoires = RoomCategory::where('hotel_id', $id)->get(); 
         $hotelgalleries = HotelGallery::where('hotel_id', $id)->get(); 
         $current_date = date('Y-m-d');
         $hotelseasonrate = HotelSeasonRate::where('start_date','<=', $current_date)
                                            ->where('end_date','>=', $current_date)
                                            ->where('status', 'ACTIVE')
                                            ->where('hotel_id',$id)
                                            ->orderBy('id', 'DESC')->first();
       return view('viewhotel', compact('Hotel','hotelamenity','hotelroomcategoires', 'hotelgalleries','hotelseasonrate', 'current_date'));
	}
	
	
	
	/** 
     * Unsubscribe action
     *
     * @return \Illuminate\Http\Response
     */
    public function unsuscribeUser($id)
    {
		$contact = Contacts::where('status','ACTIVE')->where('id', $id)->first();
		$contact->subscription_status = 'UNSUBSCRIBE';
		$contact->save();
		echo "<b>".$contact->email."</b> This Email Successfully Unsubscribed!";
    }
	
	
}
