<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\WeeklyRating;
use App\Auth\employee;
use App\Auth\Client;
use App\Auth\Project;
use App\attendance;
// use Exception;
use Session;
use DateTime;
use URL;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use Mail;

class WeeklyRatingController extends Controller
{
    // This function is used for save rating by admin
    public function RequestForRate(Request $request){
        try{
            $empID   = $request->id;
            $user = Session::get('users');

            $attendance = attendance::where('id', $empID)->first();
            $project    = Project::where('working_emp', $attendance->emp_code)->first();
            $employee   = employee::where('emp_code', $attendance->emp_code)->first();
            if (!$project) {
                return response()->json(['status'=>'0', 'msg' =>"This Employee is not working on any project"]);
            }
            $client    = Client::where('id', $project->client)->first();

            // dd($attendance);
            // dd($client);
            
            if ($attendance) {
                $rate = new WeeklyRating();
                $rate->attedance_id         =   $attendance->id;
                $rate->wrk_emp_code         =   $attendance->emp_code;
                $rate->cln_id               =   $client->id;
                $rate->cln_email            =   $client->contact_email;
                $rate->rt_status            =   'RQ';
                $rate->rqt_date             =   date ("Y-m-d");
                $rate->check_in             =   $attendance->check_in;
                $rate->check_out            =   $attendance->check_out;
                $rate->total_work           =   $attendance->total_work;
                $rate->rqt_emp_code         =   $user->emp_code;
                $rate->save();

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
                    $mail->addAddress($client->contact_email, $client->contact_name);
                    $mail->isHTML(true);
                    $IDNo =  $rate->id;                    
                    $URL = (URL::to("/rate-to-employe-$rate->id"));
                    $mail->Subject = "Rate Weekly Work For Project - $project->project_name To $employee->first_name $employee->last_name ($attendance->emp_code)";
                    $mail->Body    = "Please rate the $employee->first_name $employee->last_name ($attendance->emp_code) Out of 5 for the Project - $project->project_name <br><br><br> <a href='{$URL}'><button style='background-color: green; color:white; cursor: pointer;'>Click for Rate</button></a>";
                    if($mail->send()){
                        return response()->json(['status'=>'1', 'msg' =>"Rating send successfully"]);
                    }
                    else{
                        return response()->json(['status'=>'1', 'msg' =>"Rating send but email does not Send"]);
                    }
                } catch (Exception $e) {
                    return response()->json(['status'=>'0', 'msg' =>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                }
            } else {
                return response()->json(['status'=>'0', 'msg' =>"No attendance record available"]);
            }
            
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }

    // This function is used for save rating by client
    public function RequestForRate1(Request $request){
        // try{
            $empID   = $request->id;
            $user = Session::get('users');

            $attendance = attendance::where('id', $empID)->first();
            $project    = Project::where('working_emp', $attendance->emp_code)->first();
            $employee   = employee::where('emp_code', $attendance->emp_code)->first();
            if (!$project) {
                return response()->json(['status'=>'0', 'msg' =>"This Employee is not working on any project"]);
            }
            $client    = Client::where('id', $project->client)->first();

            // dd($attendance);
            // dd($client);
            
            if ($attendance) {
                $rate = new WeeklyRating();
                $rate->attedance_id         =   $attendance->id;
                $rate->wrk_emp_code         =   $attendance->emp_code;
                $rate->cln_id               =   $client->id;
                $rate->cln_email            =   $client->contact_email;
                $rate->rt_status            =   'RQ';
                $rate->rqt_date             =   date ("Y-m-d");
                $rate->check_in             =   $attendance->check_in;
                $rate->check_out            =   $attendance->check_out;
                $rate->total_work           =   $attendance->total_work;
                $rate->rqt_emp_code         =   $user->emp_code;
                // $rate->save();

                // try {
                    $template = 'client.thanks';
                    $template = 'admin.emailTemplate.rating';
                    $logo     = URL::to("/images/brand/logo.png");
                    $IDNo =  $rate->id;                  
                    $URL = URL::to("/rate-to-employe-$rate->id");
                    $data = ['logo'=>$logo,  'attendance'=>$attendance,'project'=>$project ,'employee'=>$employee, 'URL'=>$URL];
                    $subject = "Rate Weekly Work For $employee->first_name $employee->last_name ($attendance->emp_code)";
                    $to_email = $client->contact_email;
                    $to_name  = $client->client_name;
                    $from_emails = 'sarwandeveloper@gmail.com';
                    $from_subject = 'Sarwan Verma';
                    // return view($template)->with($data);

                    // dd($to_name, $to_email, $subject, $from_emails, $from_subject, $data);
                    $res= Mail::send($template, $data, function($message) use ($to_name, $to_email, $subject, $from_emails, $from_subject) {
                        $message->to($to_email, $to_name)
                            ->subject($subject);
                        $message->from($from_emails, $from_subject);
                    });
        
                    return response()->json(['status' => 1, 'message' => 'Wish message send Sucessfully.']);

                // } catch (Exception $e) {
                //     return response()->json(['status'=>'0', 'msg' =>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                // }
            } else {
                return response()->json(['status'=>'0', 'msg' =>"No attendance record available"]);
            }
            
        // } catch (\Exception $e) {
        //     $msg = $e->getMessage();
        //     return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        // }
    }
}
