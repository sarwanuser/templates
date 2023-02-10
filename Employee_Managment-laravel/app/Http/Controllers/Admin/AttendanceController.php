<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\attendance;
use Exception;
use Session;
use DateTime;

class AttendanceController extends Controller
{
    // This function is used for fetch details of all attendance and rating
    public function attendance(Request $request){
        try{
            $employees = employee::select('first_name', 'last_name', 'emp_code')->where('status', '1')->orderBy('emp_code','asc')->get();
            // $attendance = attendance::select('attendances.*', 'ratings.rating', 'ratings.description')
            //                         ->leftjoin('ratings','ratings.attedance_id','=','attendances.id')
            //                         ->orderBy('attendances.created_at','desc')->get();

            $attendance = attendance::select('attendances.*', 'ratings.rating', 'ratings.description', 'weekly_ratings.rt_status', 'weekly_ratings.cln_rating', 'weekly_ratings.cln_description')
                                    ->leftjoin('ratings','ratings.attedance_id','=','attendances.id')
                                    ->leftjoin('weekly_ratings','weekly_ratings.attedance_id','=','attendances.id')
                                    ->orderBy('attendances.created_at','desc')->get();
            // dd($attendance);
            if($request->all()){
                if ($request->emp_code!='') {
                    $attendance = $attendance->where('emp_code', $request->emp_code);
                }

                if ($request->from_date!='') {
                    $from = date("Y-m-d 00:00:00", strtotime($request->from_date)); 
                    $to   = date("Y-m-d 00:00:00", strtotime($request->to_date));
                    // dd($from, $to);  
                    $attendance = $attendance->whereBetween('check_in', [$from, $to]);
                }
                return view('admin.AllAttendance',compact('attendance', 'employees'));
            }
            else {
                return view('admin.AllAttendance',compact('attendance', 'employees'));
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

}
