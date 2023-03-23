<?php
	@include(app_path("Providers/Functions/Emails.php"));
	global $userdatag;
	use Illuminate\Support\Facades\DB;
	use Session;

	function strong_password($password){
		$cost = 10;
		$salt = strtr(base64_encode(random_bytes(16)), '+', '.');
		$salt = sprintf("$2a$%02d$",$cost).$salt;
		$hash=crypt($password,$salt);
		return $hash; 
	}

	function check_password($oldpass, $newpass){
		if(hash_equals($oldpass, crypt($newpass, $oldpass))){
			return true;
		}else{
			return false;
		}
	}

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	function get_user_count(){
		$user_recordc = DB::table('users')->where('user_role', 'vidyarthi')->count();
		return $user_recordc;
	}
	function add_user($usernm, $userem, $oathtype, $passwd, $role, $displayname){
		$resultc = DB::table('users')->where([['user_name', '=', $usernm], ['user_oathtype', '=', $oathtype], ['user_role', '=', $role]])->count();
		if($resultc > 0){
			return false;
		}else{
			if($passwd==""){$passwd=time();}
			$encpass = strong_password($passwd);
			$displayname = mb_substr( $displayname, 0, 50 );
			$newuserid = DB::table('users')->insertGetId(['user_name' => $usernm, 'user_email' => $userem, 'user_password' => $encpass, 'user_oathtype' => $oathtype, 'user_role' => $role, 'user_status' => 0, 'user_registered' => date('Y-m-d h:i', time()), 'display_name' => $displayname]);
			return $newuserid;
		}
	}

	function get_user($userid){
		$userdatarow = DB::table('users')->where('ID', $userid)->first();
		return $userdatarow;
	}

	function add_user_meta($user_id, $metak, $metav){
		DB::table('user_meta')->insert([['user_id' => $user_id, 'meta_key' => $metak, 'meta_value' => $metav]]);
	}

	function get_user_meta($user_id, $metak, $singular){
		if($singular==true){
			$usermetac = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->count();
			if($usermetac > 0){
				$usermeta = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->first();
				return $usermeta->meta_value;
			}else{
				return "";
			}
		}else{
			$usermetasc = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->count();
			if($usermetasc > 0){
				$usermetas = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->get();
				$usermetadata = array();
				foreach($usermetas as $usermeta){
					array_push($usermetadata, array("meta_key" => $usermeta->meta_key, "meta_value" => $usermeta->meta_value));
				}
				return $usermetadata;
			}else{
				return "";
			}
		}
	}

	function update_user_meta($user_id, $metak, $metav){
		$resultc = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->count();
		if($resultc > 0){
			$result = DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->get();
			DB::table('user_meta')->where(['user_id' => $user_id, 'meta_key' => $metak])->update(['meta_value' => $metav]);
		}else{
			DB::table('user_meta')->insert([['user_id' => $user_id, 'meta_key' => $metak, 'meta_value' => $metav]]);
		}
	}

	function delete_user_meta($user_id, $metak){
		DB::table('user_meta')->where([['user_id', '=', $user_id], ['meta_key', '=', $metak]])->delete();
	}

	function update_media($attachment_id, $restmediadata){
		if(is_array($restmediadata)){
			foreach($restmediadata as $restmediadatak => $restmediadatav){
				if(isset($restmediadatav)){
					DB::table('btb_media')->where('ID', $attachment_id)->update(array($restmediadatak => $restmediadatav));
				}
			}
			return true;
		}
	}

	function get_country($sortname){
		$country_sortname = DB::table('countries')->where('sortname', $sortname)->first();
		return $country_name = $country_sortname->name;;
	}
	
	function checkuser($useralldata){
		$usrfn = $useralldata['first_name'];
		$usrln = $useralldata['last_name'];
		$usrem = $useralldata['email'];
		if(isset($useralldata['gender'])){
			$usrgen = $useralldata['gender'];
		}else{
			$usrgen = 'N/S';
		}
		$usrlocale = $useralldata['locale'];
		$usrpic = $useralldata['picture'];
		$usroathtype = $useralldata['oauth_type'];
		$userpass = $useralldata['userpass'];
		$usersc = DB::table('users')->where([['user_email', '=', $usrem], ['user_oathtype', '=', $usroathtype], ['user_role', '=', 'customer']])->count();
 		if($usersc > 0){
			$user = DB::table('users')->where([['user_email', '=', $usrem], ['user_oathtype', '=', $usroathtype], ['user_role', '=', 'customer']])->first();
			update_user_meta($user->ID, 'user_oathtype', $usroathtype);
			update_user_meta($user->ID, 'first_name', $usrfn);
			update_user_meta($user->ID, 'last_name', $usrln);
			update_user_meta($user->ID, 'gender', $usrgen);
			update_user_meta($user->ID, 'locale', $usrlocale);
			update_user_meta($user->ID, 'user_avatar', $usrpic);
			$useralldata['ID'] = $user->ID;
			$useralldata['user_role'] = $user->user_role;
			$useralldata['display_name'] = $usrfn;
			Session::put(['gloggedin' => 1, 'guserdata' => json_encode($useralldata)]);
			Session::save();
			return $user->ID;
		}else{
			$dispname = mb_substr( $usrfn, 0, 50 );
			$userid = add_user($usrem, $usrem, $usroathtype, $userpass, 'customer', $dispname);
			$delivery_address1 = "";
			$delivery_address2 = "";
			$delivery_address3 = "";
			$userphone = "";
			$phone_code = "";
			$country_code = "";
			update_user_meta($userid, 'first_name', $usrfn);
			update_user_meta($userid, 'last_name', $usrln);
			update_user_meta($userid, 'gender', $usrgen);
			update_user_meta($userid, 'locale', $usrlocale);
			update_user_meta($userid, 'user_avatar', $usrpic);
			$useralldata['ID'] = $userid;
			$useralldata['display_name'] = $usrfn;
			$useralldata['user_role'] = 'customer';
			signup_confirmation_email($usrfn, $usrln, $usrem);
			Session::put(['gloggedin' => 1, 'guserdata' => json_encode($useralldata)]);
			Session::save();
			return $userid;
		}
	}

	/*--Guest Related Functions--*/
	function get_current_guest(){
		$status = Session::get('gloggedin');
		if($status){
			$userdata = Session::get('guserdata');
			return $userdata;
		}else{
			return false;
		}
	}

	function get_current_guestid(){
		$status = Session::get('gloggedin');
		if($status){
			$userdata = Session::get('guserdata');
			$userdata = json_decode($userdata);
			return $userdata->ID;
		}else{
			return false;
		}
	}

	function is_guest_logged_in(){
		$status = Session::get('gloggedin');		
		if($status){
			return true;
		}else{
			return false;
		}
	} 


	/*--Admin Related Functions--*/
	function is_user_admin(){
		$status = Session::get('aloggedin');
		if($status==1){
			$userdata = json_decode(Session::get('userdata'), true);
			$uid = $userdata['ID'];
			$userrole = $userdata['user_role'];
			if($userrole == 'administrator'){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function is_admin_logged_in(){
		$status = Session::get('aloggedin');
		if($status==1){
			return true;
		}else{
			return false;
		}
	}
	
	function has_access($capabilities){
		$status = session()->get('aloggedin');
		if($status==1){
			$userdata = json_decode(session()->get('auserdata'), true);
			$user_role = $userdata['user_role'];
			
			if($accessdata != ""){ 
				$accessdata = unserialize($accessdata);
				$accesstype = $accessdata['accesstype'];
				if(in_array($accesstype, $capabilities)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
?>
