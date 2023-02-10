<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\attendance;

class AdminController extends Controller
{   
    // This function show the Admin Dashboard
    Public function dashboard(){
        $employees = employee::get();
        $NoOfEmployees = count($employees);
        $workingEmp = $employees->where('status', '1');
        $NoOfWorkingEmp = count($workingEmp);
        $CurrentWorkingEmp = attendance::whereDate('check_in', date ("Y-m-d"))->orderBy('created_at','desc')->get();
        return view('admin.Dashboard',compact('NoOfEmployees','NoOfWorkingEmp', 'CurrentWorkingEmp'));
    }
}
