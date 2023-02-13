<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\attendance;
use Exception;
use Session;
use DateTime;

class AttendanceController extends Controller
{
    // This function is used for check-in the user for attendance
    public function checkIn(){

        try{
            $user = Session::get('users');  
            $emp_code = $user->emp_code;
            $emp_name = "$user->first_name $user->last_name";
            $allready = attendance::where('emp_code', $emp_code)->whereDate('check_in', date ("Y-m-d"))->first();
            if ($allready) {
                return response()->json(['status'=>'0', 'msg' =>"Sorry! Today you have allready Checked-In"]);
            }
            $atten = new attendance();
            $atten->emp_name = $emp_name;
            $atten->emp_code = $emp_code;
            $atten->check_in = date ("Y-m-d H:i:s");
            $atten->save();

            $time = date("h:i:s A", strtotime($atten->check_in));
            return response()->json(['status'=>'1', 'msg' =>"Check-In Successfully", 'time'=>$time]);

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // This function is used for check-out the user for attendance
    public function checkOut(){
        try{
            $user = Session::get('users');
            $emp_code = $user->emp_code;
            $notCheckIn = attendance::where('emp_code', $emp_code)->whereDate('check_in', date ("Y-m-d"))->first();
            if (!$notCheckIn) {
                return response()->json(['status'=>'0', 'msg' =>"Please Check-In first"]);
            }
            $allready = attendance::where('emp_code', $emp_code)->whereDate('check_out', date ("Y-m-d"))->first();
            if ($allready) {
                return response()->json(['status'=>'0', 'msg' =>"Sorry! Today you have allready Checked-Out"]);
            }
            $check_in =  $notCheckIn->check_in;
            $check_out = date ("Y-m-d H:i:s");

            $datetime1 = new DateTime($check_in);
            $datetime2 = new DateTime($check_out);
            $interval = $datetime1->diff($datetime2);
            $totalTimes = $interval->format('%H:%i:%s');//now do whatever you like with $days

            attendance::where('emp_code', $emp_code)->whereDate('check_in', date ("Y-m-d"))->update(['check_out' => $check_out, 'total_work' => $totalTimes]);
            $time = date("h:i:s A", strtotime($check_out));
            return response()->json(['status'=>'1', 'msg' =>"Check-Out Successfully", 'time'=>$time]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // This function is used for ALL attendance of logget in user
    public function attendance(){
        try{
            $user = Session::get('users');
            $emp_code = $user->emp_code;
            $attendance = attendance::where('emp_code', $emp_code)->orderBy('created_at','desc')->get();
            return view('user.AllAttendance',compact('attendance'));
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // This function is used for fetch timer from check-in 
    public function getTimer(){
        try{
            $user = Session::get('users');
            $emp_code = $user->emp_code;
            $notCheckout = attendance::where('emp_code', $emp_code)->whereDate('check_out', date ("Y-m-d"))->first();
            if (!$notCheckout) {
                $checkIn = attendance::select('check_in')->where('emp_code', $emp_code)->whereDate('check_in', date ("Y-m-d"))->first();
                if ($checkIn) {
                    return response()->json(['status'=>'1', 'checkIn'=>$checkIn->check_in]);
                }else {
                    return response()->json(['status'=>'0', 'msg' =>"Not checked In"]);
                }
            }
            else {
                return response()->json(['status'=>'2', 'checkOut' =>$notCheckout->total_work]);
            }
            
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }
}
