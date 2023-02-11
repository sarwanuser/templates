<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\attendance;
use Exception;
use Session;

class UserController extends Controller
{
    public function welcome(){
        $user = Session::get('users');  
        $emp_code = $user->emp_code;
        $emp_name = "$user->first_name $user->last_name";
        $todayCheckedIn  = attendance::where('emp_code', $emp_code)->whereDate('check_in', date ("Y-m-d"))->first();
        $todayCheckedOut = attendance::where('emp_code', $emp_code)->whereDate('check_out', date ("Y-m-d"))->first();
        
        return view('user.Dashboard',compact('todayCheckedIn','todayCheckedOut'));
    }

    public function PersonalInfo(){
        
        $user = Session::get('users');
        $emp_code = $user->emp_code;
        $employee = employee::where('emp_code', $emp_code)->first();
        return view('user.personal-information',compact('employee'));
    }

    public function UpdatePersonalInfo(Request $request){
        try {
            //code...
        
        $user = Session::get('users');
        $emp_code = $user->emp_code;
        employee::where('emp_code', $emp_code)->update([$request->bd_name => $request->val, 'updated_by' => $emp_code]);
        return response()->json(['status'=>'1', 'msg' =>"Updated Successfully"]);
        }catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }
}
