<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\Auth\Client;
use App\Auth\Project;
use Exception;
use Session;

class ProjectController extends Controller
{
    // This function is used for view create client page
    public function create(){
        $employees = employee::orderby('emp_code', 'ASC')->get();
        $clients = client::orderby('client_name', 'ASC')->get();
        // // dd($employees, $clients);
        return view('Admin.Projects.create', compact('employees', 'clients'));
    }

    // This function is used for Add the New Projects

    //  Project Status   -:
    //     1. Started-ST
    //     2. Planning-PL
    //     3. Developmemt-DV
    //     4. Staging-SG
    //     5. Testing-TS
    //     6. Live-LV
    //     7. Done-DN
    //     8. Re-Work-:RW
    //     9. Re-Testing-:RT
    //     10.Process-PR 

    // Payment Status
    //     1. Pending-PN
    //     2. Partial-PR
    //     3. Due-DU
    //     4. Over-Due-:OD
    //     5. Done-DN

    // Target Status
    //     1. Fine-FN
    //     2. Worning-WR
    //     3. Over-Due-OD


    Public function store(Request $request){
        try {
            $POST = $request->all();
            $user = Session::get('users');
            // dd($POST);
            // $end_date = now()->parse($request->start_date)->addDays($request->timeline);

            $data = new Project();
    
            $data->project_name         =   $request->project_name;
            $data->project_url          =   $request->project_url;
            $data->project_dev_url      =   $request->project_dev_url;
            $data->client               =   $request->client;
            $data->working_emp          =   $request->working_emp;
            // $data->start_date           =   $request->start_date;
            // $data->end_date             =   date("Y-m-d", strtotime($end_date));
            $data->budget               =   $request->budget;
            $data->payment_status       =   $request->payment_status;
            $data->created_date         =   date('Y-m-d');
            $data->timeline             =   $request->timeline;
            $data->status               =   'PR';
            $data->target_status        =   'FN';
            $data->created_by           =   $user->emp_code;

            $data->save();
            return response()->json(['status'=>'1', 'msg' =>"Project Added Successfully !", 'data'=>$data]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg", 'data'=>$data]);
        }
    }

    // This function is used for fetch details of all Cients
    public function index(){
        // $projects = Project::get();
        $projects = Project::select('projects.*', 'clients.client_name')
                                    ->leftjoin('clients','clients.id','=','projects.client')
                                    ->orderBy('projects.created_at','desc')->get();
        // dd($projects);
        return view('Admin.Projects.index' ,compact('projects'));
    }

    // Delete Project By his unique ID
    public function delete($id){
        try {
            $project = Project::find($id);
                if ($project) {
                    $project->delete();    
                    return back()->with(['status'=>'1', 'msg' =>"ID - $id Project Deleted Successfully !", 'data'=>$project]);
                } 
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Error while deleting ID- $id"]);
                }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // Fetch all details of Specific Project by his unique ID for Edit Project Details
    public function edit($id){
        $project = Project::find($id);
        if ($project) {
            $employees = employee::orderby('emp_code', 'ASC')->get();
            $clients = client::orderby('client_name', 'ASC')->get();
            return view('admin.Projects.edit', compact('project', 'employees', 'clients'));
        } else {
            return response()->json(['status'=>'0', 'msg' =>"No Record found for ID- $id"]);
        }
    }

    // this function is used for update by Projects By his unique ID 
    public function update(Request $request, $id)
    {
        try{
            $POST = $request->all();
            $user = Session::get('users');
            // dd($POST);
            $data = project::find($id);
            
            $data->project_name         =   $request->project_name;
            $data->project_url          =   $request->project_url;
            $data->project_dev_url      =   $request->project_dev_url;
            $data->client               =   $request->client;
            $data->working_emp          =   $request->working_emp;
            $data->budget               =   $request->budget;
            $data->payment_status       =   $request->payment_status;
            $data->timeline             =   $request->timeline;
            $data->status               =   $request->status;
            if($request->status=='ST'){
                $data->start_date           =   date("Y-m-d");
                $end_date = now()->parse($data->start_date)->addDays($request->timeline);
                $data->end_date             =   date("Y-m-d", strtotime($end_date));
            }
            $data->status_change_date   =  date('Y-m-d');
            $data->target_status        =   $request->target_status;
            $data->updated_by           =   $user->emp_code;

            if ($data) {
                $data->update();
                return response()->json(['status'=>'1', 'msg' =>"Project Update Successfully !", 'data'=>$data]);
            }
            else {
                return response()->json(['status'=>'0', 'msg' =>"Error while updating project ID - $id"]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }
}
