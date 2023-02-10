<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\Auth\Client;
use Exception;
use Session;

class ClientController extends Controller
{
    // This function is used for view create client page
    public function create(){
        return view('Admin.Clients.create');
    }

    // This function is used for Add the New Cient
    Public function store(Request $request){
        try {
            $POST = $request->all();
            $user = Session::get('users');
            // dd($POST);
            $data = new Client();
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Company Logo"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/clients', $fileName);
                    $data->company_logo    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Company Logo"]);
                }
            }

            $data->client_name      =   $request->client_name;
            $data->contact_email    =   $request->contact_email;
            $data->contact_mobile   =   $request->contact_mobile;
            $data->company_name     =   $request->company_name;
            $data->start_date       =   $request->start_date;
            $data->created_by       =   $user->emp_code;

            $data->save();
            return response()->json(['status'=>'1', 'msg' =>"Client Added Successfully !", 'data'=>$data]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg", 'data'=>$data]);
        }
    }

    // This function is used for fetch details of all Cients
    public function index(){
        $clients = Client::get();
        return view('Admin.Clients.index' ,compact('clients'));
    }

    // Fetch all details of Specific client by his unique ID for Edit client Details
    public function edit($id){
        $client = client::find($id);
        if ($client) {
            return view('admin.Clients.edit', ['client'=>$client]);
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
            $data = client::find($id);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Company Logo"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/clients', $fileName);
                    $data->company_logo    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Company Logo"]);
                }
            }

            $data->client_name      =   $request->client_name;
            $data->contact_email    =   $request->contact_email;
            $data->contact_mobile   =   $request->contact_mobile;
            $data->company_name     =   $request->company_name;
            $data->start_date       =   $request->start_date;
            $data->updated_by       =   $user->emp_code;

            if ($data) {
                $data->update();
                return response()->json(['status'=>'1', 'msg' =>"Client Update Successfully !", 'data'=>$data]);
            }
            else {
                return response()->json(['status'=>'0', 'msg' =>"Error while updating client ID - $id"]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    
    // Delete client By his unique ID
    public function delete($id){
        try {
            $client = Client::find($id);
                if ($client) {
                    $client->delete();    
                    return back()->with(['status'=>'1', 'msg' =>"ID - $id Client Deleted Successfully !", 'data'=>$client]);
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
