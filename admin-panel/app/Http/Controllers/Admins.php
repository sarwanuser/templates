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
use stdClass;
class Admins extends Controller{
	public function addadmin(){
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
				return view('pages/addadmin', ['data' => $data]);
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
    }
	
	public function editadmin($user_id){
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$user_id = $user_id;
			}else{
				if($data->sessionlogindata->user_role == 'kkadmin'){
					if($user_id == $data->sessionlogindata->ID){
						$user_id = intval($data->sessionlogindata->ID);
					}else{
						return redirect('admin/admins');
					}
				}else{
					return redirect('admin/dashboard');
				}
			}
			$data->usercount = DB::table('users')->where('ID', $user_id)->count();
			if($data->usercount > 0){
				$data->userdata = DB::table('users')->where('ID', $user_id)->first();
				
				$data->userdata->ID = $user_id;
				if($data->userdata->user_role == "admin"){
					$user_role = 1;
					$user_role = intval($user_role);
				}
				if($data->userdata->user_role == "kkadmin"){
					$user_role = 2;
					$user_role = intval($user_role); 
				}
				$data->userdata->user_role = $user_role;
				
				$data->userdata->user_reg_number = get_user_meta($user_id, 'user_reg_number', true);
				$first_name = get_user_meta($user_id, 'first_name', true);
				if($first_name){
					$first_name = $first_name;
				}else{
					$first_name = "First Name";
				}
				$last_name = get_user_meta($user_id, 'last_name', true);
				if($last_name){
					$last_name = $last_name;
				}else{
					$last_name = "Last Name";
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
				$data->userdata->user_state = get_user_meta($user_id, 'user_state', true);
				$data->userdata->hubid = get_user_meta($user_id, 'hub', true);
				if($data->userdata->hubid){
					$hubid = $data->userdata->hubid;
				}else{
					$hubid = 16;
				}
				$data->userdata->hubname = get_hubname_by_hubid($hubid);
			}			
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
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin') || ($data->sessionlogindata->user_role == 'kkadmin')){ 
				return view('pages/editadmin', ['data' => $data]);
			}else{
				return redirect('admin/dashboard');
			}
		}else{
			return redirect('/');
		}
    }
	public function adminlist(){ 
		if(is_admin_logged_in()){
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			$data->users = DB::table('users')->where([['user_role', '=', 'admin'], ['user_email', '!=', 'akash.sahay1@gmail.com']])->orWhere('user_role', 'kkadmin')->orderBy('user_email')->paginate(15);
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				return view('pages/adminlist', ['data' => $data]);
			}elseif($data->sessionlogindata->user_role == 'kkadmin'){
					$data->users = DB::table('users')->where('ID',  $data->sessionlogindata->ID)->paginate(15);
				return view('pages/adminlist', ['data' => $data]);
			}else{
				return redirect('admin/dashboard');
			}
			
		}else{
			return redirect('/');
		}
    }
	
}