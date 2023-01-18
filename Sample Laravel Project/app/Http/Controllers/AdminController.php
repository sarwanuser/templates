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
use App\EmailList;
use App\SMTPEmail;
use App\RoomBookedDetails;
use App\WebsiteEnquiry;
use PDF;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
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
		return view('admin.login');
	}
	
	/**
	 * This function use for admin login action
	 *
	 * @return admin login page
	 */
	public function adminLogin(Request $request){
		
		$this->validate($request, [
			'user' => 'required',
			'password' => 'required',
		]);
		
		try{
			$admin = Admin::where('user', $request->user)->where('password', $request->password)->first();
			if($admin != ""){
				$request->session()->regenerate();
				$request->session()->put('admin', $admin->name);
				$request->session()->push('admin.id', $admin->id);
				return redirect('admin/dashboard');
			}else{
				return redirect('admin');
			}
		}catch(Exseption $e){
			return response()->json(['error' => $e->getMessage()]);
		}
	}
	
	/**
	 * This function use for close all contact to operator
	 *
	 * @return admin login page
	 */
	public function closeContactToOperator(Request $request){
		
		$this->validate($request, [
			'operator_id' => 'required'
		]);
		
		try{
			$Operator = Operator::findOrFail($request->operator_id);
			$AssignContacts = AssignContacts::where('operator_id', $request->operator_id)->where('status','ACTIVE')->get();
			if($AssignContacts){
				$x=0;
				foreach($AssignContacts as $AssignContact){
					$AssignContact->status = 'CLOSE';
					$AssignContact->save();
				$x++;
				}
				$msg = "Close All Contact Successfully\n,";
				$msg .= "Operator: ".$Operator->name." \n,";
				$msg .= "Total Contact Closed: ".$x." \n,";
				return back()->with('flash_success',$msg);
			}else{
				return back()->with('flash_error', 'Contact Not Found Operator: '.$Operator->name);
			}
		}catch(Exseption $e){
			return response()->json(['error' => $e->getMessage()]);
		}
	}
	
	/**
	 * This function use for get the admin dashboard details 
	 *
	 * @return admin login page 
	 */
	public function dashboard(){
		if (session()->exists('admin')) {
			return view('admin/dashboard');
		}else{
			return redirect('/admin');
		}
	}
	
	/**
	 * This function use for make quotation.
	 *
	 * @return admin login page
	 */
	public function makeQuotation(){
		if (session()->exists('admin')) {
			return view('admin/makequotation');
		}else{
			return redirect('/admin');
		}
	}
	
	/**
	 * This function use for logout admin 
	 *
	 * @return admin login page
	 */
	public function logout(){
		session()->flush();
		return redirect('/admin');
	}

	/**
	 * This function use for get all venders
	 *
	 * @return array
	 */
	public function getAllVenders(){
		$venders = Vender::All();
		return view('admin/allvenders', compact('venders'));
	}
	
	/**
	 * This function use for get all email campaign
	 *
	 * @return array
	 */
	public function getEmailCampaign(){
		$datas = EmailCampaign::orderBy('id' , 'desc')->get();
		return view('admin/emailcampaign', compact('datas'));
	}
	
	/**
	 * This function use for get all email campaign
	 *
	 * @return array
	 */
	public function deleteEmailCampaign($id){
		$EmailCampaign = EmailCampaign::find($id);
		$EmailCampaign->delete();
		$datas = EmailCampaign::All();
		return redirect('/admin/emailcampaign');
	}
	
	
	/** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEmailList(Request $request)
    {
        if ( ($request->has('location') && $request->input('location')!= '') || ($request->has('contact_type') && $request->input('contact_type')!= '') || ($request->has('source') && $request->input('source')!= '') ) {
            
        $query = Contacts::query();
        //$query->select('id','name','email','location','contact_type','source','status');
        if($request->has('location') && $request->input('location')!= ''){
          $query->where('location','like', '%'. $request->input('location').'%');
        }
        if( $request->has('contact_type') && $request->input('contact_type')!= ''){
          $query->where('contact_type', $request->input('contact_type') );
        }
        if( $request->has('source') && $request->input('source')!= ''){
          $query->where('source', $request->input('source') );
        }
            $Contacts = $query->with('asignContact')->orderBy('id' , 'desc')->get();
        }else{ 
            //$Contacts = Contacts::with('asignContact')->orderBy('id' , 'desc')->take(100)->get();
            $Contacts = Contacts::with('asignContact')->orderBy('id' , 'desc')->get();
        }
        $contact_types = Contacts::distinct()->get(['contact_type']);
        $sources  = Contacts::distinct()->get(['source']);
        $Operators = Operator::where('status', 'ACTIVE')->get();
        return view('admin.addemaillist', compact('Contacts','contact_types','sources','Operators'));
    }
	
	
	/**
	 * This function use for get all email campaign
	 *
	 * @return array
	 */
	public function updateEmailCampaign($id){
		$EmailCampaign = EmailCampaign::find($id);
		
		$query = Contacts::query();
		
		if($EmailCampaign->sr_location == '' && $EmailCampaign->sr_contact_type == '' && $EmailCampaign->sr_source == ''){
			return redirect('/admin/emailcampaign');
		}
			
		if($EmailCampaign->sr_location != ''){
		  $query->where('location','like', '%'. $EmailCampaign->sr_location.'%');
		}
		if( $EmailCampaign->sr_contact_type != ''){
		  $query->where('contact_type', $EmailCampaign->sr_contact_type);
		}
		if($EmailCampaign->sr_source != ''){
		  $query->where('source', $EmailCampaign->sr_source);
		}
		$Contacts = $query->select('id')->orderBy('id' , 'desc')->get();
		foreach($Contacts as $Contact){
			$ids[] = $Contact->id;
		}
		$Contacts = implode(',',$ids);
		$EmailCampaign->contact_ids = $Contacts; 
		$EmailCampaign->save();
		
		EmailList::where('email_campaign_id', $EmailCampaign->id)->delete();
		foreach($ids as $contact_id){
			$contact = Contacts::where('id', $contact_id)->first();
			$EmailList = new EmailList();
			$EmailList->email_campaign_id = $EmailCampaign->id;
			$EmailList->contact_id = $contact->id;
			$EmailList->co_name = $contact->name;
			$EmailList->co_email = $contact->email;
			$EmailList->co_mobile = $contact->mobile;
			$EmailList->status = 'ACTIVE';
			$EmailList->save();
		}
		
		return redirect('/admin/emailcampaign');
	}

	/**
	 * This function use for add vender
	 *
	 * @return array
	 */
	public function addVender(Request $request){
		return view('admin/addvender');
	}
	
	/**
	 * This function use for add vender
	 *
	 * @return array
	 */
	public function contactFollowUpReport(Request $request){
		$Operators = Operator::where('status', 'ACTIVE')->get();
		return view('admin/contactfollowupreport', compact('Operators'));
	}
	
	/**
	 * This function use for generate monthly invoice for hotel
	 *
	 * @return array
	 */
	public function generateMonthlyInvoice(Request $request){
		$hotels = Hotel::All();
		return view('admin/generatemonthlyinvoice', compact('hotels'));
	}
	
	/**
	 * This function use for hotel monthly invoice report
	 *
	 * @return array
	 */
	public function HotelMonthlyInvoice(Request $request){
		$hotel_id = $request->hotel_id;
		$fromdate = $request->fromdate;
		$todate = $request->todate;
		$booking_from = $request->booking_from;
		$extra = $request->extra;
		$insentive = $request->insentive;
		$billing = $request->billing;
		$comment = $request->comment;
		
		$des1 = $request->des1;
		$amount1 = $request->amount1;
		$des2 = $request->des2;
		$amount2 = $request->amount2;
		$des3 = $request->des3;
		$amount3 = $request->amount3;
		$des4 = $request->des4;
		$amount4 = $request->amount4;
		
		if($request->doc_type == 'EXCEL'){
			if($booking_from == 'ONLINE'){
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->where('booking_from', $booking_from)->whereBetween('check_in',[$fromdate,$todate])->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}elseif($booking_from == 'OFFLINE'){
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->where('booking_from', '!=', 'ONLINE')->whereBetween('check_in',[$fromdate,$todate])->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}else{
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->whereBetween('check_in',[$fromdate,$todate])->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}
		}else{
			if($booking_from == 'ONLINE'){
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->where('booking_from', $booking_from)->where('booking_status', '!=', 'Canceled')->whereBetween('check_in',[$fromdate,$todate])->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}elseif($booking_from == 'OFFLINE'){
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->where('booking_from', '!=', 'ONLINE')->where('booking_status', '!=', 'Canceled')->whereBetween('check_in',[$fromdate,$todate])->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}else{
				$invoices = RoomBookedDetails::select('agent_name','client_name','send_quotation_no','hotel','check_in','check_out','total_bill','extra_bill','advance_amount','date_of_advance','payment_source','booking_from','booking_status')->whereBetween('check_in',[$fromdate,$todate])->where('booking_status', '!=', 'Canceled')->where('hotel',$hotel_id)->groupBy('send_quotation_no')->orderBy('check_in','ASC')->get();
			}
		}
		
		
		
		$total_bill = 0;
		$total_extra_bill = 0;
		$total_advance_amount = 0;
		$total_advance_received = 0;
		foreach($invoices as $invoice){
			$total_bill += $invoice->total_bill;
			$total_extra_bill += $invoice->extra_bill; 
			$total_advance_amount += $invoice->advance_amount;
			if(strtolower($invoice->payment_source) == 'dayaway' || strtolower($invoice->payment_source) == 'ensober' || strtolower($invoice->payment_source) == 'ensoberother'){
				$total_advance_received += $invoice->advance_amount; 
			}
		}
		
		$all_total_bill = $total_bill+$total_extra_bill;
		$hotel = Hotel::where('id', $hotel_id)->first();
		
		$file_name = $hotel->hotel_name.'-'.$fromdate.' To '.$todate.'.pdf';
		
		if($request->doc_type == 'EXCEL'){
			return view('admin/hotelmonthlyinvoiceexcel', compact('invoices','total_bill','total_extra_bill','all_total_bill','hotel','fromdate','todate','total_advance_amount'));
		}else{
			ob_clean();
			$pdf = PDF::loadView('admin.hotelmonthinvoice', compact('invoices','total_bill','total_extra_bill','all_total_bill','hotel','fromdate','todate', 'total_advance_amount','total_advance_received','extra','insentive','billing','comment','des1','amount1','des2','amount2','des3','amount3','des4','amount4')); 
		
			return $pdf->download($file_name); 
		}
	}

	/**
	 * This function use for add vender action
	 *
	 * @return array
	 */
	public function addVenderAction(Request $request){
		
		try{
		    //return "Hello";
		    DB::table('venders')->insert(["name" => $request->name, "email" => $request->email, "password" => bcrypt($request->password), "vender_type" => $request->vender_type, "country" => $request->country, "state" => $request->state, "city" => $request->city]);
		    
			return redirect('admin/addvender')->with('flash_success', 'SUCCESS : Add Vender Successful!');
		}catch(Exception $e){
			return response()->json(["error" => $e->getMessage()], 500);
		}
		
	}


	/**
	 * This function use for get all venders
	 *
	 * @return array
	 */
	public function getAllOperators(){
		$operators = Operator::All();
		return view('admin/alloperator', compact('operators'));
	}

	/**
	 * This function use for add vender
	 *
	 * @return array
	 */
	public function addOperator(Request $request){
		return view('admin/addoperator');
	}

	/**
	 * This function use for add vender action
	 *
	 * @return array
	 */
	public function addOperatorAction(Request $request){
		
		try{
		    //return "Hello";
		    DB::table('operators')->insert(["name" => $request->name, "email" => $request->email, "password" => bcrypt($request->password), "country" => $request->country, "state" => $request->state, "city" => $request->city]);
			return redirect('admin/addoperator')->with('flash_success', 'SUCCESS : Add Operator Successful!');
		}catch(Exception $e){
			return response()->json(["error" => $e->getMessage()], 500);
		}
		
	}


	/**
	 * This function use for add hotel
	 *
	 * @return array
	 */
	public function addHotel(){
		$amenities = Amenity::All();
		return view('admin/addhotel', compact('amenities'));
	}

	/**
	 * This function use for add hotel action step1
	 *
	 * @return array
	 */
	public function addHotelStep1(Request $request){
		$response = DB::table('hotels')->insert(["hotel_name" => $request->hotel_name, "googleaddress" => $request->googleaddress]);
		return $response;
	}


	/**
	 * This function use for get the all website enquiry
	 *
	 * @return array
	 */
	public function getWebsiteEnquiry(){
		$response = WebsiteEnquiry::with('getUser')->get();
		return view('admin/websiteenquirylist', compact('response'));
	}
	

	/**
	 * This function use for get all hotels
	 *
	 * @return array
	 */
	public function hotelList(){
		$hotels = Hotel::All();
		return view('admin/hotellist', compact('hotels'));
	}
	
	
	/**
	 * This function use for add hotel action
	 *
	 * @return array
	 */
	public function addHotelAction(Request $request){
		
		try{
			
			if($request->HasFile('hotel_image')){
				$path = $request->file('hotel_image')->store('hotel_images');
			}else{
				$path = '';
			}
			
			
			//$path = Storage::delete('hotel_images/fMDQSE824B5XcSQfPFuT64kXWiF70X1VuWbmhdLj.png'); 
			$hotel = new Hotel();
			$hotel->vender_id = $request->vender_id;
			$hotel->hotel_name = $request->hotel_name;
			$hotel->hotel_image = $path;
			$hotel->address = $request->address;
			$hotel->googleaddress = $request->googleaddress;
			$hotel->country = $request->country;
			$hotel->state = $request->state;
			$hotel->city = $request->city;
			$hotel->lat = $request->lat;
			$hotel->long = $request->long;
			$hotel->contact_name = $request->contact_name;
			$hotel->contact_number = $request->contact_number;
			$hotel->contact_email = $request->contact_email;
			$hotel->total_room = $request->total_room;
			$hotel->amenities_ids = $request->amenities_ids;
			$hotel->start_category = $request->start_category;
			$hotel->property_type = $request->property_type;
			$hotel->child_age = $request->child_age;
			$hotel->per_night = $request->per_night;
			$hotel->per_person = $request->per_person;
			$hotel->group_rate = $request->group_rate;
			$hotel->group_min_person = $request->group_min_person;
			$hotel->status = $request->status;
			$hotel->save();
			
			if($request->HasFile('image')){
				foreach($request->file('image') as $img){
					$path = $img->store('hotel_images');
					$gallery_image = new HotelGallery();
					$gallery_image->hotel_id = $hotel->id;					
					$gallery_image->image = $path;					
					$gallery_image->caption = 'Hotel Gallery Image';					
					$gallery_image->status = 'ACTIVE';
					$gallery_image->save();
				}
			}
			
			// Hotel Gallery Image
			if($request->HasFile('image')){
				foreach($request->file('image') as $img){
					$path = $img->store('hotel_images');
					$gallery_image = new HotelGallery();
					$gallery_image->hotel_id = $hotel->id;					
					$gallery_image->image = $path;					
					$gallery_image->caption = 'Hotel Gallery Image';					
					$gallery_image->status = 'ACTIVE';
					$gallery_image->save();
				}
			}
			
			// Hotel Amenities
			if($request->Has('amenities')){
				foreach($request->amenities as $amenity){
					$hotel_amenity = new HotelAmenity();
					$hotel_amenity->hotel_id = $hotel->id;					
					$hotel_amenity->amenity_id = $amenity;					
					$hotel_amenity->status = 'ACTIVE';
					$hotel_amenity->save();
				}
			}
			
			// Hotel Category
			if($request->Has('one_occupancy_cost')){
				$x = 0;
				foreach($request->one_occupancy_cost as $one_occupancy_cost){
					$room_category = new RoomCategory();
					$room_category->one_occupancy_cost = $one_occupancy_cost;
					$room_category->type = $request->type[$x];
					$room_category->name = $request->name[$x];
					$room_category->room_count = $request->room_count[$x];
					$room_category->adult_extra_cost = $request->adult_extra_cost[$x];
					$room_category->kid_extra_cost = $request->kid_extra_cost[$x];
					$room_category->one_occupancy_cost = $request->one_occupancy_cost[$x];
					$room_category->status = 'ACTIVE';
					$room_category->save();
					$x++;
				}
			}
			
			return redirect('admin/addhotel')->with('flash_success', 'SUCCESS : Hotel Add Successful!');
			
			/* dd($path);
		    DB::table('venders')->insert(["name" => $request->name, "email" => $request->email, "password" => bcrypt($request->password), "vender_type" => $request->vender_type, "country" => $request->country, "state" => $request->state, "city" => $request->city]); */
		    
		}catch(Exception $e){
			return response()->json(["error" => $e->getMessage()], 500);
		}
		
	}
	
	/**
	 * This function use for add hotel season rate
	 *
	 * @return array
	 */
	public function addHotelSeasonRate(){
		$hotels = Hotel::All();
		$roomcategories = RoomCategory::All();
		return view('admin/addhotelseasonrate', compact('hotels', 'roomcategories'));
	}
	
	/**
	 * This function use for add paid amenities
	 *
	 * @return array
	 */
	public function addPaidAmenities(){
		$amenities = Amenity::All();
		$hotels = Hotel::All();
		return view('admin/addpaidamenity', compact('amenities','hotels'));
	}
	
	
	/**
	 * This function use for add paid amenities action
	 *
	 * @return array
	 */
	public function addPaidAmenitiesAction(Request $request){
		$seasonrate = new PaidAmenity();
		$seasonrate->amenity_id = $request->amenity_id;
		$seasonrate->hotel_id = $request->hotel_id;
		$seasonrate->amount_type = $request->amount_type;
		$seasonrate->price = $request->price;
		$seasonrate->status = 'ACTIVE';
		$seasonrate->save();
		return redirect('admin/addamenity')->with('flash_success', 'SUCCESS : Paid Amenity Saved!');
	}
	
	/**
	 * This function use for add hotel season rate
	 *
	 * @return array
	 */
	public function addHotelGroupSeasonRate(){
		$hotels = Hotel::All();
		$roomcategories = RoomCategory::All();
		return view('admin/addhotelgroupseasonrate', compact('hotels', 'roomcategories'));
	}
	
	/**
	 * This function use for add hotel season rate Action
	 *
	 * @return array
	 */
	public function addHotelSeasonRateAction(Request $request){
		// Hotel Category
		
		if($request->Has('hotel_id')){
			$updatehotel = Hotel::where('id', $request->hotel_id)->first();
			$updatehotel->child_age = $request->child_age;
			$updatehotel->child_extra_cost = $request->child_extra_cost;
			$updatehotel->chable_adult_age = $request->chable_adult_age;
			$updatehotel->adult_extra_cost = $request->adult_extra_cost;
			$updatehotel->one_occupancy_cost = $request->one_occupancy_cost;
			$updatehotel->save();
			
			
			$count = count($request->room_category_id);
			for($x = 0; $x< $count; $x++){
				$seasonrate = new HotelSeasonRate(); 
				$seasonrate->hotel_id = $request->hotel_id;
				$seasonrate->room_category_id = $request->room_category_id[$x];
				$seasonrate->start_date = $request->start_date[$x];
				$seasonrate->end_date = $request->end_date[$x];
				$seasonrate->ep_price = $request->ep_price[$x];
				$seasonrate->cp_price = $request->cp_price[$x];
				$seasonrate->map_price = $request->map_price[$x];
				$seasonrate->ap_price = $request->ap_price[$x];
				$seasonrate->status = 'ACTIVE';
				$seasonrate->save();
			}
			
			return redirect('admin/addhotelseasonrate')->with('flash_success', 'SUCCESS : Hotel Season Rate Saved!');
		}
	}
	
	
	/**
	 * This function use for add hotel season rate Action
	 *
	 * @return array
	 */
	public function addHotelGroupSeasonRateAction(Request $request){
		// Hotel Category
		if($request->Has('hotel_id')){
			$x = 0;
			foreach($request->hotel_id as $hotel){
				$seasonrate = new HotelGroupSeasonRate();
				$seasonrate->hotel_id = $hotel;
				$seasonrate->start_date = $request->start_date[$x];
				$seasonrate->end_date = $request->end_date[$x];
				$seasonrate->from_no_person = $request->from_no_person[$x];
				$seasonrate->to_no_person = $request->to_no_person[$x];
				$seasonrate->single_sharing = $request->single_sharing[$x];
				$seasonrate->double_sharing = $request->double_sharing[$x];
				$seasonrate->triple_sharing = $request->triple_sharing[$x];
				$seasonrate->quad_sharing = $request->quad_sharing[$x];
				$seasonrate->penta_sharing = $request->penta_sharing[$x];
				$seasonrate->group_rate = $request->group_rate[$x];
				$seasonrate->per_person_rate = $request->per_person_rate[$x];
				$seasonrate->per_night_rate = $request->per_night_rate[$x];
				$seasonrate->status = 'ACTIVE';
				$seasonrate->save();
				$x++;
			}
		}
		return redirect('admin/addhotelgroupseasonrate')->with('flash_success', 'SUCCESS : Hotel Group Rate Saved!');
	}
	
	/**
	 * This function use for view the lead status
	 *
	 * @return array
	 */
	public function viewLeadStatus(Request $request){
        $active_lead = Lead::where('status', 'ACTIVE')->get();
        $active_lead_count = $active_lead->count();
        
        $active_quotation = Quotation::where('status', 'ACTIVE')->get();
        $active_quotation_count = $active_quotation->count();
        
        $active_sale = Sale::where('status', 'ACTIVE')->get();
        $active_sale_count = $active_sale->count();
        
        $leadlists = Lead::select( 'leads.lead_no', 'leads.create_date', 'leads.start_date', 'leads.lead_status','operators.name', 'quotations.price' )
                       ->join('operators', 'operators.id', '=', 'leads.assign_to')
                       ->leftJoin('quotations', 'quotations.lead_id', '=', 'leads.id')
                       ->orderBy('leads.id' , 'desc')->get();
        $leadcounts = Lead::select(DB::raw('count(leads.id) as total_lead'), DB::raw('sum(case when leads.status = "ACTIVE" then 1 else 0 end) as active_lead'), DB::raw('sum(case when leads.status = "INACTIVE" then 1 else 0 end) as inactive_lead'), 'operators.name')
                       ->join('operators', 'operators.id', '=', 'leads.assign_to')
                       ->groupBy('leads.assign_to')->get();
                       
        return view('admin/lead/viewstatus',compact('active_lead_count','active_quotation_count','active_sale_count', 'leadlists','leadcounts'));
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
       return view('admin/hotel/viewhotel', compact('Hotel','hotelamenity','hotelroomcategoires', 'hotelgalleries','hotelseasonrate', 'current_date'));
	}

    
  public function importContact(){
        
        return view('admin/contact/importcontact');
    }
    
    public function uploadContacts(Request $request){
        if($request->HasFile('import_contact')){
			$file = $request->file('import_contact');
			// File Details 
			$filename = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$tempPath = $file->getRealPath();
			$fileSize = $file->getSize();
			$mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");
			if(in_array(strtolower($extension),$valid_extension)){
                $file_read = fopen($file,"r");
				//$importData_arr = array();
				$i = 0;
				$duplicate_count = 0;
				$unique_count = 0;
				while (($filedata = fgetcsv($file_read, 1000, ",")) !== FALSE) {
					if($i == 0){
						$i++;
						continue; 
					}
					DB::enableQueryLog();
					if($filedata[0] != '' && $filedata[1] == ''){
						$contact = Contacts::where('mobile', $filedata[0])->first();
					}elseif($filedata[1] != '' && $filedata[0] == ''){
						$contact = Contacts::where('email', $filedata[1])->first();
					}else{
						$contact = Contacts::where('mobile', $filedata[0])->orWhere('email', $filedata[1])->first();
					}
					
					/* echo "<pre>";
					print_r(DB::getQueryLog()); 
					echo "</pre><br><br>"; */
					
					if( !empty($contact) ) {
						$duplicate_count++;
					}else{
                 
						$insertData = array(
						   "mobile"=>$filedata[0],
						   "email"=>$filedata[1],
						   "name"=>$filedata[2],
						   "location"=>$filedata[3],
						   "contact_type"=>$filedata[4],
						   "source"=>$filedata[5],
						   "status"=>'ACTIVE'
						);
						Contacts::create( $insertData );
						$unique_count++;
					}
					$i++;
				}
				//dd('Stop');
				$message = $unique_count ." records are inserted Successfully  <br>".$duplicate_count."  records are duplicate and already in he Database.";
                return redirect('admin/importcontact')->with('flash_success',$message);

            }else{
                return redirect('admin/importcontact')->with('flash_error', 'Invalid File Extension.');
            } 
        }else{
          return redirect('admin/importcontact')->with('flash_error', 'Please upload the CSV file');  
        }  

     }

	public function send1(){ 
		$text             = 'Hello Mail';
        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "Sales@ensoberhotels.com"; 
        $mail->Password = "neeraj123**";
        $mail->SetFrom("Sales@ensoberhotels.com", 'Ensober');
        $mail->Subject = "Ensober Email Test Subject";
        $mail->Body    = $text;
        $mail->AddAddress("sarwandeveloper@gmail.com", "Sarwan Verma");
        if ($mail->Send()) {
            return 'Email Sended Successfully';
        } else {
            return 'Failed to Send Email';
        }
	}
	
	public function gpdf(){
		$app->configure('dompdf');
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML('<h1>Test</h1>');
		return $pdf->stream();
	}
	
	public function phpInfoVal(){
		echo  phpinfo();
	}
}
