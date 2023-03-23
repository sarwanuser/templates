<?php
/*--Admin Panel--*/
namespace App\Http\Controllers;
@include(app_path('Providers/Functions/logins/login.php'));
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;
use App;
use Cookie;
use DateTime;
use Carbon\Carbon;
use stdClass;
class Pages extends Controller{
	public function index(){
		
		if(is_admin_logged_in()){
			return redirect('admin/dashboard');
		}else{
			
			return view('pages/login');
		}
	}
    public function login(){
		if(is_admin_logged_in()){
			return redirect('admin/dashboard');
		}else{
			return view('pages/login');
		}
    }
	public function dashboard(){
		if(is_admin_logged_in()){
            $data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
            $cdateraw = new DateTime();
			$currentyear = $cdateraw->format('Y');
			$data->havan_count_1 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-01%']])->count();
			$data->havan_count_2 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-02%']])->count();
			$data->havan_count_3 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-03%']])->count();
			$data->havan_count_4 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-04%']])->count();
			$data->havan_count_5 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-05%']])->count();
			$data->havan_count_6 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-06%']])->count();
			$data->havan_count_7 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-07%']])->count();
			$data->havan_count_8 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-08%']])->count();
			$data->havan_count_9 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-09%']])->count();
			$data->havan_count_10 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-10%']])->count();
			$data->havan_count_11 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-11%']])->count();
			$data->havan_count_12 = DB::table("hawans")->where([['date_of_hawan', 'LIKE', '%'.$currentyear.'-12%']])->count();
			$mondayhc = 0;
			$tuesdayhc = 0;
			$wednesdayhc = 0;
			$thursdayhc = 0;
			$fridayhc = 0;
			$saturdayhc = 0;
			$sundayhc = 0;
            $cdate1 = $cdateraw->format('Y-m-d');
            $cday1 = $cdateraw->format('l');
			if($cday1 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			if($cday1 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			}
			$cdate2 = $cdateraw->modify('-1 days')->format('Y-m-d');
            $cday2 = $cdateraw->format('l');
			if($cday2 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			if($cday2 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			}
			$cdate3 = $cdateraw->modify('-1 days')->format('Y-m-d');
            $cday3 = $cdateraw->format('l');
			if($cday3 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			if($cday3 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			}
			$cdate4 = $cdateraw->modify('-1 days')->format('Y-m-d');
            $cday4 = $cdateraw->format('l');
			if($cday4 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			if($cday4 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			}
			$cdate5 = $cdateraw->modify('-1 days')->format('Y-m-d');
			$cday5 = $cdateraw->format('l');
			if($cday5 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			if($cday5 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			}
			$cdate6 = $cdateraw->modify('-1 days')->format('Y-m-d');
            $cday6 = $cdateraw->format('l');
			if($cday6 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			if($cday6 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate6)->count();
			}
			$cdate7 = $cdateraw->modify('-1 days')->format('Y-m-d');
			$cday7 = $cdateraw->format('l');
			if($cday7 == 'Monday'){
				$mondayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Tuesday'){
				$tuesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Wednesday'){
				$wednesdayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Thursday'){
				$thursdayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Friday'){
				$fridayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Saturday'){
				$saturdayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			if($cday7 == 'Sunday'){
				$sundayhc = DB::table('hawans')->where('date_of_hawan', $cdate7)->count();
			}
			$hawans1 = DB::table('hawans')->where('date_of_hawan', $cdate1)->count();
			$hawans2 = DB::table('hawans')->where('date_of_hawan', $cdate2)->count();
			$hawans3 = DB::table('hawans')->where('date_of_hawan', $cdate3)->count();
			$hawans4 = DB::table('hawans')->where('date_of_hawan', $cdate4)->count();
			$hawans5 = DB::table('hawans')->where('date_of_hawan', $cdate5)->count();
			$data->hawans = array($cdate1 => $hawans1, $cdate2 => $hawans2, $cdate3 => $hawans3, $cdate4 => $hawans4, $cdate5 => $hawans5);
			$data->weeklychartdata = array('monday' => $mondayhc, 'tuesday' => $tuesdayhc, 'wednesday' => $wednesdayhc, 'thursday' => $thursdayhc, 'friday' => $fridayhc, 'saturday' => $saturdayhc, 'sunday' => $sundayhc);

			$staechartdata = array();
			$staechartdata['and'] = DB::table('hawans')->where('state', 2)->count();
			$staechartdata['aru'] = DB::table('hawans')->where('state', 3)->count();
			$staechartdata['ass'] = DB::table('hawans')->where('state', 4)->count();
			$staechartdata['bih'] = DB::table('hawans')->where('state', 5)->count();
			$staechartdata['chh'] = DB::table('hawans')->where('state', 7)->count();
			$staechartdata['goa'] = DB::table('hawans')->where('state', 11)->count();
			$staechartdata['guj'] = DB::table('hawans')->where('state', 12)->count();
			$staechartdata['har'] = DB::table('hawans')->where('state', 13)->count();
			$staechartdata['him'] = DB::table('hawans')->where('state', 14)->count();
			$staechartdata['jha'] = DB::table('hawans')->where('state', 16)->count();
			$staechartdata['kar'] = DB::table('hawans')->where('state', 17)->count();
			$staechartdata['ker'] = DB::table('hawans')->where('state', 19)->count();
			$staechartdata['mad'] = DB::table('hawans')->where('state', 21)->count();
			$staechartdata['mah'] = DB::table('hawans')->where('state', 22)->count();
			$staechartdata['man'] = DB::table('hawans')->where('state', 23)->count();
			$staechartdata['meg'] = DB::table('hawans')->where('state', 24)->count();
			$staechartdata['miz'] = DB::table('hawans')->where('state', 25)->count();
			$staechartdata['nag'] = DB::table('hawans')->where('state', 26)->count();
			$staechartdata['odi'] = DB::table('hawans')->where('state', 29)->count();
			$staechartdata['pun'] = DB::table('hawans')->where('state', 32)->count();
			$staechartdata['raj'] = DB::table('hawans')->where('state', 33)->count();
			$staechartdata['sik'] = DB::table('hawans')->where('state', 34)->count();
			$staechartdata['tam'] = DB::table('hawans')->where('state', 35)->count();
			$staechartdata['tel'] = DB::table('hawans')->where('state', 36)->count();
			$staechartdata['tri'] = DB::table('hawans')->where('state', 37)->count();
			$staechartdata['utt'] = DB::table('hawans')->where('state', 38)->count();
			$staechartdata['utr'] = DB::table('hawans')->where('state', 39)->count();
			$staechartdata['wes'] = DB::table('hawans')->where('state', 41)->count();

			$data->stateschartdata = $staechartdata;
			$per_month_report = DB::select("select * from `per_month_user_wise_report`"); 
			return view('pages/dashboard', ['data' => $data, 'per_month_report' => $per_month_report]); 
		}else{
			return redirect('/');
		}
    }
    public function vidyarthis(){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$user_id = intval($data->sessionlogindata->ID);
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$data->users = DB::table('users')->where('user_role', 'vidyarthi')->orderBy('user_email')->paginate(15);
				return view('pages/users', ['data' => $data]);
			}else if($data->sessionlogindata->user_role == 'vidyarthi'){
				$data->users = DB::table('users')->where('ID', $user_id)->first();
				return view('pages/users', ['data' => $data]);
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
    }
	public function addvidyarthi(){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$data->countries_datacount = DB::table('countries')->count();
			if($data->countries_datacount > 0){
				$data->countries = DB::table('countries')->get();
			}
			$data->states_datacount = DB::table('states')->where('country_id', 101)->count();
			if($data->states_datacount > 0){
				$data->states = DB::table('states')->where('country_id', 101)->get();
			}
			$our_hub = DB::table('our_hub')->count();
			if($our_hub > 0){
				$data->our_hub = DB::table('our_hub')->orderBy('name')->get();
			}
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				return view('pages/adduser', ['data' => $data]);
			}else if($data->sessionlogindata->user_role == 'vidyarthi'){
				return redirect(url('admin/vidyarthis'));
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
	}
	public function editvidyarthi($user_id){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$user_id = $user_id;
			}else{
				if($data->sessionlogindata->user_role == 'vidyarthi'){
					if($user_id == $data->sessionlogindata->ID){
						$user_id = intval($data->sessionlogindata->ID);
					}else{
						return redirect('admin/dashboard');
					}
				}else{
					return redirect('admin/dashboard');
				}
			}
			$data->countries = DB::table('countries')->get();
			$data->usercount = DB::table('users')->where('ID', $user_id)->count();
			if($data->usercount > 0){
				$data->userdata = DB::table('users')->where('ID', $user_id)->first();
				$data->userdata->user_id = $user_id;
				$data->userdata->user_reg_number = get_user_meta($user_id, 'user_reg_number', true);
				$first_name = get_user_meta($user_id, 'first_name', true);
				if($first_name){
					$first_name = $first_name;
				}else{
					$first_name = "User";
				}
				$last_name = get_user_meta($user_id, 'last_name', true);
				if($last_name){
					$last_name = $last_name;
				}else{
					$last_name = "Name";
				}
				$data->userdata->user_name = $first_name." ".$last_name;
				$gender = get_user_meta($user_id, 'user_gender', true);
				if($gender){
					$gender = $gender;
				}else{
					$gender = "Male";
				}
				$data->userdata->user_gender = $gender;
				$phone_number = get_user_meta($user_id, 'phone_number', true);
				if($phone_number){
					$phone_number = $phone_number;
				}else{
					$phone_number = "9431900500";
				}
				$data->userdata->phone_number = $phone_number;
				$postcode = get_user_meta($user_id, 'postcode', true);
				if($postcode){
					$postcode = $postcode;
				}else{
					$postcode = "822116";
				}
				$data->userdata->postcode = $postcode;
				$user_country = get_user_meta($user_id, 'user_country', true);
				if($user_country){
					$user_country = $user_country;
				}else{
					$user_country = "IN";
				}
				$data->userdata->sortname = $user_country;
				$country_row_data = DB::table('countries')->where('sortname', $data->userdata->sortname)->first();
				$country_id = $country_row_data->ID;
				$data->country_by_states = DB::table('states')->where('country_id', $country_id)->get();
				$our_hub = DB::table('our_hub')->count();
				if($our_hub > 0){
					$data->our_hub = DB::table('our_hub')->orderBy('name')->get();
				}
				$hubid = intval(get_user_meta($user_id, 'hub', true));
				if($hubid){
					$hubid = $hubid;
				}else{
					$hubid = 16;
				}
				$data->userdata->hubid = $hubid;
				$user_state = get_user_meta($user_id, 'user_state', true);
				$data->userdata->user_state = get_user_meta($user_id, 'user_state', true);
				$user_address = get_user_meta($user_id, 'user_address', true);
				if($user_address){
					$user_address = $user_address;
				}else{
					$user_address ="Japla Dharhara Palamu Jharkhand 822116";
				}
				$data->userdata->user_address = $user_address;
				$comments = get_user_meta($user_id, 'comments', true);
				if($comments){
					$comments = $comments;
				}else{
					$comments ="No comments";
				}
				$data->userdata->comments = $comments;
				$data->userdata->user_profile_pic_id = get_user_meta($user_id, 'user_profile_pic', true);
				$data->userdata->profileimage_path = get_userimage($data->userdata->user_profile_pic_id);
				return view('pages/edituser', ['data' => $data]);
			}else{
				return redirect('admin/vidyarthis');
			}
		}else{
			return redirect('/');
		}
	}
	public function hawan(){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$data->is_search = 0;
			$data->syajnakartaname = "";
			$data->susername = "";
			$data->scontact = "";
			$data->sfromdate ="";
			$data->stoodate = "";
			$data->srashidcode = "";
			$data->srashidnofrom ="";
			if(!empty($_REQUEST['yajnakartaname'])){
				$yajnakartaname = true;
				$search_yajnakartaname = $_REQUEST['yajnakartaname'];
				$msearch_yajnakartaname = $search_yajnakartaname;
				$data->is_search = 1;
			}else{
				$yajnakartaname = false;
				$msearch_yajnakartaname = "";
			}
			$data->syajnakartaname = $msearch_yajnakartaname;
			
			if(!empty($_REQUEST['username'])){
				$username = true;
				$msusername = $_REQUEST['username'];
				$susernamearray = explode(' ', $msusername);
				$susernamearray = array_reverse($susernamearray);
				$suserfname = array_pop($susernamearray);
				$susernamearray = array_reverse($susernamearray);
				$suserlname = implode(" ", $susernamearray);
				$data->is_search = 1;
			}else{
				$username = false;
				$suserfname = "";
				$suserlname = "";
			}
			
			$data->suserfname = $suserfname;
			$data->suserlname = $suserlname;
			$data->susername = $data->suserfname . " " . $data->suserlname;
			
			if(!empty($_REQUEST['contact'])){
				$contact = true;
				$scontact = trim($_REQUEST['contact']);
				$mscontact = $scontact;
				$data->is_search = 1;
			}else{
				$contact = false;
				$scontact = "";
			}
			$data->scontact = $scontact;
			
			if(!empty($_REQUEST['fromdate'])){
				$fromdate = $_REQUEST['fromdate'];
				$sfromdate = new DateTime($_REQUEST['fromdate']);
				$sfromdate = $sfromdate->format('Y-m-d'); 
				$data->is_search = 1;
			}else{
				$fromdate = false;
				$sfromdate = "";
			}
			$data->sfromdate = $fromdate;
			
			if(!empty($_REQUEST['toodate'])){
				$toodate = $_REQUEST['toodate'];
				$stoodate = new DateTime($toodate);
				$stoodate = $stoodate->format('Y-m-d');
				$data->is_search = 1;				
			}else{
				$toodate = "";
				$stoodate = false;
			}
			$data->toodate = $toodate;
			
			if(!empty($_REQUEST['rashidnofrom'])){
				$rashidnofrom = true;
				$srashidnofrom = $_REQUEST['rashidnofrom'];
				$data->is_search = 1;				
			}else{
				$rashidnofrom = false;
				$srashidnofrom = "";
			}
			$data->srashidnofrom = $srashidnofrom;
			if(!empty($_REQUEST['rashidcode'])){
				$rashidcode = true;
				$srashidcode = $_REQUEST['rashidcode'];
				$data->is_search = 1;				
			}else{
				$rashidcode = false;
				$srashidcode = "";
			}
			$data->srashidcode = $srashidcode;
			
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){				
				$data->hawans = DB::table('hawans')
				->select('hawans.*', 'user_meta.user_id as userid', 'user_meta.meta_key', 'user_meta.meta_value')
				->join('user_meta', 'hawans.user_id', '=', 'user_meta.user_id')				
				->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
					return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
				})
				->when($username, function($query) use ($suserfname, $suserlname){
					return $query->where([['user_meta.meta_value', 'LIKE', '%'.$suserfname.'%']]);
				})
				->when($srashidnofrom, function($query) use ($srashidnofrom){
					return $query->where([['hawans.rashid_number', '>=', $srashidnofrom]]);
				})
				->when($srashidcode, function($query) use($srashidcode) {
					return $query->where([['hawans.rashid_code', '=', $srashidcode]]);
				})				
				->when($sfromdate, function($query) use ($sfromdate){
					return $query->where([['hawans.date_of_hawan', '>=', $sfromdate]]);
				})
				->when($stoodate, function($query) use ($stoodate){
					return $query->where('hawans.date_of_hawan', '<=', $stoodate);
				})
				->orderBy('date_of_hawan', 'DESC')
				->groupBy('hawans.ID')
				->paginate(10);
			}else if(($data->sessionlogindata->user_role == 'kkadmin')){
				$data->hawans = DB::table('hawans')				
				->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
					return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
				})
				->when($username, function($query) use ($suserfname, $suserlname){
					return $query->where([['user_meta.meta_value', 'LIKE', '%'.$suserfname.'%']]);
				})
				->when($srashidnofrom, function($query) use ($srashidnofrom){
					return $query->where([['hawans.rashid_number', '>=', $srashidnofrom]]);
				})
				->when($srashidcode, function($query) use($srashidcode) {
					return $query->where([['hawans.rashid_code', '=', $srashidcode]]);
				})				
				->when($sfromdate, function($query) use ($sfromdate){
					return $query->where([['hawans.date_of_hawan', '>=', $sfromdate]]);
				})
				->when($stoodate, function($query) use ($stoodate){
					return $query->where('hawans.date_of_hawan', '<=', $stoodate);
				})				
				->where('hub_id', $data->sessionlogindata->hub_id)
				->orderBy('date_of_hawan', 'DESC')
				->groupBy('hawans.ID')
				->paginate(10);
			}else{
				$data->hawans = DB::table('hawans')
				->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
					return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
				})
				->when($username, function($query) use ($suserfname, $suserlname){
					return $query->where([['user_meta.meta_value', 'LIKE', '%'.$suserfname.'%']]);
				})
				->when($srashidnofrom, function($query) use ($srashidnofrom){
					return $query->where([['hawans.rashid_number', '>=', $srashidnofrom]]);
				})
				->when($srashidcode, function($query) use($srashidcode) {
					return $query->where([['hawans.rashid_code', '=', $srashidcode]]);
				})				
				->when($sfromdate, function($query) use ($sfromdate){
					return $query->where([['hawans.date_of_hawan', '>=', $sfromdate]]);
				})
				->when($stoodate, function($query) use ($stoodate){
					return $query->where('hawans.date_of_hawan', '<=', $stoodate);
				})				
				->where('user_id', $data->sessionlogindata->ID)
				->orderBy('date_of_hawan', 'DESC')
				->groupBy('hawans.ID')
				->paginate(10);
			}
			return view('pages/hawan', ['data' => $data]);
		}else{
			return redirect('/'); 
		}
	}
	public function addhawan(){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$vidyarthicount = DB::table('users')->where('user_role', '=', 'vidyarthi')->count();
			if($vidyarthicount > 0){
				$data->vidyarthi = DB::table('users')->where('user_role', '=', 'vidyarthi')->get();
			}
			$data->countries_datacount = DB::table('countries')->count();
			if($data->countries_datacount > 0){
				$data->countries = DB::table('countries')->get();
			}
			$data->states_datacount = DB::table('states')->where('country_id', 101)->count();
			if($data->states_datacount > 0){
				$data->states = DB::table('states')->where('country_id', 101)->get();
			}

			$data->district_datacount = DB::table('districts')->where('state_id', 16)->count();
			if($data->district_datacount > 0){
				$data->districts = DB::table('districts')->where('state_id', 16)->get();
			}

			$our_hub = DB::table('our_hub')->count();
			if($our_hub > 0){
				$data->our_hub = DB::table('our_hub')->orderBy('name')->get();
			}

			$purpose_of_hawanc = DB::table('purpose_of_hawan')->count();
			if($purpose_of_hawanc > 0){
				$data->purpose_of_hawans = DB::table('purpose_of_hawan')->orderBy('name')->get();
			}

			$currentmonth = intval(date("m"));

			if($currentmonth >= 4){
				$data->rashidcode = "VYS/HYS/".date("y")."-".date("y", strtotime("+1 year"));
			}else{
				$data->rashidcode = "VYS/HYS/".date("y", strtotime("-1 year"))."-".date("y");
			}

			$user_id = intval($data->sessionlogindata->ID);
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')|| ($data->sessionlogindata->user_role == 'kkadmin') || ($data->sessionlogindata->user_role == 'vidyarthi')){
				return view('pages/addhawan', ['data' => $data]);
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
	}
	public function edithawan($hawan_id){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$hawan_id = $hawan_id;
			}else{
				$user_id = intval($data->sessionlogindata->ID);
				$vidyarthihawandata = DB::table('hawans')->where('user_id', '=', $user_id)->get();
				$hawan_ids = array();
				foreach($vidyarthihawandata as $vidyarthihawan){
					$hawan_ids[] = $vidyarthihawan->ID;
				}
				if(in_array($hawan_id, $hawan_ids)){
					$hawan_id = $hawan_id;
				}else{
					return redirect('admin/hawans');
				}
			}
			$data->vidyarthi = DB::table('users')->where('user_role', '=', 'vidyarthi')->get();
			$data->countries = DB::table('countries')->get();
			$data->hawanscount = DB::table('hawans')->where('ID', $hawan_id)->count();
			$our_hub = DB::table('our_hub')->count();
			if($our_hub > 0){
				$data->our_hub = DB::table('our_hub')->orderBy('name')->get();
			}
			if($data->hawanscount > 0){
				$data->hawandata = DB::table('hawans')
				->join('users', 'hawans.user_id', '=', 'users.ID')
				->select('hawans.*', 'users.user_email')
				->where('hawans.ID', '=', $hawan_id)
				->first();
				$data->userdata = DB::table('users')->where('ID', $data->hawandata->user_id)->first();
				$data->userdata->user_profile_pic_id = get_user_meta($data->hawandata->user_id, 'user_profile_pic', true);
				$data->userdata->profileimage_path = get_userimage($data->userdata->user_profile_pic_id);
				$data->userdata->phone_number = get_user_meta($data->hawandata->user_id, 'phone_number', true);
				$newregdtp = new DateTime($data->userdata->user_registered);
				$data->userdata->regdtp = $newregdtp->format('d-m-Y');
				$user_country = get_user_meta($data->hawandata->user_id, 'user_country', true);
				if($user_country){
					$user_country = $user_country;
				}else{
					$user_country = "IN";
				}
				$data->userdata->sortname = $user_country;
				$user_country_row_data = DB::table('countries')->where('sortname', $data->userdata->sortname)->first();
				$data->userdata->country_name = $user_country_row_data->name;
				$newhawandatetime = new DateTime($data->hawandata->date_of_hawan);
				$data->hawandata->dateofhawan = $newhawandatetime->format('d-m-Y');
				$postcode = get_user_meta($data->hawandata->user_id, 'postcode', true);
				if($postcode){
					$postcode = $postcode;
				}else{
					$postcode = 822116;
				}
				$data->userdata->vi_postcode = $postcode;
				$data->country_by_states = DB::table('states')->where('country_id', $data->hawandata->country_code)->get();
				$data->userdata->user_state = get_user_meta($data->hawandata->user_id, 'user_state', true);
				$hub = get_user_meta($data->hawandata->user_id, 'hub', true);
				if($hub){
					$hub = $hub;
				}else{
					$hub = 16;
				}

				$data->district_datacount = DB::table('districts')->where('ID', $data->hawandata->distric)->count();
				if($data->district_datacount > 0){
					$data->districts = DB::table('districts')->where('state_id', $data->hawandata->state)->get();
				}


				$vi_hub = intval($hub);
				$our_hub = DB::table('our_hub')->where('ID', $vi_hub)->first();
				$data->userdata->vi_name = $our_hub->name;
				$data->userdata->user_address = get_user_meta($data->hawandata->user_id, 'user_address', true);
				$data->userdata->comments = get_user_meta($data->hawandata->user_id, 'comments', true);
				$data->hawandata->postcode = get_hawan_meta($data->hawandata->ID, 'postcode', true);
				$data->hawandata->swamiji_seva_amt = get_hawan_meta($data->hawandata->ID, 'swamiji_seva_amt', true);
				$data->hawandata->swamiji_general_seva_amt = get_hawan_meta($data->hawandata->ID, 'swamiji_general_seva_amt', true);
				$data->hawandata->swamiji_other_seva_amt = get_hawan_meta($data->hawandata->ID, 'swamiji_other_seva_amt', true);
				$data->hawandata->ashram_amt_paid_status = get_hawan_meta($data->hawandata->ID, 'ashram_amt_paid_status', true);
				$data->hawandata->ashram_amt_payment_mode = get_hawan_meta($data->hawandata->ID, 'ashram_amt_payment_mode', true);
				$data->hawandata->vidyarthi_seva_amt = get_hawan_meta($data->hawandata->ID, 'vidyarthi_seva_amt', true);
				$data->hawandata->travell_seva_amt = get_hawan_meta($data->hawandata->ID, 'travell_seva_amt', true);
				$data->hawandata->vidyarthi_other_seva_amt = get_hawan_meta($data->hawandata->ID, 'vidyarthi_other_seva_amt', true);
				$data->hawandata->rashidimage_id = get_hawan_meta($data->hawandata->ID, 'rashidimage_id', true);
				$data->hawandata->rashidimage = get_rashidimage($data->hawandata->rashidimage_id);
				$purpose_of_hawanc = DB::table('purpose_of_hawan')->count();
				if($purpose_of_hawanc > 0){
					$data->purpose_of_hawans = DB::table('purpose_of_hawan')->orderBy('name')->get();
				}
				$purposeofhawan = intval(get_hawan_meta($hawan_id, 'purpose_of_hawan', true));
				if($purposeofhawan){
					$data->hawandata->purposeofhawan = $purposeofhawan;
				}else{
					$data->hawandata->purposeofhawan = 2;
				}
				$data->hawandata->hawan_orgniser_name = get_hawan_meta($data->hawandata->ID, 'hawan_orgniser_name', true);
				$data->hawandata->hawan_orgniser_ph = get_hawan_meta($data->hawandata->ID, 'hawan_orgniser_ph', true);
				$data->hawandata->hod_postcode = get_hawan_meta($data->hawandata->ID, 'hod_postcode', true);
				$data->hawandata->hawan_orgniser_country = get_hawan_meta($data->hawandata->ID, 'hawan_orgniser_country', true);
				$data->hawandata->hawan_orgniser_state = get_hawan_meta($hawan_id, 'hawan_orgniser_state', true);
				$data->hawandata->satsang = get_hawan_meta($data->hawandata->ID, 'satsang', true);
				$data->hawandata->newserved = get_hawan_meta($data->hawandata->ID, 'new_served', true);
				$data->hawandata->serwedqty = get_hawan_meta($data->hawandata->ID, 'serwedqty', true);
				$data->hawandata->newpatrika = get_hawan_meta($data->hawandata->ID, 'new_patrika', true);
				$data->hawandata->newpatrikaqty = get_hawan_meta($data->hawandata->ID, 'newpatrikaqty', true);
				$data->hawandata->newakshaypatra = get_hawan_meta($data->hawandata->ID, 'new_akshay_patra', true);
				$data->hawandata->newakshaypatraqty = get_hawan_meta($data->hawandata->ID, 'newakshaypatraqty', true);
				$data->hawandata->newupdesh = get_hawan_meta($data->hawandata->ID, 'newupdesh', true);
				$data->hawandata->peopleattendedhawan = get_hawan_meta($data->hawandata->ID, 'peopleattendedhawan', true);
				return view('pages/edithawan', ['data' => $data]);
			}else{
				return redirect('admin/hawans/');
			}
		}else{
			return redirect('/');
		}
	}
	public function guestreservations($guest_id){
		if(is_admin_logged_in()){
            $data = new stdClass();
			$data->guest_id = $guest_id;
			$data->reservations = DB::table('btb_bookings')->where('customer_id', $guest_id)->paginate(15);
			return view('pages/guestreservations', ['data' => $data]);
		}else{
			return redirect('/');
		}
	}
	public function guestpromotions($guest_id){
		if(is_admin_logged_in()){
            $data = new stdClass();
			$data->guests = DB::table('btb_favpromotions')->where('user_id', $guest_id)->paginate(15);
			return view('pages/guestpromotions', ['data' => $data]);
		}else{
			return redirect('/');
		}
	}
	public function search(){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$data->countries_datacount = DB::table('countries')->count();
			if($data->countries_datacount > 0){
				$data->countries = DB::table('countries')->get();
			}
			$data->states_datacount = DB::table('states')->where('country_id', 101)->count();
			if($data->states_datacount > 0){
				$data->states = DB::table('states')->where('country_id', 101)->get();
			}
			$data->is_search = 0;
			$data->hawansc = 0;
			$data->ssearchby = "";
			$data->syajnakartaname = "";
			$data->susername = "";
			$data->scontact = "";
			$data->sfromdate ="";
			$data->stoodate = "";
			$data->scountry = "";
			$our_hub = DB::table('our_hub')->count();
			if($our_hub > 0){
				$data->our_hub = DB::table('our_hub')->orderBy('name')->get();
			}
			$data->country_by_states = "";
			$data->sstate = "";
			$data->shubid = "";
			$data->sdistrict = "";
			$data->srashidcode = "";
			$data->srashidnofrom ="";
			$data->srashidnoto ="";
			$ssearchby = "";
			$msearch_yajnakartaname = "";
			$susername = "";
			$scontact = "";
			$sfromdate = "";
			$stoodate = "";
			$sdistrict = "";
			$srashidcode = "";
			$srashidnofrom ="";
			$srashidnoto ="";
			if(isset($_REQUEST['is_search'])){
				if(!empty($_REQUEST['searchby'])){
					$searchby = $_REQUEST['searchby'];
					$ssearchby = trim($_REQUEST['searchby']);
				}else{
					$searchby = "";
					$ssearchby = "";
				}
				$data->ssearchby = $searchby;
				if(!empty($_REQUEST['yajnakartaname'])){
					$yajnakartaname = true;
					$search_yajnakartaname = $_REQUEST['yajnakartaname'];
					$msearch_yajnakartaname = $search_yajnakartaname;
				}else{
					$yajnakartaname = false;
					$msearch_yajnakartaname = "";
				}
				$data->syajnakartaname = $msearch_yajnakartaname;
				if(!empty($_REQUEST['username'])){
					$username = true;
					$susername = $_REQUEST['username'];
					$msusername = $susername;
					$susernamearray = explode(' ', $msusername);
					if(isset($susernamearray[1])){
						$suserfname = $susernamearray[0];
						$suserlname = $susernamearray[1];
						$msusername = trim($suserfname);
					}else{
						$msusername = trim($susername);
					}
				}else{
					$username = false;
					$msusername = "";
				}
				$data->susername = $susername;
				if(!empty($_REQUEST['contact'])){
					$contact = true;
					$scontact = trim($_REQUEST['contact']);
					$mscontact = $scontact;
				}else{
					$contact = false;
					$scontact = "";
				}
				$data->scontact = $scontact;
				if(!empty($_REQUEST['fromdate'])){
					$fromdate = $_REQUEST['fromdate'];
					$sfromdate = new DateTime($_REQUEST['fromdate']);
					$sfromdate = $sfromdate->format('Y-m-d');
				}else{
					$fromdate = false;
					$sfromdate = "";
				}
				$data->sfromdate = $fromdate;
				if(!empty($_REQUEST['toodate'])){
					$toodate = $_REQUEST['toodate'];
					$stoodate = new DateTime($_REQUEST['toodate']);
					$stoodate = $stoodate->format('Y-m-d');
				}else{
					$toodate = "";
					$stoodate = "";
				}
				$data->stoodate = $toodate;
				if(!empty($_REQUEST['country'])){
					$scountry = $_REQUEST['country'];
				}else{
					$scountry = 101;
				}
				$data->scountry = $scountry;
				if(!empty($_REQUEST['state'])){
					$is_sstate = true;
					$sstate = $_REQUEST['state'];
				}else{
					$is_sstate = false;
					$sstate = "";
				}
				$data->sstate = $sstate;
				if($data->scountry !=""){
					$country_row = DB::table('countries')->where('ID', $data->scountry)->first();
					$data->country_by_states = DB::table('states')->where('country_id', $country_row->ID)->get();
				}
				if(!empty($_REQUEST['hub'])){
					$is_shubid = true;
					$shubid = $_REQUEST['hub'];
				}else{
					$is_shubid = false;
					$shubid = "";
				}
				$data->shubid = $shubid;
				if(!empty($_REQUEST['district'])){
					$is_district = true;
					$sdistrict = $_REQUEST['district'];
				}else{
					$is_district = false;
					$sdistrict = "";
				}
				$data->sdistrict = $sdistrict;
				if(!empty($_REQUEST['rashidcode'])){
					$rashidcode = true;
					$srashidcode = $_REQUEST['rashidcode'];
				}else{
					$rashidcode = false;
					$srashidcode = "";
				}
				$data->srashidcode = $srashidcode;
				if(!empty($_REQUEST['rashidnofrom'])){
					$rashidnofrom = true;
					$srashidnofrom = $_REQUEST['rashidnofrom'];
				}else{
					$rashidnofrom = false;
					$srashidnofrom = "";
				}
				$data->srashidnofrom = $srashidnofrom;
				if(!empty($_REQUEST['rashidnoto'])){
					$rashidnoto = true;
					$srashidnoto = $_REQUEST['rashidnoto'];
				}else{
					$rashidnoto = false;
					$srashidnoto = "";
				}
				$data->srashidnoto = $srashidnoto;
				/*--  Search State Wise Start --*/
				if($data->ssearchby == "statewise"){
					$data->hawans = DB::table('hawans')
					->join('users', 'hawans.user_id', '=', 'users.ID')
					->select('hawans.ID as hawan_id', 'hawans.state', 'users.ID as vidyarthi_id')
					->where('users.user_role', 'vidyarthi')
					->when($scountry, function($query) use($scountry) {
						return $query->where([['hawans.country_code', '=', $scountry]]);
					})
					->when($sstate, function($query) use($sstate) {
						return $query->where([['hawans.state', '=', $sstate]]);
					})
					->groupBy('hawans.state')
					->paginate(30);
					$data->hawansc = $data->hawans->total();
					$data->is_search = 1;
				}
				/*--  Search District Wise Start --*/
				if($data->ssearchby == "districtwise"){
					$data->hawans = DB::table('hawans')
					->join('users', 'hawans.user_id', '=', 'users.ID')
					->select('hawans.ID as hawan_id', 'hawans.rashid_code', 'hawans.state', 'hawans.distric', 'hawans.date_of_hawan', 'users.ID as vidyarthi_id', 'users.user_email')
					->where('users.user_role', 'vidyarthi')
					->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
						return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
					})
					->when($username, function($query) use ($msusername){
						return $query->join('user_meta', 'hawans.user_id', '=', 'user_meta.user_id')->where([['user_meta.meta_value', 'LIKE', '%'.$msusername.'%']]);
					})
					->when($scountry, function($query, $scountry) {
						return $query->where([['hawans.country_code', '=', $scountry]]);
					})
					->when($is_sstate, function($query) use($sstate) {
						return $query->where([['hawans.state', '=', $sstate]]);
					})
					->groupBy('hawans.distric')
					->paginate(30);
					$data->hawansc = $data->hawans->total();
					$data->is_search = 1;
				}
				/*--  Search Vidyarthi Wise Start --*/
				if($data->ssearchby == "vidyarthiwise"){
					$data->hawans = DB::table('hawans')
					->join('users', 'hawans.user_id', '=', 'users.ID')
					->select('hawans.ID as hawan_id', 'hawans.rashid_code', 'hawans.rashid_number', 'hawans.state', 'hawans.distric', 'hawans.date_of_hawan', 'users.ID as vidyarthi_id', 'users.user_email')
					->where('users.user_role', 'vidyarthi')
					->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
						return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
					})
					->when($username, function($query) use ($msusername){
						return $query->join('user_meta', 'hawans.user_id', '=', 'user_meta.user_id')->where([['user_meta.meta_value', 'LIKE', '%'.$msusername.'%']]);
					})
					->when($sfromdate, function($query) use ($sfromdate){
						return $query->where([['hawans.date_of_hawan', '>=', $sfromdate]]);
					})
					->when($stoodate, function($query) use ($stoodate){
						return $query->where('hawans.date_of_hawan', '<=', $stoodate);
					})
					->when($scountry, function($query) use($scountry) {
						return $query->where([['hawans.country_code', '=', $scountry]]);
					})
					->when($sstate, function($query) use ($sstate) {
						return $query->where([['hawans.state', '=', $sstate]]);
					})
					->when($sdistrict, function($query) use ($sdistrict) {
						return $query->where([['hawans.distric', '=', $sdistrict]]);
					})
					->when($srashidcode, function($query) use($srashidcode) {
						return $query->where([['hawans.rashid_code', '=', $srashidcode]]);
					})
					->when($srashidnofrom, function($query) use ($srashidnofrom){
						return $query->where([['hawans.rashid_number', '>=', $srashidnofrom]]);
					})
					->when($srashidnoto, function($query) use ($srashidnoto){
						return $query->where([['hawans.rashid_number', '<=', $srashidnoto]]);
					})
					->groupBy('hawans.user_id')
					->paginate(30);
					$data->hawansc = $data->hawans->total();
					$data->is_search = 1;
				}
				/*--  Search Hub Wise Start --*/
				if($data->ssearchby == "hubwise"){
					$data->hawans = DB::table('hawans')
					->select('hawans.ID as hawan_id', 'hawans.hub_id', 'our_hub.name as hubname')
					->join('our_hub', 'hawans.hub_id', '=', 'our_hub.ID')
					->when($scountry, function($query) use($scountry) {
						return $query->where([['hawans.country_code', '=', $scountry]]);
					})
					->when($is_shubid, function($query) use($shubid) {
						return $query->where([['hawans.hub_id', '=', $shubid]]);
					})
					->groupBy('hawans.hub_id')
					->paginate(30);
					$data->hawansc = $data->hawans->total();
					$data->is_search = 1;
				}
				/*--Search All Start--*/
				if($data->ssearchby == "all"){
					$data->hawans = DB::table('hawans')
					->join('users', 'hawans.user_id', '=', 'users.ID')
					->select('hawans.ID as hawan_id', 'hawans.rashid_code', 'hawans.rashid_number', 'hawans.state', 'hawans.distric', 'hawans.date_of_hawan', 'users.ID as vidyarthi_id', 'users.user_email')
					->where('users.user_role', 'vidyarthi')
					->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
						return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
					})
					->when($username, function($query) use ($msusername){
						return $query->join('user_meta', 'hawans.user_id', '=', 'user_meta.user_id')->where([['user_meta.meta_value', 'LIKE', '%'.$msusername.'%']]);
					})
					->when($sfromdate, function($query) use ($sfromdate){
						return $query->where([['hawans.date_of_hawan', '>=', $sfromdate]]);
					})
					->when($stoodate, function($query) use ($stoodate){
						return $query->where('hawans.date_of_hawan', '<=', $stoodate);
					})
					->when($scountry, function($query) use($scountry) {
						return $query->where([['hawans.country_code', '=', $scountry]]);
					})
					->when($sstate, function($query) use ($sstate) {
						return $query->where([['hawans.state', '=', $sstate]]);
					})
					->when($sdistrict, function($query) use ($sdistrict) {
						return $query->where([['hawans.distric', '=', $sdistrict]]);
					})
					->when($srashidcode, function($query) use($srashidcode) {
						return $query->where([['hawans.rashid_code', '=', $srashidcode]]);
					})
					->when($srashidnofrom, function($query) use ($srashidnofrom){
						return $query->where([['hawans.rashid_number', '>=', $srashidnofrom]]);
					})
					->when($srashidnoto, function($query) use ($srashidnoto){
						return $query->where([['hawans.rashid_number', '<=', $srashidnoto]]);
					})
					->paginate(30);
					$data->hawansc = $data->hawans->total();
					$data->is_search = 1;
				}
			}else{
				$data->hawans = array();
				$data->hawansc = 0;
				$data->is_search = 0;
			}
			$data->username = $susername;
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				return view('pages/search', ['data' => $data]);
			}else if($data->sessionlogindata->user_role == 'vidyarthi'){
				return redirect(url('admin/dashboard'));
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
	}
	public function settings(){
		if(is_admin_logged_in()){
			return view('pages/settings');
		}else{
			return redirect('/');
		}
	}
	public function help(){
		if(is_admin_logged_in()){
			return view('pages/help');
		}else{
			return redirect('/');
		}
	}
	public function logout(){
        session()->flush();
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach ($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time() - 10000000);
			setcookie($name, '', time() - 10000000, '/');
		}
		return redirect('/');
    }
}
