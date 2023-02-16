<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Auth\employee;
use App\Auth\Rating;
use App\attendance;
// use Exception;
use Session;
use DateTime;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RatingController extends Controller
{   
    // This function is used for save rating by admin
    public function rate(Request $request){
        try{
            $rating  = $request->rating;
            $descr   = $request->descr;
            $empID   = $request->empID;
            $empCode = $request->empCode;

            $attendance = attendance::where('emp_code', $empCode)->where('id', $empID)->first();
            // dd($attendance);
            if ($attendance) {
                $rate = new Rating();
                $rate->attedance_id         =   $attendance->id;
                $rate->emp_code         =   $attendance->emp_code;
                $rate->rating           =   $rating;
                $rate->description      =   $descr;
                $rate->date             =   date ("Y-m-d");
                $rate->check_in         =   $attendance->check_in;
                $rate->check_out        =   $attendance->check_out;
                $rate->total_work       =   $attendance->total_work;
                $rate->save();

                $employee = employee::where('emp_code', $empCode)->first();
                $user = Session::get('users');

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
                
                    $mail->setFrom($user->company_email, $user->first_name.' '. $user->last_name);           
                    $mail->addAddress($employee->company_email, $employee->first_name.' '. $employee->last_name);
                    $mail->isHTML(true);                                  
                    $mail->Subject = "Daily Work Raiting by $user->first_name $employee->last_name ($user->emp_code)";
                    $mail->Body    = "<br>
                                    Dear $employee->first_name $employee->last_name ($employee->emp_code)
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have recieved rating $rating out of 5 for the Date of " .date('d-m-Y', strtotime($attendance->check_in));
                    // $mail->AltBody = 'Body in plain text for non-HTML mail clients';
                    
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
                return response()->json(['status'=>'0', 'msg' =>"No attendance record available for this Rating"]);
            }
            
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg"]);
        }
    }
}