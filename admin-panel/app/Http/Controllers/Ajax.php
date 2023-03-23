<?php
namespace App\Http\Controllers;
@include(app_path("Providers/Functions/User.php"));
@include(app_path('Providers/Functions/Dataprovider.php'));
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use App\Excelphp;
use App\Excelphp\XLSXWriter;
use Session;
use App;
use Cookie;
use DateTime;
use stdClass;
class Ajax extends Controller{
    public function index(){
        /*--Admin Logins--*/
        if(isset($_REQUEST['adminlogin'])){
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $response = array();
            $userscn = DB::table('users')->where('user_name', $username)->count();
            if($userscn > 0){
                $user = DB::table('users')->where('user_email', $username)->first();
                if(check_password($user->user_password, $password)){
					$user_profile_pic_id = get_user_meta($user->ID, 'user_profile_pic', true);
					$user_dp = url(get_userimage($user_profile_pic_id));
					$fn = get_user_meta($user->ID, "first_name", true);
                    $ln = get_user_meta($user->ID, "last_name", true);
					$fullname = $fn." ".$ln;
					$user_email = $user->user_email;
					$gender = get_user_meta($user->ID, 'user_gender', true);
					$phone_number = get_user_meta($user->ID, 'phone_number', true);
					$user_registered = new DateTime($user->user_registered);
					$date_of_reg = $user_registered->format('d-m-Y');
					$postcode = get_user_meta($user->ID, 'postcode', true);
					if($postcode){
						$postcode = $postcode;
					}else{
						$postcode = 822116;
					}
					$postcode = intval($postcode);
					$country_sortname = get_user_meta($user->ID, 'user_country', true);
					$country_row_data = DB::table('countries')->where('sortname', $country_sortname)->first();
					$country = $country_row_data->name;
					$state = get_user_meta($user->ID, 'user_state', true);
					$hub = get_user_meta($user->ID, 'hub', true);
					if($hub){
						$hub = $hub;
					}else{
						$hub = 16;
					}
					$kk_hub = intval($hub);
					$our_hub = DB::table('our_hub')->where('ID', $kk_hub)->first();
					$kk_hub_address = $our_hub->name;
					$user_address = get_user_meta($user->ID, 'user_address', true);
					$comments = get_user_meta($user->ID, 'comments', true);
                    $useralldata = array(
						"locale" => "en",
						"ID" => $user->ID,
						"picture" => $user_dp,
						"email" => $username,
						"oauth_type" => "email",
						"user_role" => $user->user_role,
						"userpass" => $user->user_password,
						'display_name' => $fn,
						"first_name" => $fn,
						"last_name" => $ln,
						"full_name" => $fullname,
						"gender" => $gender,
						"phone_number" => $phone_number,
						"postcode" => $postcode,
						"country" => $country,
						"state" => $state,
						"hub_id" => $kk_hub,
						"hub_address" => $kk_hub_address,
						"address" => $user_address,
						"hide" => 'd-none',
						"comments" => $comments
					);
                    Session::put(['aloggedin' => 1, 'auserdata' => json_encode($useralldata)]);
                    Session::save();
                    $response['status'] = 1;
                }else{
                    $response['status'] = 2;
                }
            }else{
                $response['status'] = 0;
            }
            echo json_encode($response);
            exit;
        }
		/*-- OTP send for Forgot Password --*/
		if(isset($_REQUEST['set_otp_pwd_reset'])){
			$email = $_REQUEST['email'];
			$response = array();
			$usersc = DB::table('users')->where('user_email', '=', $email)->count();
			$userow = DB::table('users')->where('user_email', '=', $email)->first();
			//echo"<pre>"; print_r($userow); echo"</pre>";
			if($usersc > 0){
				$user = DB::table('users')->where('user_email', $email)->first();
				$securecode = rand(100000, 999999);
				$secformatted = preg_replace('#(\d{3})(\d{3})#', '$1 $2', $securecode);
				DB::table('users')->where('ID', $user->ID)->update(array('last_otp' => $securecode));
				$fname = get_user_meta($user->ID, "first_name", true);
				send_email_verification_code($fname, $user->user_email, $secformatted);
				$allactcodedata = array("user_id" => $user->ID, 'actcode' => $securecode, 'verifcation_status' => 1);
				Session::put(['actcode' => 1, 'actcodedata' => json_encode($allactcodedata)]);
				Session::save();
				$response['status'] = 1;
				$response['msg'] = "<div class='success'><p>OTP has been sent to you, please check your email!</p></div>";
			}else{
				$response['status'] = 0;
				$response['msg'] = "<div class='error'>Your email is not registered with us!</div>";
			}
			echo json_encode($response);
			exit;
		}
		/*-- Email verify --*/
		if(isset($_REQUEST['email_verify'])){
			$emailotp = intval($_REQUEST['emailotp']);
			$response = array();
			$session_actcode = json_decode(Session::get('actcodedata'));
			//echo"<pre>"; print_r($session_actcode); echo"</pre>";
			if($emailotp ==  intval($session_actcode->actcode)){
				$is_phone_verified = 0;
				$allactcodedata = array("user_id" => $session_actcode->user_id, 'verifcation_status' => 0, 'is_email_verified'=> $is_phone_verified);
				Session::put(['email_verified' => 1, 'actcodedata' => json_encode($allactcodedata)]);
				Session::save();
				$response['status'] = 1;
			}else{
				$response['status'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		/*-- Password changed --*/
		if(isset($_REQUEST['change_password'])){
			$new_pwd = strong_password($_REQUEST['confirm_pwd']);
			$response = array();
			$session_actcode = json_decode(Session::get('actcodedata'));
			//echo"<pre>"; print_r($session_actcode); echo"</pre>";
			$user_recordc = DB::table('users')->where([['ID', '!=', $session_actcode->user_id], ['user_role', '=', 'vidyarthi']])->count();
			if($user_recordc > 0){
				if($session_actcode->is_email_verified == 0){
					if($new_pwd){
						$updateddt = new DateTime();
						$updateddt = $updateddt->format('Y-m-d h:i:s');
						DB::table('users')->where('ID', $session_actcode->user_id)->update(array('user_password' => $new_pwd, 'password_updated_on' => $updateddt));
						$response['status'] = 1;
						$response['msg'] = "<div class='success'><p>Password changed successfully!</p></div>";
					}
				}else{
					$response['status'] = 2;
					$response['msg'] = "<div class='error'>An error occurred, please try after some time!</div>";
				}
			}else{
				$response['status'] = 0;
				$response['msg'] = "<div class='error'>Something is wrong please try again!</div>";
			}
			echo json_encode($response);
			exit;
		}
		/*-- Get states List--*/
		if(isset($_REQUEST['getstates'])){
			$country_id = $_REQUEST['country_id'];
			$response = array();
			$optionhtml="";
			$states_count = DB::table('states')->where('country_id', $country_id)->count();
			if($states_count > 0){
				$states = DB::table('states')->where('country_id', $country_id)->get();
				foreach($states as $state){
					$optionhtml .= '<option value="'.$state->ID.'">'.$state->name.'</option>';
				}
				$response['status'] = 1;
				$response['optionhtml'] = $optionhtml;
			}else{
				$response['status'] = 0;
				$response['optionhtml'] = "";
			}
			echo json_encode($response);
			exit;
        }
		/*-- Get districts List--*/
		if(isset($_REQUEST['getdistricts'])){
			$state_id = $_REQUEST['state_id'];
			$response = array();
			$optionhtml="";
			$districts_count = DB::table('districts')->where('state_id', $state_id)->count();
			if($districts_count > 0){
				$districts = DB::table('districts')->where('state_id', $state_id)->get();
				foreach($districts as $district){
					$optionhtml .= '<option value="'.$district->ID.'">'.$district->name.'</option>';
				}
				$response['status'] = 1;
				$response['optionhtml'] = $optionhtml;
			}else{
				$response['status'] = 0;
				$response['optionhtml'] = "";
			}
			echo json_encode($response);
			exit;
        }
        /*-- Add new user --*/
        if(isset($_REQUEST['addnewuser'])){
            $user_regid = $_REQUEST['regid'];
            $user_name = $_REQUEST['username'];
            $dnamearr = explode(" ", $user_name);
            $first_name = ucfirst($dnamearr[0]);
            if(isset($dnamearr[2])){
                $reversearr = array_reverse($dnamearr);
                array_pop($reversearr);
                $reversearr = array_reverse($reversearr);
                $last_name = implode(" ", $reversearr);
            }else{
                if(isset($dnamearr[1])){
                    $last_name = ucfirst($dnamearr[1]);
                }else{
                    $last_name = "";
                }
            }
			$user_gender = ucfirst($_REQUEST['gender_select']);
            $hub = intval($_REQUEST['hub']);
            $user_email = $_REQUEST['useremail'];
            $phone_number = $_REQUEST['usermob'];
            $user_password = strong_password($_REQUEST['userpwd1']);
			$postcode = intval($_REQUEST['postcode']);
			$user_country = $_REQUEST['country_select'];
            $user_state = $_REQUEST['state_select'];
            $user_address = $_REQUEST['permanentaddress'];
			$comments = $_REQUEST['comments'];
            date_default_timezone_set('Asia/Kolkata');
            $user_registered  = new DateTime();
            $user_registered = $user_registered->format('Y-m-d h:i:s');
			$response = array();
            $user_recordc = DB::table('users')->where([['user_email', $user_email], ['user_role', '=', 'vidyarthi']])->count();
			if($user_recordc == 0){
               $newuserid = DB::table('users')->insertGetId(['user_name' => $user_email, 'user_email' => $user_email, 'user_password' => $user_password, 'user_oathtype' => 'email', 'user_role' => 'vidyarthi', 'user_status' => 1, 'user_registered' => $user_registered]);
			   $filedata = $_FILES;
				if(isset($filedata['user_dp']['name'])){
					$user_dp = $_FILES['user_dp'];
					$imagename = $filedata['user_dp']['name'];
					$imagedata = $filedata['user_dp']['tmp_name'];
					$filedata = $user_dp['tmp_name'];
					$fn = $imagename;
					$ext = $_REQUEST['user_dp_ext'];
					$abspath = "uploads";
					$relpath = "uploads";
					$cyear = date('Y', time());
					$cmonth = date('m', time());
					$fullyearp = $abspath."/".$cyear;
					$fullmonthp = $abspath."/".$cyear."/".$cmonth;
					$filetoupload = time().strtolower(str_replace(" ", "-", $fn));
					$fullfileabspath = $fullmonthp."/".$filetoupload;
					$fullfileurl = $relpath."/".$cyear."/".$cmonth."/".$filetoupload;
					if(file_exists($fullyearp)){
						if(file_exists($fullmonthp)){
							move_uploaded_file($filedata, $fullfileabspath);
						}else{
							mkdir($fullmonthp, 0777);
							move_uploaded_file($filedata, $fullfileabspath);
						}
					}else{
						mkdir($fullyearp, 0777);
						if(file_exists($fullmonthp)){
							move_uploaded_file($filedata, $fullfileabspath);
						}else{
						mkdir($fullmonthp, 0777);
							move_uploaded_file($filedata, $fullfileabspath);
						}
					}
					$manager = new ImageManager();
					$manager->make($fullfileabspath)->fit(300, 300)->save($fullfileabspath);
					$mediaadddate = new DateTime();
					$mediaadddate = $mediaadddate->format("Y-m-d h:i:s");
					$profileimage_id = DB::table('media')->insertGetId(array('file_name' => $filetoupload, 'file_ext' => $ext, 'ftype' => 'profileimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
				}else{
					 $profileimage_id = "";
				}
                $user_meta_datas = array('user_reg_number' => $user_regid, 'first_name' => $first_name, 'last_name' => $last_name, 'user_gender' => $user_gender, 'hub' => $hub, 'phone_number' => $phone_number, 'postcode' => $postcode, 'user_country' => $user_country, 'user_state' => $user_state, 'user_address' => $user_address, 'user_profile_pic' => $profileimage_id, 'comments' => $comments);
				foreach($user_meta_datas as $umetak => $umetav){
					update_user_meta($newuserid, $umetak, $umetav);
				}
               $response['status'] = 1;
            }else{
               $response['status'] = 2;
            }
            echo json_encode($response);
			exit;
		}
		/*-- Update user profile --*/
        if(isset($_REQUEST['updateuserprofile'])){
			$user_id = $_REQUEST['uuid'];
			$response = array();
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$user_id = $user_id;
			}else{
				if(($data->sessionlogindata->user_role == 'vidyarthi') || ($data->sessionlogindata->user_role == 'kkadmin')){
					if($user_id == $data->sessionlogindata->ID){
						$user_id = intval($data->sessionlogindata->ID);
					}
				}
			}
            $user_regid = $_REQUEST['regid'];
			$user_name = $_REQUEST['username'];
            $dnamearr = explode(" ", $user_name);
            $first_name = ucfirst($dnamearr[0]);
            if(isset($dnamearr[2])){
                $reversearr = array_reverse($dnamearr);
                array_pop($reversearr);
                $reversearr = array_reverse($reversearr);
                $last_name = implode(" ", $reversearr);
            }else{
                if(isset($dnamearr[1])){
                    $last_name = ucfirst($dnamearr[1]);
                }else{
                    $last_name = "";
                }
            }
			$user_gender = ucfirst($_REQUEST['gender_select']);
            $user_email = $_REQUEST['useremail'];
            $phone_number = $_REQUEST['usermob'];
			$userpwd1 = $_REQUEST['userpwd1'];
			if(!empty($userpwd1)){
				$user_password = strong_password($_REQUEST['userpwd1']);
			}else{
				$user_password = false;
			}
			$postcode = intval($_REQUEST['postcode']);
            $user_country = $_REQUEST['country_select'];
            $user_state = $_REQUEST['state_select'];
            $user_address = $_REQUEST['permanentaddress'];
			$hub = intval($_REQUEST['hub']);
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$hub = $hub;
			}else{
				if($hub == $data->sessionlogindata->hub_id){
					$hub = intval($data->sessionlogindata->hub_id);
				}
			}
			$comments = $_REQUEST['comments'];
            date_default_timezone_set('Asia/Kolkata');
            $user_registered  = new DateTime();
            $user_registered = $user_registered->format('Y-m-d h:i:s');
			$user_recordc = DB::table('users')->where([['user_email', '=', $user_email], ['user_role', '=', 'vidyarthi'], ['ID', '!=', $user_id]])->count();
			$profile_pic_id = get_user_meta($user_id, 'user_profile_pic', true);
			$filedata = $_FILES;
			if(isset($filedata['user_dp']['name'])){
				$user_dp = $_FILES['user_dp'];
				$imagename = $filedata['user_dp']['name'];
				$imagedata = $filedata['user_dp']['tmp_name'];
				$filedata = $user_dp['tmp_name'];
				$fn = $imagename;
				$ext = $_REQUEST['user_dp_ext'];
				$abspath = "uploads";
				$relpath = "uploads";
				$cyear = date('Y', time());
				$cmonth = date('m', time());
				$fullyearp = $abspath."/".$cyear;
				$fullmonthp = $abspath."/".$cyear."/".$cmonth;
				$filetoupload = time().strtolower(str_replace(" ", "-", $fn));
				$fullfileabspath = $fullmonthp."/".$filetoupload;
				$fullfileurl = $relpath."/".$cyear."/".$cmonth."/".$filetoupload;
				if(file_exists($fullyearp)){
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
						mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}else{
					mkdir($fullyearp, 0777);
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
					mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}
				$manager = new ImageManager();
				$manager->make($fullfileabspath)->fit(300, 300)->save($fullfileabspath);
				$mediaadddate = new DateTime();
				$mediaadddate = $mediaadddate->format("Y-m-d h:i:s");
				if(!empty($profile_pic_id)){
					$mediadata = DB::table('media')->where('ID', $profile_pic_id)->first();
					if(file_exists(public_path($mediadata->abs_path))){
						unlink($mediadata->abs_path);
					}
					DB::table('media')->where('ID', $profile_pic_id)->update(array('file_ext' => $ext, 'ftype' => 'profileimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
				}else{
					$profileimage_id = DB::table('media')->insertGetId(array('file_name' => $filetoupload, 'file_ext' => $ext, 'ftype' => 'profileimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
					update_user_meta($user_id, 'user_profile_pic', $profileimage_id);
				}
				$response['dpurl'] = url($fullfileabspath);
			}else{
				$profileimage_id = "";
				$response['dpurl'] = "";
			}
			if($user_recordc == 0){
				DB::table('users')->where('ID', $user_id)->update(array('user_name' => $user_email, 'user_email' => $user_email));
				if($user_password){
					DB::table('users')->where('ID', $user_id)->update(array('user_password' => $user_password));
				}
				$response['status'] = 1;
			}else{
               $response['status'] = 2;
			}
			$user_meta_datas = array('user_reg_number' => $user_regid, 'first_name' => $first_name, 'last_name' => $last_name, 'user_gender' => $user_gender, 'hub' => $hub,'phone_number' => $phone_number, 'postcode' => $postcode, 'user_country' => $user_country, 'user_state' => $user_state, 'user_address' => $user_address, 'comments' => $comments);
			foreach($user_meta_datas as $umetak => $umetav){
				update_user_meta($user_id, $umetak, $umetav);
			}
            echo json_encode($response);
			exit;
		}
		/* Export Users data*/
		if(isset($_REQUEST['exportusers'])){
			$response = array();
			$filename1 = "Export-users-".date("d-m-Y", time()).".xlsx";
            $filepath = public_path("uploads/vidyarthisexcels")."/".$filename1;
            $fileurl = url("uploads/vidyarthisexcels")."/".$filename1;
			$userexptype = intval($_REQUEST['userexptype']);
			$userids = $_REQUEST['alluserid'];
			$writer = new XLSXWriter();
			$header = array('Sl no' => 'string', 'Name' => 'string', 'Email' => 'string', 'Contact' => 'string', 'Hawan Amount' => 'string');
			$writer->writeSheetHeader('Sheet1', $header);
			$slno = 1;
			$usersc = DB::table('users')->where('user_role', 'vidyarthi')->count();
			if($usersc > 0){
				if($userexptype == 1){
					$usersdata = DB::table('users')->where('user_role', 'vidyarthi')->whereIn('ID', $userids)->paginate(15);
					foreach($usersdata as $userk => $user){
						$phone_numbers = get_user_meta($user->ID, "phone_number", true);
						if($phone_numbers != ""){
							$phnumber = $phone_numbers;
						}else{
							$phnumber = "### ### ####";
						}
						$rowdata = array(
							$slno,
							get_user_meta($user->ID, "first_name", true)." ".get_user_meta($user->ID, "last_name", true),
							$user->user_email,
							$phnumber,
							get_havancount($user->ID)
						);
						$writer->writeSheetRow('Sheet1', $rowdata);
						$slno++;
					}
				}else{
					$allusers = DB::table('users')->where('user_role', 'vidyarthi')->paginate(15);
					foreach($allusers as $userk => $user){
						$phone_numbers = get_user_meta($user->ID, "phone_number", true);
						if($phone_numbers != ""){
							$phnumber = $phone_numbers;
						}else{
							$phnumber = "### ### ####";
						}
						$rowdata = array(
							$slno,
							get_user_meta($user->ID, "first_name", true)." ".get_user_meta($user->ID, "last_name", true),
							$user->user_email,
							$phnumber,
							get_havancount($user->ID)
						);
						$writer->writeSheetRow('Sheet1', $rowdata);
						$slno++;
					}
				}
			}
			$writer->writeToFile($filepath);
			$response['status'] = 1;
			$response['excellink'] = $fileurl;
			echo json_encode($response);
			exit;
		}
		/*-- Delete user data--*/
		if(isset($_REQUEST['deleteusers'])){
			$userids = json_decode($_REQUEST['userids']);
			$response = array();
			$userscount = DB::table('users')->where('user_role', 'vidyarthi')->whereIn('ID', $userids)->count();
			if($userscount > 0){
				//echo "<pre>"; print_r($userids); echo "</pre>";
				DB::table('users')->whereIn('ID', $userids)->delete();
				$userdpids = DB::table('user_meta')->where('meta_key', 'user_profile_pic')->whereIn('user_id', $userids)->pluck('meta_value');
				DB::table('user_meta')->whereIn('user_id', $userids)->delete();
				$medias = DB::table('media')->whereIn('ID', $userdpids)->get();
				foreach($medias as $media){
					if(file_exists(public_path($media->abs_path))){
						unlink(public_path($media->abs_path));
					}
				}
				DB::table('media')->whereIn('ID', $userdpids)->delete();
				$hawanids = DB::table('hawans')->whereIn('user_id', $userids)->pluck('ID');
				DB::table('hawans')->whereIn('user_id', $userids)->delete();
				DB::table('hawan_meta')->whereIn('hawan_id', $hawanids)->delete();
				$response['status'] = 1;
			}else{
				$response['status'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		/*-- Get User data on change function--*/
		if(isset($_REQUEST['vidyarthidata'])){
			$user_id = $_REQUEST['uid'];
			$response = array();
			$user_recordc = DB::table('users')->where([['ID', '=',$user_id], ['user_role', '=', 'vidyarthi']])->count();
			if($user_recordc > 0){
				$user = DB::table('users')->where([['ID', '=', $user_id], ['user_role', '=', 'vidyarthi']])->first();
				$user_profile_pic_id = get_user_meta($user_id, 'user_profile_pic', true);
				$user_dp = url(get_userimage($user_profile_pic_id));
				$first_name = get_user_meta($user_id, 'first_name', true);
				$last_name = get_user_meta($user_id, 'last_name', true);
				$fullname = $first_name." ".$last_name;
				$user_email = $user->user_email;
				$phone_number = get_user_meta($user_id, 'phone_number', true);
				$user_registered = new DateTime($user->user_registered);
				$date_of_reg = $user_registered->format('d-m-Y');
				$postcode = get_user_meta($user_id, 'postcode', true);
				if($postcode){
					$postcode = $postcode;
				}else{
					$postcode = 822116;
				}
				$vi_postcode = intval($postcode);
				$country_sortname = get_user_meta($user_id, 'user_country', true);
				$country_row_data = DB::table('countries')->where('sortname', $country_sortname)->first();
				$country = $country_row_data->name;
				$state = get_user_meta($user_id, 'user_state', true);
				$hub = get_user_meta($user_id, 'hub', true);
				if($hub){
					$hub = $hub;
				}else{
					$hub = 16;
				}
				$vi_hub = intval($hub);
				$our_hub = DB::table('our_hub')->where('ID', $vi_hub)->first();
				$vi_hub = $our_hub->name;
				$user_address = get_user_meta($user_id, 'user_address', true);
				$user_comments = get_user_meta($user_id, 'comments', true);
				$response['status'] = 1;
				$response['user_dp'] = $user_dp;
				$response['username'] = $fullname;
				$response['useremail'] = $user_email;
				$response['usermob'] = $phone_number;
				$response['regdtp'] = $date_of_reg;
				$response['vi_postcode'] = $vi_postcode;
				$response['user_country_selected'] = $country;
				$response['user_state_selected'] = $state;
				$response['vi_hub'] = $vi_hub;
				$response['permanentaddress'] = $user_address;
				$response['comments'] = $user_comments;
			}
			echo json_encode($response);
			exit;
        }
        /*-- Add new Hawan --*/
        if(isset($_REQUEST['addnewhawan'])){
			$response = array();
			$user_id = $_REQUEST['uid'];
			$rashid_code = $_REQUEST['rashid_code'];
			$rashid_number = $_REQUEST['rashidnumber'];
			$yazman_name = $_REQUEST['yazmanname'];
			$dnamearr = explode(" ", $yazman_name);
            $first_name = ucfirst($dnamearr[0]);
            if(isset($dnamearr[2])){
                $reversearr = array_reverse($dnamearr);
                array_pop($reversearr);
                $reversearr = array_reverse($reversearr);
                $last_name = implode(" ", $reversearr);
            }else{     
                if(isset($dnamearr[1])){
                    $last_name = ucfirst($dnamearr[1]);
                }else{
                    $last_name = "";
                }
            }
			$fatherhusband = $_REQUEST['fatherhusband'];
			$dateofhawan = $_REQUEST['dateofhawan'];
			$newhawandatetime = new DateTime($dateofhawan);
			$date_of_hawan = $newhawandatetime->format('Y-m-d');
			$postcode = $_REQUEST['postcode'];
			$country_code = $_REQUEST['country_select'];
			$hub_id = $_REQUEST['hub_select'];
			$state = $_REQUEST['state_select'];
			$distric = $_REQUEST['distric'];
			$village = $_REQUEST['yazmanvillage'];
			$postoffice = $_REQUEST['yazmanpostoffice'];
			$ward_house_number = $_REQUEST['yazman_ward_house_num'];
			$yazman_whatsapp_num = $_REQUEST['yazman_whatsapp_num'];
			$yazman_other_num = $_REQUEST['yazman_other_num'];
			$swamiji_seva_amt = floatval($_REQUEST['swamiji_seva_amt']);
			$swamiji_general_seva_amt = floatval($_REQUEST['swamiji_general_seva_amt']);
			$swamiji_other_seva_amt = floatval($_REQUEST['swamiji_other_seva_amt']);
			$swamiji_seva_total_amt = number_format(floatval($swamiji_seva_amt + $swamiji_general_seva_amt + $swamiji_other_seva_amt), 2, '.', '');
			$ashram_amt_paid_status = intval($_REQUEST['ashram_amt_paid_status']);
			$ashram_amt_payment_mode = $_REQUEST['ashram_amt_payment_mode'];
			$vidyarthi_seva_amt = floatval($_REQUEST['vidyarthi_seva_amt']);
			$travell_seva_amt = floatval($_REQUEST['travell_seva_amt']);
			$vidyarthi_other_seva_amt = floatval($_REQUEST['vidyarthi_other_seva_amt']);
			$vidyarthi_seva_total_amt = number_format(floatval($vidyarthi_seva_amt + $travell_seva_amt + $vidyarthi_other_seva_amt), 2, '.', '');
			// rashid_img Image Upload
			$filedata = $_FILES;
			if(isset($filedata['rashid_img']['name'])){
				$rashid_img = $_FILES['rashid_img'];
				$imagename = $filedata['rashid_img']['name'];
				$imagedata = $filedata['rashid_img']['tmp_name'];
				$filedata = $rashid_img['tmp_name'];
				$fn = $imagename;
				$ext = $_REQUEST['rashid_img_ext'];
				$abspath = "uploads";
				$relpath = "uploads";
				$cyear = date('Y', time());
				$cmonth = date('m', time());
				$fullyearp = $abspath."/".$cyear;
				$fullmonthp = $abspath."/".$cyear."/".$cmonth;
				$filetoupload = time().strtolower(str_replace(" ", "-", $fn));
				$fullfileabspath = $fullmonthp."/".$filetoupload;
				$fullfileurl = $relpath."/".$cyear."/".$cmonth."/".$filetoupload;
				if(file_exists($fullyearp)){
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
						mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}else{
					mkdir($fullyearp, 0777);
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
					mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}
				$manager = new ImageManager();
				//$manager->make($fullfileabspath)->fit(300, 300)->save($fullfileabspath);
				$manager->make($fullfileabspath)->save($fullfileabspath);
				$mediaadddate = new DateTime();
				$mediaadddate = $mediaadddate->format("Y-m-d h:i:s");
				$rashidimage_id = DB::table('media')->insertGetId(array('file_name' => $filetoupload, 'file_ext' => $ext, 'ftype' => 'rashidimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
			}else{
				$rashidimage_id = "";
			}
			$purpose_of_hawan = intval($_REQUEST['purposeofhawan']);
			$satsang = $_REQUEST['satsang'];
			$newserved = $_REQUEST['newserved'];
			$serwedqty = $_REQUEST['serwedqty'];
			$newpatrika = $_REQUEST['newpatrika'];
			$newpatrikaqty = $_REQUEST['newpatrikaqty'];
			$newakshaypatra = $_REQUEST['newakshaypatra'];
			$newakshaypatraqty = $_REQUEST['newakshaypatraqty'];
			$newupdesh = $_REQUEST['newupdesh'];
            $peopleattendedhawan = $_REQUEST['peopleattendedhawan'];
            $registereddtp  = new DateTime();
            $created_at = $registereddtp->format('Y-m-d h:i:s');
			$hawan_comments = $_REQUEST['hawancomments'];
			$hawan_recordc = DB::table('hawans')->where([['rashid_code', '=', $rashid_code], ['rashid_number', '=', $rashid_number]])->count();
			if($hawan_recordc == 0){
				$gross_total_amt = number_format(floatval($vidyarthi_seva_total_amt + $swamiji_seva_total_amt), 2, '.', '');
				$hawan_id = DB::table('hawans')->insertGetId(array('user_id' => $user_id, 'rashid_code' => $rashid_code, 'rashid_number' => $rashid_number, 'yazman_name' => $yazman_name, 'date_of_hawan' => $date_of_hawan, 'country_code' => $country_code, 'state' => $state, 'hub_id' => $hub_id, 'distric' => $distric, 'village' => $village, 'postoffice' => $postoffice, 'ward_house_number' => $ward_house_number, 'gross_total_amt' => $gross_total_amt, 'status' => 1, 'created_at' => $created_at));
				$hawan_meta_datas = array('first_name' => $first_name, 'last_name' => $last_name, 'father_husband' => $fatherhusband, 'postcode' => $postcode, 'yazman_whatsapp_num' => $yazman_whatsapp_num, 'yazman_other_num' => $yazman_other_num, 'swamiji_seva_amt' => $swamiji_seva_amt,	'swamiji_general_seva_amt' => $swamiji_general_seva_amt, 'swamiji_other_seva_amt' => $swamiji_other_seva_amt,
				'swamiji_seva_total_amt' => $swamiji_seva_total_amt, 'ashram_amt_paid_status' => $ashram_amt_paid_status, 'ashram_amt_payment_mode' => $ashram_amt_payment_mode, 'vidyarthi_seva_amt' => $vidyarthi_seva_amt, 'travell_seva_amt' => $travell_seva_amt, 'vidyarthi_other_seva_amt' => $vidyarthi_other_seva_amt, 'vidyarthi_seva_total_amt' => $vidyarthi_seva_total_amt, 'rashidimage_id' => $rashidimage_id, 'purpose_of_hawan' => $purpose_of_hawan,	'satsang' => $satsang, 'new_served' => $newserved, 	'serwedqty' => $serwedqty, 'new_patrika' => $newpatrika, 'newpatrikaqty' => $newpatrikaqty, 'new_akshay_patra' => $newakshaypatra, 'newakshaypatraqty' => $newakshaypatraqty, 'newupdesh' => $newupdesh, 'peopleattendedhawan' => $peopleattendedhawan, 'hawan_comments' => $hawan_comments);
				foreach($hawan_meta_datas as $hmetak => $hmetav){
					update_hawan_meta($hawan_id, $hmetak, $hmetav);
				}
				$response['status'] = 1;
			}else{
               $response['status'] = 2;
            }
			echo json_encode($response);
			exit;
        }
		/*-- Update Hawan --*/
		if(isset($_REQUEST['updatehawan'])){
			$response = array();
			$user_id = $_REQUEST['uid'];
			$hawan_id = $_REQUEST['hawan_id'];
			$rashid_code = $_REQUEST['rashid_code'];
			$rashid_number = $_REQUEST['rashidnumber'];
			$yazman_name = $_REQUEST['yazmanname'];
			$dnamearr = explode(" ", $yazman_name);
            $first_name = ucfirst($dnamearr[0]);
            if(isset($dnamearr[2])){
                $reversearr = array_reverse($dnamearr);
                array_pop($reversearr);
                $reversearr = array_reverse($reversearr);
                $last_name = implode(" ", $reversearr);
            }else{
                if(isset($dnamearr[1])){
                    $last_name = ucfirst($dnamearr[1]);
                }else{
                    $last_name = "";
                }
            }
			$fatherhusband = $_REQUEST['fatherhusband'];
			$dateofhawan = $_REQUEST['dateofhawan'];
			$newhawandatetime = new DateTime($dateofhawan);
			$date_of_hawan = $newhawandatetime->format('Y-m-d');
			$postcode = $_REQUEST['postcode'];
			$country_code = $_REQUEST['country_select'];
			$state = $_REQUEST['state_select'];
			$hub_id = get_user_meta($user_id, 'hub', true);
			$distric = $_REQUEST['distric'];
			$village = $_REQUEST['yazmanvillage'];
			$postoffice = $_REQUEST['yazmanpostoffice'];
			$ward_house_number = $_REQUEST['yazman_ward_house_num'];
			$yazman_whatsapp_num = $_REQUEST['yazman_whatsapp_num'];
			$yazman_other_num = $_REQUEST['yazman_other_num'];
			$swamiji_seva_amt = floatval($_REQUEST['swamiji_seva_amt']);
			$swamiji_general_seva_amt = floatval($_REQUEST['swamiji_general_seva_amt']);
			$swamiji_other_seva_amt = floatval($_REQUEST['swamiji_other_seva_amt']);
			$swamiji_seva_total_amt = number_format(floatval($swamiji_seva_amt + $swamiji_general_seva_amt + $swamiji_other_seva_amt), 2, '.', '');
			$ashram_amt_paid_status = intval($_REQUEST['ashram_amt_paid_status']);
			$ashram_amt_payment_mode = intval($_REQUEST['ashram_amt_payment_mode']);
			$vidyarthi_seva_amt = $_REQUEST['vidyarthi_seva_amt'];
			$travell_seva_amt = $_REQUEST['travell_seva_amt'];
			$vidyarthi_other_seva_amt = $_REQUEST['vidyarthi_other_seva_amt'];
			$vidyarthi_seva_total_amt = number_format(floatval($vidyarthi_seva_amt + $travell_seva_amt + $vidyarthi_other_seva_amt), 2, '.', '');
			//Rashid_img Image Upload Start
			$rashid_image_id = get_hawan_meta($hawan_id, 'rashidimage_id', true);
			$filedata = $_FILES;
			if(isset($filedata['rashid_img']['name'])){
				$rashid_img = $_FILES['rashid_img'];
				$imagename = $filedata['rashid_img']['name'];
				$imagedata = $filedata['rashid_img']['tmp_name'];
				$filedata = $rashid_img['tmp_name'];
				$fn = $imagename;
				$ext = $_REQUEST['rashid_img_ext'];
				$abspath = "uploads";
				$relpath = "uploads";
				$cyear = date('Y', time());
				$cmonth = date('m', time());
				$fullyearp = $abspath."/".$cyear;
				$fullmonthp = $abspath."/".$cyear."/".$cmonth;
				$filetoupload = time().strtolower(str_replace(" ", "-", $fn));
				$fullfileabspath = $fullmonthp."/".$filetoupload;
				$fullfileurl = $relpath."/".$cyear."/".$cmonth."/".$filetoupload;
				if(file_exists($fullyearp)){
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
						mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}else{
					mkdir($fullyearp, 0777);
					if(file_exists($fullmonthp)){
						move_uploaded_file($filedata, $fullfileabspath);
					}else{
					mkdir($fullmonthp, 0777);
						move_uploaded_file($filedata, $fullfileabspath);
					}
				}
				$manager = new ImageManager();
				//$manager->make($fullfileabspath)->fit(300, 300)->save($fullfileabspath);
				$manager->make($fullfileabspath)->save($fullfileabspath);
				$mediaadddate = new DateTime();
				$mediaadddate = $mediaadddate->format("Y-m-d h:i:s");
				if(!empty($rashid_image_id)){
					$mediadata = DB::table('media')->where('ID', $rashid_image_id)->first();
					if(file_exists(public_path($mediadata->abs_path))){
						unlink($mediadata->abs_path);
					}
					DB::table('media')->where('ID', $rashid_image_id)->update(array('file_ext' => $ext, 'ftype' => 'rashidimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
				}else{
					$rashidimage_id = DB::table('media')->insertGetId(array('file_name' => $filetoupload, 'file_ext' => $ext, 'ftype' => 'rashidimage', 'abs_path' => $fullfileabspath, 'rel_path' => $fullfileurl, 'added_on' => $mediaadddate, 'updated_on' => $mediaadddate));
					update_hawan_meta($hawan_id, 'rashidimage_id', $rashidimage_id);
				}
				$response['rashid_img'] = url($fullfileabspath);
			}else{
				$rashidimage_id = "";
				$response['rashid_img'] = "";
			}
			//Rashid_img Image Upload End
			$purpose_of_hawan = intval($_REQUEST['purposeofhawan']);
			$satsang = $_REQUEST['satsang'];
			$newserved = $_REQUEST['newserved'];
			$serwedqty = $_REQUEST['serwedqty'];
			$newpatrika = $_REQUEST['newpatrika'];
			$newpatrikaqty = $_REQUEST['newpatrikaqty'];
			$newakshaypatra = $_REQUEST['newakshaypatra'];
			$newakshaypatraqty = $_REQUEST['newakshaypatraqty'];
			$newupdesh = $_REQUEST['newupdesh'];
			$peopleattendedhawan = $_REQUEST['peopleattendedhawan'];
			$hawan_comments = $_REQUEST['hawancomments'];
            $registereddtp  = new DateTime();
            $created_at = $registereddtp->format('Y-m-d h:i:s');
			$hawan_recordc = DB::table('hawans')->where('ID', $hawan_id)->count();
			if($hawan_recordc > 0){  
				$gross_total_amt = number_format(floatval($vidyarthi_seva_total_amt + $swamiji_seva_total_amt), 2, '.', '');
				DB::table('hawans')->where('ID', $hawan_id)->update(array(
				'user_id' => $user_id, 'rashid_code' => $rashid_code, 'rashid_number' => $rashid_number, 'yazman_name' => $yazman_name, 'date_of_hawan' => $date_of_hawan, 'country_code' => $country_code, 'state' => $state, 'hub_id' => $hub_id, 'distric' => $distric, 'village' => $village, 'postoffice' => $postoffice, 'ward_house_number' => $ward_house_number, 'gross_total_amt' => $gross_total_amt));
				$update_hawan_meta_datas = array('first_name' => $first_name, 'last_name' => $last_name, 'father_husband' => $fatherhusband, 'postcode' => $postcode, 'yazman_whatsapp_num' => $yazman_whatsapp_num, 'yazman_other_num' => $yazman_other_num, 'swamiji_seva_amt' => $swamiji_seva_amt,	'swamiji_general_seva_amt' => $swamiji_general_seva_amt, 'swamiji_other_seva_amt' => $swamiji_other_seva_amt,
				'swamiji_seva_total_amt' => $swamiji_seva_total_amt, 'ashram_amt_paid_status' => $ashram_amt_paid_status, 'ashram_amt_payment_mode' => $ashram_amt_payment_mode, 'vidyarthi_seva_amt' => $vidyarthi_seva_amt, 'travell_seva_amt' => $travell_seva_amt, 'vidyarthi_other_seva_amt' => $vidyarthi_other_seva_amt, 'vidyarthi_seva_total_amt' => $vidyarthi_seva_total_amt, 'purpose_of_hawan' => $purpose_of_hawan,	'satsang' => $satsang, 'new_served' => $newserved, 	'serwedqty' => $serwedqty, 'new_patrika' => $newpatrika, 'newpatrikaqty' => $newpatrikaqty, 'new_akshay_patra' => $newakshaypatra, 'newakshaypatraqty' => $newakshaypatraqty, 'newupdesh' => $newupdesh, 'peopleattendedhawan' => $peopleattendedhawan, 'hawan_comments' => $hawan_comments);
				foreach($update_hawan_meta_datas as $hmetak => $hmetav){
					update_hawan_meta($hawan_id, $hmetak, $hmetav);
				}
				$response['status'] = 1;
			}else{
               $response['status'] = 2;
            }
			echo json_encode($response);
			exit;
		}
		/*--Delete Hawan data--*/
		if(isset($_REQUEST['deletehawans'])){
			$hawanids = json_decode($_REQUEST['hawanids']);
			$response = array();
			$hawanscount = DB::table('hawans')->whereIn('ID', $hawanids)->count();
			if($hawanscount > 0){
				DB::table('hawans')->whereIn('ID', $hawanids)->delete();
				DB::table('hawan_meta')->whereIn('hawan_id', $hawanids)->delete();
				$response['status'] = 1;
			}else{
				$response['status'] = 0;
			}
			echo json_encode($response);
			exit;
		} 
		/*--Export Hawan data--*/
		if(isset($_REQUEST['exporthawans'])){
			$response = array();
			$filename1 = "hawans-".date("d-m-Y", time()).".xlsx";
            $filepath = public_path("uploads/hawanexcels")."/".$filename1;
            $fileurl = url("uploads/hawanexcels")."/".$filename1;
			$havanexptype = intval($_REQUEST['havanexptype']);
			$searchparams = $_REQUEST['searchparams'];
			$searchparams_extracted = array();
			foreach($searchparams as $searchparam){
				$searchparams_extracted[$searchparam['name']] = $searchparam['value'];
			}
			$searchparams = (object) $searchparams_extracted;
			if(!empty($searchparams->yajnakartaname)){
				$yajnakartaname = true;
				$search_yajnakartaname = $searchparams->yajnakartaname;
				$msearch_yajnakartaname = $search_yajnakartaname;
			}else{
				$yajnakartaname = false;
				$msearch_yajnakartaname = "";
			}
			if(!empty($searchparams->username)){
				$username = true;
				$susername = $searchparams->username;
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
			if(!empty($searchparams->contact)){
				$contact = true;
				$scontact = trim($searchparams->contact);
				$mscontact = $scontact;
			}else{
				$contact = false;
				$scontact = "";
			}
			if(!empty($searchparams->fromdate)){
				$fromdate = $searchparams->fromdate;
				$sfromdate = new DateTime($fromdate);
				$sfromdate = $sfromdate->format('Y-m-d');
			}else{
				$fromdate = "";
				$sfromdate = "";
			}
			if(!empty($searchparams->toodate)){
				$toodate = $searchparams->toodate;
				$stoodate = new DateTime($toodate);
				$stoodate = $stoodate->format('Y-m-d');
			}else{
				$toodate = "";
				$stoodate = "";
			}
			if(!empty($searchparams->country)){
				$scountry = true;
				$scountry = $searchparams->country;
			}else{
				$scountry = true;
				$scountry = 101;
			}
			if(!empty($searchparams->state)){
				$sstate = true;
				$sstate = $searchparams->state;
			}else{
				$sstate = false;
				$sstate = "";
			}
			if($searchparams->country !=""){
				$country_row = DB::table('countries')->where('ID', $scountry)->first();
				$country_by_states = DB::table('states')->where('country_id', $country_row->ID)->get();
			}
			if(!empty($searchparams->district)){
				$district = true;
				$sdistrict = $searchparams->district;
			}else{
				$district = false;
				$sdistrict = "";
			}
            if(!empty($_REQUEST['rashidcode'])){
                $rashidcode = true;
                $srashidcode = $_REQUEST['rashidcode'];
            }else{
                $rashidcode = false;
                $srashidcode = "";
            }
            if(!empty($_REQUEST['rashidnofrom'])){
                $rashidnofrom = true;
                $srashidnofrom = $_REQUEST['rashidnofrom'];
            }else{
                $rashidnofrom = false;
                $srashidnofrom = "";
            }
            if(!empty($_REQUEST['rashidnoto'])){
                $rashidnoto = true;
                $srashidnoto = $_REQUEST['rashidnoto'];
            }else{
                $rashidnoto = false;
                $srashidnoto = "";
            }
			$writer = new XLSXWriter();
			/*--  Export Data Start --*/
			if($searchparams->searchby == "all"){
				$header = array('SL' => 'string', 'Rashid Code' => 'string', 'Rashid Number' => 'string', 'Vidyarthi Name' => 'string', 'Yajmaan Name' => 'string', 'Country' => 'string', 'Hub' => 'string', 'State' => 'string', 'District' => 'string', 'Village/City' => 'string', 'Post Office' => 'string', 'House' => 'string', 'Yajman Whatsapp Number' => 'string', 'Yajman Other Number' => 'string', 'Swamiji Seva' => 'string', 'General Seva' => 'string', 'Other Seva' => 'string', 'Vidyarthi Seva Amount' => 'string', 'Travel Seva Amount' => 'string', 'Vidyarthi Other Seva Amount' => 'string', 'Vidyarthi Total Seva Amount' => 'string', 'Purpose' => 'string', 'Satsang' => 'string', 'Serwed Qty' => 'string', 'Patrika Qty' => 'string', 'Akshay Patra Qty' => 'string', 'New Updesh' => 'string', 'People Attended Hawans' => 'string', 'Comments' => 'string', 'Amount' => 'string', 'Date' => 'string');
				$writer->writeSheetHeader('Sheet1', $header);
				if($havanexptype == 1){
					$exportsome = true;
					$hawanids = $_REQUEST['hawanids'];
				}else{
					$exportsome = false;
					$hawanids = array();
				}
				$hawans = DB::table('hawans')
				->select('hawans.ID', 'hawans.user_id', 'hawans.rashid_code', 'hawans.rashid_number', 'hawans.yazman_name', 'hawans.date_of_hawan', 'hawans.country_code', 'hawans.state', 'hawans.hub_id', 'hawans.distric', 'hawans.village', 'hawans.postoffice', 'hawans.ward_house_number', 'hawans.gross_total_amt', 'hawans.status', 'hawans.created_at')
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
				->groupBy('hawans.ID')
				->get();
				$slno = 1;
				foreach($hawans as $hawan){
                    $hawan_meta_datas = DB::table('hawan_meta')->where('hawan_id', $hawan->ID)->get();
                    $hawanmetas = array();
                    foreach($hawan_meta_datas as $hawan_meta_data){
                        $hawanmetas[$hawan_meta_data->meta_key] = $hawan_meta_data->meta_value;
                    }
					$vidyarthiname = get_user_meta($hawan->user_id, 'first_name', true)." ".get_user_meta($hawan->user_id, 'last_name', true);
					$yazman_whatsapp_num = $hawanmetas['yazman_whatsapp_num'];
					$yazman_other_num = $hawanmetas['yazman_other_num'];
					$swamiji_seva_amt = $hawanmetas['swamiji_seva_amt'];
					$swamiji_general_seva_amt = $hawanmetas['swamiji_general_seva_amt'];
					$swamiji_other_seva_amt = $hawanmetas['swamiji_other_seva_amt'];
					$swamiji_seva_total_amt = $hawanmetas['swamiji_seva_total_amt'];
					$ashram_amt_paid_status = $hawanmetas['ashram_amt_paid_status'];
					$ashram_amt_payment_mode = $hawanmetas['ashram_amt_payment_mode'];
					$vidyarthi_seva_amt = $hawanmetas['vidyarthi_seva_amt'];
					$travell_seva_amt = $hawanmetas['travell_seva_amt'];
					$vidyarthi_other_seva_amt = $hawanmetas['vidyarthi_other_seva_amt'];
					$vidyarthi_seva_total_amt = $hawanmetas['vidyarthi_seva_total_amt'];
					$purpose_of_hawan = $hawanmetas['purpose_of_hawan'];
					$satsang = $hawanmetas['satsang'];
					$serwedqty = $hawanmetas['serwedqty'];
					$newpatrikaqty = $hawanmetas['newpatrikaqty'];
					$newakshaypatraqty = $hawanmetas['newakshaypatraqty'];
					$newupdesh = $hawanmetas['newupdesh'];
					$peopleattendedhawan = $hawanmetas['peopleattendedhawan'];
					$hawan_comments = $hawanmetas['hawan_comments'];
                    if($satsang == 'NaN'){ $satsang = ""; }
                    if($serwedqty == 'NaN'){ $serwedqty = ""; }
                    if($newpatrikaqty == 'NaN'){ $newpatrikaqty = ""; }
                    if($newakshaypatraqty == 'NaN'){ $newakshaypatraqty = ""; }
                    if($newupdesh == 'NaN'){ $newupdesh = ""; }
                    if($peopleattendedhawan == 'NaN'){ $peopleattendedhawan = ""; }
					$rowdata = array($slno, $hawan->rashid_code, $hawan->rashid_number, $vidyarthiname, $hawan->yazman_name, $hawan->country_code, get_hubname_by_hubid($hawan->hub_id), get_statename_by_stateid($hawan->state), get_districtname_by_districtid($hawan->distric), $hawan->village, $hawan->postoffice, $hawan->ward_house_number, $yazman_whatsapp_num, $yazman_other_num, $swamiji_seva_amt, $swamiji_general_seva_amt, $swamiji_other_seva_amt, $vidyarthi_seva_amt, $travell_seva_amt, $vidyarthi_other_seva_amt, $vidyarthi_seva_total_amt, $purpose_of_hawan, $satsang, $serwedqty, $newpatrikaqty, $newakshaypatraqty, $newupdesh, $peopleattendedhawan, $hawan_comments, $hawan->gross_total_amt, $hawan->date_of_hawan);
					$writer->writeSheetRow('Sheet1', $rowdata);
					$slno++;
				}
			}
			/*--  Export Data State Wise Start --*/
			if($searchparams->searchby == "statewise"){
				$header = array('Sl no' => 'string', 'State Name' => 'string', 'Number of Vidyarthis' => 'string', 'Number of Hawans' => 'string', 'Hawan Amount' => 'string');
				$writer->writeSheetHeader('Sheet1', $header);
				if($havanexptype == 1){
					$exportsome = true;
					$hawanids = $_REQUEST['hawanids'];
				}else{
					$exportsome = false;
					$hawanids = array();
				}
				$hawans = DB::table('hawans')
				->join('users', 'hawans.user_id', '=', 'users.ID')
				->select('hawans.ID as hawan_id', 'hawans.state', 'users.ID as vidyarthi_id',)
				->where('users.user_role', 'vidyarthi')
				->when($scountry, function($query) use($scountry) {
					return $query->where('hawans.country_code', $scountry);
				})
				->when($exportsome, function($query) use ($hawanids){
					return $query->whereIn('hawans.ID', $hawanids);
				})
				->groupBy('hawans.state')
				->get();
				$slno = 1;
				foreach($hawans as $hawank => $hawan){
					$rowdata = array($slno, ucfirst($hawan->state), vidhyarthi_count_statewise($hawan->state), havan_count_statewise($hawan->state), havan_sum_statewise($hawan->state));
					$writer->writeSheetRow('Sheet1', $rowdata);
					$slno++;
				}
			}
			/*--  Export Data State Wise End --*/
			if($searchparams->searchby == "districtwise"){
				$header = array('Sl no' => 'string', 'District Name' => 'string', 'Number of Vidyarthis' => 'string', 'Number of Hawans' => 'string', 'Hawan Amount' => 'string');
				$writer->writeSheetHeader('Sheet1', $header);
				if($havanexptype == 1){
					$exportsome = true;
					$hawanids = $_REQUEST['hawanids'];
				}else{
					$exportsome = false;
					$hawanids = array();
				}
				$hawans = DB::table('hawans')
				->join('users', 'hawans.user_id', '=', 'users.ID')
				->select('hawans.ID as hawan_id', 'hawans.rashid_number', 'hawans.state', 'hawans.distric', 'hawans.date_of_hawan', 'users.ID as vidyarthi_id', 'users.user_email')
				->where('users.user_role', 'vidyarthi')
                ->when($yajnakartaname, function($query) use ($msearch_yajnakartaname){
                    return $query->where([['hawans.yazman_name', 'LIKE', '%'.$msearch_yajnakartaname.'%']]);
                })
				->when($username, function($query) use ($msusername){
					return $query->join('user_meta', 'hawans.user_id', '=', 'user_meta.user_id')->where([['user_meta.meta_value', 'LIKE', '%'.$msusername.'%']]);
				})
				->when($scountry, function($query) use ($scountry) {
					return $query->where([['hawans.country_code', '=', $scountry]]);
				})
				->when($sstate, function($query, $sstate) {
					return $query->where([['hawans.state', '=', $sstate]]);
				})
				->when($exportsome, function($query) use ($hawanids){
					return $query->whereIn('hawans.ID', $hawanids);
				})
				->groupBy('hawans.distric')
				->get();
				$slno = 1;
				foreach($hawans as $hawank => $hawan){
					$rowdata = array($slno, ucfirst($hawan->distric), vidhyarthi_count_districtwise($hawan->distric), havan_count_districtwise($hawan->distric), havan_sum_districtwise($hawan->distric));
					$writer->writeSheetRow('Sheet1', $rowdata);
					$slno++;
				}
			}
			if($searchparams->searchby == "vidyarthiwise"){
				$header = array('Sl no' => 'string', 'Vidyarthi' => 'string', 'State' => 'string', 'District' => 'string', 'Contact' => 'string', 'Hawan Number' => 'string', 'Hawan Amount' => 'string');
				$writer->writeSheetHeader('Sheet1', $header);
				$hawans = DB::table('hawans')
				->join('users', 'hawans.user_id', '=', 'users.ID')
				->select('hawans.ID as hawan_id', 'hawans.yazman_name', 'hawans.rashid_number', 'hawans.state', 'hawans.distric', 'hawans.date_of_hawan', 'users.ID as vidyarthi_id', 'users.user_email')
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
				->when($scountry, function($query, $scountry) {
					return $query->where([['hawans.country_code', '=', $scountry]]);
				})
				->when($sstate, function($query, $sstate) {
					return $query->where([['hawans.state', '=', $sstate]]);
				})
				->when($sdistrict, function($query, $sdistrict) {
					return $query->where([['hawans.distric', '=', $sdistrict]]);
				})
				->when($srashidno, function($query, $srashidno) {
					return $query->where([['hawans.rashid_number', '=', $srashidno]]);
				})
				->groupBy('hawans.user_id')
				->get();
				$slno = 1;
				foreach($hawans as $hawank => $hawan){
					$first_name = get_user_meta($hawan->vidyarthi_id, 'first_name', true);
					$last_name = get_user_meta($hawan->vidyarthi_id, 'last_name', true);
					$contact = get_hawan_meta($hawan->hawan_id, 'yazman_whatsapp_num', true);
					$vidyarthi = $first_name." ".$last_name;
					$rowdata = array($slno, $vidyarthi, $hawan->state, $hawan->distric, $contact, get_havancount($hawan->vidyarthi_id), get_hawanamt_byuser($hawan->vidyarthi_id));
					$writer->writeSheetRow('Sheet1', $rowdata);
					$slno++;
				}
			}
			$writer->writeToFile($filepath);
			$response['status'] = 1;
			$response['excellink'] = $fileurl;
			echo json_encode($response);
			exit;
		}
        /*-- Add new admin user --*/
        if(isset($_REQUEST['addnewadmin'])){
            $user_name = $_REQUEST['username'];
            $dnamearr = explode(" ", $user_name);
            $first_name = ucfirst($dnamearr[0]);
            if(isset($dnamearr[2])){
                $reversearr = array_reverse($dnamearr);
                array_pop($reversearr);
                $reversearr = array_reverse($reversearr);
                $last_name = implode(" ", $reversearr);
            }else{
                if(isset($dnamearr[1])){
                    $last_name = ucfirst($dnamearr[1]);
                }else{
                    $last_name = "";
                }
            }
			$user_email = $_REQUEST['useremail'];
			$user_gender = ucfirst($_REQUEST['gender_select']);
            $phone_number = $_REQUEST['usermob'];
            $user_password = strong_password($_REQUEST['userpwd1']);
			$user_country = $_REQUEST['country_select'];
            $user_state = $_REQUEST['state_select'];
            $user_role_type = intval($_REQUEST['userrole']);
			$hub = intval($_REQUEST['hub']);
			if($user_role_type == 1){
				$userrole = "admin";
				$hub ="";
			}else{
				$userrole = "kkadmin";
				$hub = $hub;
			}
            date_default_timezone_set('Asia/Kolkata');
            $user_registered  = new DateTime();
            $user_registered = $user_registered->format('Y-m-d h:i:s');
			$response = array();
            $user_recordc = DB::table('users')->where([['user_email', $user_email], ['user_role', '=', $userrole]])->count();
			if($user_recordc == 0){
               $newuserid = DB::table('users')->insertGetId(['user_name' => $user_email, 'user_email' => $user_email, 'user_password' => $user_password, 'user_oathtype' => 'email', 'user_role' => $userrole, 'user_status' => 1, 'user_registered' => $user_registered]);
                $user_meta_datas = array('first_name' => $first_name, 'last_name' => $last_name, 'user_gender' => $user_gender, 'phone_number' => $phone_number, 'user_country' => $user_country, 'user_state' => $user_state, 'hub' => $hub);
				foreach($user_meta_datas as $umetak => $umetav){
					update_user_meta($newuserid, $umetak, $umetav);
				}
               $response['status'] = 1;
            }else{
               $response['status'] = 2;
            }
            echo json_encode($response);
			exit;
		}
		/*--Update admin/kkamin profile Start--*/
		if(isset($_REQUEST['updateadminprofile'])){ 
			$response = array();
			$user_id = $_REQUEST['uuid'];
			$response = array();
			$data = new stdClass();
			$data->sessionlogindata = json_decode(session()->get('auserdata'));
			//echo "<pre>"; print_r($data->sessionlogindata); echo "</pre>";
			if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
				$user_id = $user_id;
				$user_email = $_REQUEST['useremail'];
				$hub = intval($_REQUEST['hub']);
				$user_role_type = intval($_REQUEST['userrole']);
				if($user_role_type == 1){
					$userrole = "admin";
					$hub ="";
				}else{
					$userrole = "kkadmin";
					$hub = $hub;
				}
			}else{
				if($data->sessionlogindata->user_role == 'kkadmin'){
					if($user_id == $data->sessionlogindata->ID){
						$user_id = intval($data->sessionlogindata->ID);
						$user_email = $data->sessionlogindata->email;
						$userrole = $data->sessionlogindata->user_role;
						$hub = $data->sessionlogindata->hub_id;
					}
				}
			}
			$user_name = $_REQUEST['username'];
			$dnamearr = explode(" ", $user_name);
			$first_name = ucfirst($dnamearr[0]);
			if(isset($dnamearr[2])){
				$reversearr = array_reverse($dnamearr);
				array_pop($reversearr);
				$reversearr = array_reverse($reversearr);
				$last_name = implode(" ", $reversearr);
			}else{
				if(isset($dnamearr[1])){
					$last_name = ucfirst($dnamearr[1]);
				}else{
					$last_name = "";
				}
			}
			$user_gender = ucfirst($_REQUEST['gender_select']);
			$phone_number = $_REQUEST['usermob'];
			$userpwd1 = $_REQUEST['userpwd1'];
			if(!empty($userpwd1)){
				$user_password = strong_password($_REQUEST['userpwd1']);
			}else{
				$user_password = false;
			}
			$user_country = $_REQUEST['country_select'];
			$user_state = $_REQUEST['state_select'];
			$user_recordc = DB::table('users')->where([['user_email', $user_email], ['user_role', '=', $userrole]])->count();
			if($user_recordc == 1){
				if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin')){
					DB::table('users')->where('ID', $user_id)->update(array('user_name' => $user_email, 'user_email' => $user_email));
				}
				if($user_password){
					DB::table('users')->where('ID', $user_id)->update(array('user_password' => $user_password));
				}
				$user_meta_datas = array('first_name' => $first_name, 'last_name' => $last_name, 'user_gender' => $user_gender, 'phone_number' => $phone_number, 'user_country' => $user_country, 'user_state' => $user_state, 'hub' => $hub);
				foreach($user_meta_datas as $umetak => $umetav){
					update_user_meta($user_id, $umetak, $umetav);
				}
			  $response['status'] = 1;
            }else{
               $response['status'] = 0;
            }
			echo json_encode($response);
			exit;
		}
		/*--Update admin/kkamin profile End--*/
		/*-- Delete admin user data--*/
		if(isset($_REQUEST['deleteadmins'])){
			$userids = json_decode($_REQUEST['userids']);
			$response = array();
			$userscount = DB::table('users')->where('user_role', 'admin')->whereIn('ID', $userids)->count();
			if($userscount > 0){
				$current_user_data = session('auserdata');
				$current_user_arr = json_decode($current_user_data);
				$arrayindex = array_search($current_user_arr->ID,$userids);
				unset($userids[$arrayindex]);
				//echo "<pre>"; print_r($userids); echo "</pre>";
				DB::table('users')->whereIn('ID', $userids)->delete();
				DB::table('user_meta')->whereIn('user_id', $userids)->delete();
				$response['status'] = 1;
			}else{
				$response['status'] = 0;
			}
			echo json_encode($response);
			exit;
		}
	}
}
