<?php

	function get_settings($settingkey){
		$settingrowc = DB::table('btb_settings')->where('setting_key', $settingkey)->count();
		if($settingrowc > 0){
			$settingrow = DB::table('btb_settings')->where('setting_key', $settingkey)->first();
			$settingval = $settingrow->setting_value;
		}else{
			$settingval = "";
		}
		return $settingval;
	}
	function update_rest_meta($rest_id, $metak, $metav){
		$result = DB::table('btb_restmeta')->where([['restaurent_id', '=', $rest_id], ['meta_key', '=', $metak]])->get();
		if(count($result) > 0){
			DB::table('btb_restmeta')->where(['restaurent_id' => $rest_id, 'meta_key' => $metak])->update(['meta_value' => $metav]);
		}else{
			DB::table('btb_restmeta')->insert([['restaurent_id' => $rest_id, 'meta_key' => $metak, 'meta_value' => $metav]]);
		}
	}
	function get_userimage($atid){
		$result = DB::table('media')->where('ID', $atid)->first();
		if(isset($result->abs_path)){
			return $result->abs_path;
		}else{
			return "img/profile_dp.png";
		}
	}
	function get_rashidimage($atid){
		$result = DB::table('media')->where('ID', $atid)->first();
		if(isset($result->abs_path)){
			return $result->abs_path;
		}else{
			return "img/default_rashid.jpg";
		}
	}
	function get_hawan_count(){
		$hawan_recordc = DB::table('hawans')->count();
		return $hawan_recordc;
	}

	function delete_hawan($hawan_id){
		DB::table('hawans')->where(['ID', '=', $hawan_id])->delete();
	}

	function add_hawan_meta($hawan_id, $metak, $metav){
		DB::table('hawan_meta')->insert([['hawan_id' => $hawan_id, 'meta_key' => $metak, 'meta_value' => $metav]]);
	}

	function get_hawan_meta($hawan_id, $metak, $singular){
		if($singular==true){
			$hawanmetasc = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->count();
			if($hawanmetasc > 0){
				$hawanmeta = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->first();
				return $hawanmeta->meta_value;
			}else{
				return "";
			}
		}else{
			$hawanmetasc = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->count();
			if($hawanmetasc > 0){
				$hawanmetas = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->get();
				$hawanmetadata = array();
				foreach($hawanmetas as $hawanmeta){
					array_push($hawanmetadata, array("meta_key" => $hawanmeta->meta_key, "meta_value" => $hawanmeta->meta_value));
				}
				return $hawanmetadata;
			}else{
				return "";
			}
		}
	}

	function update_hawan_meta($hawan_id, $metak, $metav){
		$resultc = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->count();
		if($resultc > 0){
			$result = DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->get();
			DB::table('hawan_meta')->where(['hawan_id' => $hawan_id, 'meta_key' => $metak])->update(['meta_value' => $metav]);
		}else{
			DB::table('hawan_meta')->insert([['hawan_id' => $hawan_id, 'meta_key' => $metak, 'meta_value' => $metav]]);
		}
	}
	function delete_hawan_meta($hawan_id, $metak){
		DB::table('hawan_meta')->where([['hawan_id', '=', $hawan_id], ['meta_key', '=', $metak]])->delete();
	}

	function get_havancount($user_id){
		$havancount = DB::table("hawans")->where('user_id', $user_id)->count();
		return $havancount;
	}

	function havan_count_statewise($statname){
		$havancount_statewise = DB::table("hawans")->where('state', $statname)->count();
		return $havancount_statewise;
	}
	function vidhyarthi_count_statewise($statname){
		$vidhyarthi_statewise = DB::table('hawans')->where('state', $statname)->groupBy('hawans.user_id')->paginate(1); 
		return $vidhyarthi_statewise->total();  
	}	
	function havan_sum_statewise($statname){
		$grosssum = DB::table('hawans')->where('state', $statname)->sum('gross_total_amt');
		return $grosssum;
	}

	function havan_count_hubwise($hubid){
		$havancount_hubwise = DB::table("hawans")->where('hub_id', $hubid)->count();
		return $havancount_hubwise;
	}
	
	function vidhyarthi_count_hubwise($hubid){
		$vidhyarthi_hubwise = DB::table('hawans')->where('hub_id', $hubid)->groupBy('hawans.user_id')->paginate(1); 
		return $vidhyarthi_hubwise->total();  
	}	
	
	function havan_sum_hubwise($hubid){
		$grosssum = DB::table('hawans')->where('hub_id', $hubid)->sum('gross_total_amt');
		return $grosssum;
	}

	function havan_count_districtwise($districtname){
		$havancount_districtwise = DB::table("hawans")->where('distric', $districtname)->count();
		return $havancount_districtwise;
	}
	function vidhyarthi_count_districtwise($districtname){
		$vidhyarthi_districtwise = DB::table('hawans')->where('distric', $districtname)->groupBy('hawans.user_id')->paginate(1); 
		return $vidhyarthi_districtwise->total();  
	}
	function havan_sum_districtwise($districtname){
		$grosssum = DB::table('hawans')->where('distric', $districtname)->sum('gross_total_amt');
		return $grosssum;
	}
	function havan_sum_datewise($date_of_hawan){
		$grosssum = DB::table('hawans')->where('date_of_hawan', $date_of_hawan)->sum('gross_total_amt');
		return $grosssum;
	}
	function havan_count_datewise($date_of_hawan){
		$havancount_datewise = DB::table("hawans")->where('date_of_hawan', $date_of_hawan)->count();
		return $havancount_datewise;
	}
	function get_hawanamt_byuser($hawanuserid){
		$grosssum = DB::table('hawans')->where('user_id', $hawanuserid)->sum('gross_total_amt');
		return $grosssum;
	}
	function get_hubname_by_hubid($hubid){
		$our_hub = DB::table('our_hub')->where('ID', $hubid)->first(); 
		return $our_hub->name;
	}
	function get_statename_by_stateid($stateid){
		$state = DB::table('states')->where('ID', $stateid)->first(); 
		return $state->name;
	}
	function get_districtname_by_districtid($districtid){
		$district = DB::table('districts')->where('ID', $districtid)->first(); 
		return $district->name;
	}	
 
?>
