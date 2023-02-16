<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Content\Team;
use Exception;
use Session;

class TeamController extends Controller
{
    // This function is used for view create team page
    public function create(){
        return view('Content.Teams.create');
    }

    // This function is used for Add the New Teams
    Public function store(Request $request){
        try {
            $POST = $request->all();
            $user = Session::get('users');
            // dd($POST);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Profile Photo"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/teams', $fileName);
                    $pic    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Profile Photo"]);
                }
            }
            
            $data = new Team();
    
            $data->mbr_name         =   $request->mbr_name;
            $data->mbr_designation          =   $request->mbr_designation;
            $data->fcb_url      =   $request->fcb_url;
            $data->twr_url               =   $request->twr_url;
            $data->lnkd_url          =   $request->lnkd_url;
            $data->profile_photo               =   $pic;
            $data->description       =   $request->description;
            $data->created_by           =   $user->emp_code;
            $data->save();

            return response()->json(['status'=>'1', 'msg' =>"Member Added Successfully !", 'data'=>$data]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg", 'data'=>$data]);
        }
    }

    // This function is used for fetch details of all Team
    public function index(){
        $data = Team::get();
        // dd($clients);
        return view('Content.Teams.index' ,compact('data'));
    }

    // Fetch all details of Specific client by his unique ID for Edit client Details
    public function edit($id){
        $team = Team::find($id);
        if ($team) {
            return view('Content.Teams.edit', ['team'=>$team]);
        } else {
            return response()->json(['status'=>'0', 'msg' =>"No Record found for ID- $id"]);
        }
    }

    // this function is used for update by Employee By his unique ID 
    public function update(Request $request, $id)
    {
        try{
            $POST = $request->all();
            $user = Session::get('users');  
            // dd($POST);
            $data = Team::find($id);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Profile Photo"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/teams', $fileName);
                    $data->profile_photo    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Profile Photo"]);
                }
            }

            $data->mbr_name         =   $request->mbr_name;
            $data->mbr_designation          =   $request->mbr_designation;
            $data->fcb_url      =   $request->fcb_url;
            $data->twr_url               =   $request->twr_url;
            $data->lnkd_url          =   $request->lnkd_url;
            $data->description       =   $request->description;
            $data->updated_by      =   $user->emp_code;

            if ($data) {
                $data->update();
                return response()->json(['status'=>'1', 'msg' =>"Project Update Successfully !", 'data'=>$data]);
            }
            else {
                return response()->json(['status'=>'0', 'msg' =>"Error while updating Project ID - $id"]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }


    // Delete team member By his unique ID
    public function delete($id){
        try {
            $client = Team::find($id);
                if ($client) {
                    $client->delete();    
                    return back()->with(['status'=>'1', 'msg' =>"ID - $id Team Member Deleted Successfully !", 'data'=>$client]);
                } 
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Error while deleting ID- $id"]);
                }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }
}
