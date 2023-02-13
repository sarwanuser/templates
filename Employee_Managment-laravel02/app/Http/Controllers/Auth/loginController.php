<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use Illuminate\Support\Facades\Hash;
use Session;

class loginController extends Controller
{   
    // this function is used for Login and Check valid user
    public function login(Request $request){
        $this->validate($request,[
            'emp_code' =>'required',
            'password' =>'required',
        ]);
        $emp_code = $request->emp_code;
        
        $psw = $request->password;

        if ($data = employee::where('emp_code', $emp_code)->first()) {
            $pass = Hash::check($request->password, $data->password);
            if ($pass) {
                // check for user is Pending
                if ($data->status=='0') {
                    return back()->with('Failed', 'Your ID is Pending for Admin verification');
                }
                // check for user is Active
                elseif ($data->status=='1') {
                    Session::forget('users'); 
                    session(['users' => $data]);
                    // check for Role admin
                    if ($data->usertype=="1") {
                        return redirect('/admin/dashboard')->with(['status'=>'1', 'msg' =>"Login Successfully"]);
                    }
                    // check for Role Employee
                    else {
                        return redirect('/dashboard')->with(['status'=>'1', 'msg' =>"Login Successfully !"]);
                    }
                }
                // check for user is Inactive
                else {
                    return back()->with('Failed', 'Your ID is Inactiveted By Admin');
                }
            } 
            else {
                return back()->with('Failed', 'Invalid Employee Code or Password');
            }
        } 
        else {
            return back()->with('Failed', 'Invalid Employee !');
        }
    }
}