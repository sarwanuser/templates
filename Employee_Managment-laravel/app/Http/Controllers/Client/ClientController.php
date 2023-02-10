<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\WeeklyRating;
use App\Auth\employee;
use App\Auth\Client;
use App\Auth\Project;
use App\attendance;
// use Exception;
use DateTime;
use URL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ClientController extends Controller
{
    public function index(Request $request){
        try {
            $allreadyRated = WeeklyRating::where('id', $request->id)->where('rt_status', 'RT')->first();
            if (!$allreadyRated) {
                $WeeklyRating = WeeklyRating::where('id', $request->id)->first();
                if ($WeeklyRating) {
                    $Project = Project::where('client', $WeeklyRating->cln_id)->first();
                    $employee = employee::where('emp_code', $WeeklyRating->wrk_emp_code)->first();
                    return view('client.rating', compact('WeeklyRating', 'employee', 'Project'));
                } else {
                    return response()->json(['status'=>'0', 'msg' =>"Invalid Request"]);
                }
            }else{
                echo "</br><center><b style='color: red;'>Sorry rating is allready Exist</b></center>";
            }
        }catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    public function SendWeeklyRating(Request $request){
        // dd($request->all());
        $WeeklyRating = WeeklyRating::where('id', $request->weekID)->where('wrk_emp_code', $request->empCode)->first();
        $Project = Project::where('client', $WeeklyRating->cln_id)->first();
        $employee = employee::where('emp_code', $WeeklyRating->wrk_emp_code)->first();

        if ($WeeklyRating) {
            $data = WeeklyRating::find($request->weekID);
            $data->rt_status         =   'RT';
            $data->cln_rating        =   $request->rating;
            $data->cln_description   =   $request->description;
            $data->rt_date           =   date('Y-m-d)');
            $data->update();

            require base_path("vendor/autoload.php");
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                                       
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                             
                    $mail->Username   = 'sarwandeveloper@gmail.com';             
                    $mail->Password   = 'kyobetfkoucvykce';                        
                    $mail->SMTPSecure = 'tls';                              
                    $mail->Port       = 25;  
                
                    $mail->setFrom('sarwandeveloper@gmail.com');
                    $mail->addAddress($employee->company_email, $employee->first_name. ' '.$employee->last_name);
                    $mail->isHTML(true);
                    $mail->Subject = "Weekly Rating Work for Project - $Project->project_name";
                    $mail->Body    = "<br>
                                    Dear $employee->first_name $employee->last_name ($employee->emp_code)
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have recieved rating $request->cln_rating out of 5 for the Date of " .date('d-m-Y', strtotime($WeeklyRating->check_in));
                    if($mail->send()){
                        return view('client.thanks');
                    }
                    else{
                        return view('client.thanks');
                    }
                } catch (Exception $e) {
                    return response()->json(['status'=>'0', 'msg' =>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                }
        } else {
            return response()->json(['status'=>'0', 'msg' =>"Invalid Request"]);
        }
    }
}
