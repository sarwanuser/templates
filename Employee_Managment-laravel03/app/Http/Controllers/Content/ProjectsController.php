<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Content\Projects_Details;
use App\Content\Sub_Projects_Details;
use Exception;
use Session;

class ProjectsController extends Controller
{
    // This function is used for fetch details of all Projects
    public function index(){
        $data = Projects_Details::with('sub_projects_details')->orderBy('created_at', 'DESC')->get();
        return view('Content.Projects.index' ,compact('data'));
    }

    // This function is used for view create Project page
    public function create(){
        return view('Content.Projects.create');
    }

    // This function is used for Add the New Project
    Public function store(Request $request){
        try {
            $POST = $request->all();
            $user = Session::get('users');
            // dd($request->pr_sub_image);
            // dd($POST);
            
            // checking for file exention
            if ($request->hasFile('pr_main_image')) {
                $mainfile   = $request->file('pr_main_image');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext        = $mainfile->getClientOriginalExtension();
                $size       = $mainfile->getSize();
                $check = in_array($ext, $allowedExt);

                if ($check) {
                    $mainfileName = time() . $mainfile->getClientOriginalName();
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Main Image"]);
                }
            }
            
            // save main projects details
            $data = new Projects_Details();
            $data->pr_main_title            =   $request->pr_main_title;
            $data->pr_main_description      =   $request->pr_main_description;
            $data->created_by               =   $user->emp_code;
            $data->pr_main_image            =   $mainfileName;
            $data->save();
            
            if (isset($request->pr_sub_title)) {
                $count = count($request->pr_sub_title);
                // dd($count);
                if($count > 0)
                {   
                    // checking for file exention
                    for ($x = 1; $x <= $count; $x++)
                    {
                        if ($request->hasFile('pr_sub_image.'.$x)) {
                            $file = $request->file('pr_sub_image.'.$x);
                            $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                            $ext = $file->getClientOriginalExtension();
                            $check = in_array($ext, $allowedExt);

                            if (!$check) {
                                return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for images for Sub ID- $x"]);
                            }
                        }
                    }

                    // Save projects sub details
                    for ($x = 0; $x < $count; $x++)
                    {   
                        $sub = new Sub_Projects_Details();

                        if ($request->hasFile('pr_sub_image.'.$x)) {
                            $file = $request->file('pr_sub_image.'.$x);
                            $fileName = time() . $file->getClientOriginalName();
                            $file->move(public_path('images/projects/subimg'), $fileName);
                            $sub->pr_sub_image      = $fileName;
                        }

                        $sub->projects_details_id       = $data->id;
                        $sub->pr_sub_title      = $request->pr_sub_title[$x];
                        $sub->pr_sub_description        = $request->pr_sub_description[$x];
                        $sub->created_by               =   $user->emp_code;
                        $sub->save();
                    }
                }
            }

            $mainfile->move(public_path('images/projects'), $mainfileName);
            return response()->json(['status'=>'1', 'msg' =>"Project Added Successfully !", 'data'=>$data]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // Fetch all details of Specific projects by his unique ID for Edit projects Details
    public function edit($id){
        $project = Projects_Details::with('sub_projects_details')->find($id);
        // dd($project);
        if ($project) {
            return view('Content.Projects.edit', ['project'=>$project]);
        } else {
            return response()->json(['status'=>'0', 'msg' =>"No Record found for ID- $id"]);
        }
    }

    // this function is used for update by projects By his unique ID 
    public function update(Request $request, $id)
    {
        try{
            $POST = $request->all();
            $user = Session::get('users');  
            // dd($POST);
            $data = Projects_Details::find($id);

            if ($request->hasFile('pr_main_image')) {
                $mainfile   = $request->file('pr_main_image');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext        = $mainfile->getClientOriginalExtension();
                $check = in_array($ext, $allowedExt);

                if ($check) {
                    $mainfileName = time() . $mainfile->getClientOriginalName();
                    $mainfile->move(public_path('images/projects'), $mainfileName);
                    $data->pr_main_image            =   $mainfileName;
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Main Image"]);
                }
            }

            if (isset($request->pr_sub_title)) {
                $count = count($request->pr_sub_title);
                // dd($count);
                if($count > 0)
                {   
                    // checking for file exention
                    for ($x = 1; $x <= $count; $x++)
                    {
                        if ($request->hasFile('pr_sub_image.'.$x)) {
                            $file = $request->file('pr_sub_image.'.$x);
                            $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                            $ext = $file->getClientOriginalExtension();
                            $check = in_array($ext, $allowedExt);

                            if (!$check) {
                                return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for images for Sub ID- $x"]);
                            }
                        }
                    }
                }
            }
                    
            Sub_Projects_Details::where('projects_details_id', $data->id)->delete();
            if (isset($request->pr_sub_title)) {
                if($count > 0)
                {
                    // Save projects sub details
                    for ($x = 0; $x < $count; $x++)
                    {   
                        $sub = new Sub_Projects_Details();

                        if ($request->hasFile('pr_sub_image.'.$x)) {
                            $file = $request->file('pr_sub_image.'.$x);
                            $fileName = time() . $file->getClientOriginalName();
                            $file->move(public_path('images/projects/subimg'), $fileName);
                            $sub->pr_sub_image      = $fileName;
                        }else {
                            $sub->pr_sub_image      = $request->pr_sub_image[$x];
                        }

                        $sub->projects_details_id       = $data->id;
                        $sub->pr_sub_title      = $request->pr_sub_title[$x];
                        $sub->pr_sub_description        = $request->pr_sub_description[$x];
                        $sub->created_by               =   $user->emp_code;
                        $sub->updated_by               =   $user->emp_code;
                        $sub->save();
                    }
                }
            }

            $data->pr_main_title            =   $request->pr_main_title;
            $data->pr_main_description      =   $request->pr_main_description;
            $data->updated_by               =   $user->emp_code;

            if ($data) {
                $data->update();
                return response()->json(['status'=>'1', 'msg' =>"Team Member Update Successfully !", 'data'=>$data]);
            }
            else {
                return response()->json(['status'=>'0', 'msg' =>"Error while updating Team Member ID - $id"]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // Delete projects details By his unique ID
    public function delete($id){
        try {
            $project = Projects_Details::find($id);
                if ($project) {
                    $project->delete();
                    Sub_Projects_Details::where('projects_details_id', $id)->delete();
                    return back()->with(['status'=>'1', 'msg' =>"ID - $id Projects Deleted Successfully !", 'data'=>$project]);
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
