<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use DB;
use Mail;
use PHPMailer\PHPMailer;
use Storage;
use View;
use App\Admin;
use App\Vender;
use App\Hotel;
use App\Operator;
use App\HotelGallery;
use App\HotelAmenity;
use App\Amenity;
use App\RoomCategory;
use App\HotelSeasonRate;
use App\PaidAmenity;
use App\HotelGroupSeasonRate;
use App\Lead;
use App\Quotation;
use App\Sale;
use App\Contacts;
use App\AdminRequest;
use App\EmailHistory;
use App\AssignContacts;
use Illuminate\Support\Facades\Session;

class SMTPMail extends Controller
{
	
	public function send1(){ 
		$text             = 'Hello Mail';
        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "Sales@ensoberhotels.com"; 
        $mail->Password = "neeraj123**";
        $mail->SetFrom("Sales@ensoberhotels.com", 'Ensober');
        $mail->Subject = "Ensober Email Test Subject";
        $mail->Body    = $text;
        $mail->AddAddress("sarwandeveloper@gmail.com", "Sarwan Verma");
        if ($mail->Send()) {
            return 'Email Sent Successfully';
        } else {
            return 'Failed to Send Email';
        }
	}
	
	
	
	public function generateTemplate(Request $request){
		//return $request;
		//$request->hotel_id = explode(',',$request->hotel_id);
		$data = Hotel::where('status','ACTIVE')->whereIn('id', $request->hotel_id)->get();
		
		$template = '<table valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody><tr>
    <td valign="top" align="center" style="padding: 100px 0 150px;border-collapse: collapse; background-color: #eee; "><table style="width:700px; background-color: #fff;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
        
        <tbody><tr> 
          <td style="padding:10px; border-top: 4px solid #9d6116; background-color: #fff;" valign="top" align="center">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody>
			  <tr>
                <td style="font-family:Open Sans, Arial, sans-serif; font-size:12px; line-height:15px; color:#0d1121;" valign="top" align="center">ENSOBER ALL IN ONE ITINERARY TOUR | <a href="#" target="_blank" style="color:#0d1121; text-decoration:underline;">View Online</a></td>
              </tr>
            </tbody></table></td> 
        </tr>
		
        <tr>
          <td valign="top" align="center">
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffffdb;box-shadow: inset 0 0 9px 0 #9d6116; border-bottom: 3px solid #3a3333;">
              <tbody><tr>
				<td valign="top" align="left" style="padding: 0 15px;">
					<h2 style="font-family: Arial, sans-serif;margin: 21px 0 1px;font-size: 33px;color: #9d6116;">Ensober Hotels</h2>
					<p style="color: #978c25;font-size: 16px;font-weight: bold;margin: 0;">Ensober All In One Itinerary Tour...</p>
				</td>
                <td valign="top" align="center">
					<img alt="Ensober Logo" style="display:block;font-family:Arial, sans-serif;font-size:30px;line-height:34px;color:#000000;height: 79px;margin: 8px 0 15px;width: 125px;" src="'.url('/public/asset/images/logo/logo.png').'" border="0">
				</td>
              </tr>
            </tbody>
			</table>';
			$c = 1;
			foreach($data as $Hotel){
				if($c%2 != 0){
					$classname = 'even';
				}else{
					$classname = 'odd';
				}
			if($Hotel->gallery_link != ""){
				$hottel_galerry = $Hotel->gallery_link;
			}else{
				$hottel_galerry = "/viewhotel/".$Hotel->id;
			}
			
			$hotelgalleries = HotelGallery::where('hotel_id', $Hotel->id)->get();
			$roomcategories = RoomCategory::where('hotel_id', $Hotel->id)->get();
			
			$template .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffffdb;"> 
              <tbody>
			  <tr>
				<td valign="top" align="center" style="padding: 0 15px;" class="'.$classname.'">
					<h2 style="font-family: Arial, sans-serif;margin: 21px 0 1px;font-size: 33px;color: #9d6116;">'.$Hotel->hotel_name.'</h2>
				</td>
			  </tr>
			  <tr>
				<td valign="top" align="center" style="padding: 0 15px" class="'.$classname.'">';
				
					if($Hotel->start_category=="ONE"){ 
						$star=1; 
					}elseif($Hotel->start_category=="TWO"){
						$star=2; 
					}elseif($Hotel->start_category=="THREE"){
						$star=3; 
					}elseif($Hotel->start_category=="FOUR"){
						$star=4; 
					}elseif($Hotel->start_category=="FIVE"){
						$star=5; 
					}
					for($i = 0; $i < $star; $i++){
						 $template .= '<img alt="Ensober Hotels" src="'.url('public/asset/images/icon/star.png').'" border="0" style="display: inline-block; width: 22px;" width="22px">';
					}
					
				$template .= '</td> 
			  </tr>
			  <tr>
				<td valign="top" align="center" style="padding: 0 15px 15px;" class="'.$classname.'">
					'.$Hotel->address.' '.$Hotel->region.' '.$Hotel->country.'
				</td>
			  </tr>
			  <tr>
				<td class="'.$classname.'">
					<table width="100%" cellspacing="0" cellpadding="0" border="1" align="center" style="background-color: #ffffffdb; font-size: 14px;">
					  <tbody>
					  <tr style="background-color: #9d6116; color: #fff;">
						<th valign="top" align="center" class="'.$classname.'">
							Room Category
						</th>
						<th valign="top" align="center" class="'.$classname.'">
							EP
						</th>
						<th valign="top" align="center" class="'.$classname.'">
							CP
						</th>
						<th valign="top" align="center" class="'.$classname.'">
							MAP
						</th>
						<th valign="top" align="center" class="'.$classname.'">
							AP
						</th>
					  </tr>'; 
					  
					  foreach($roomcategories as $roomcategory){
						$current_date = date('Y-m-d', strtotime($request->rate_date)); //date('Y-m-d'); 
						DB::enableQueryLog();
						$hotelseasonrate = HotelSeasonRate::where('start_date','<=', $current_date)
													->where('end_date','>=', $current_date)
													->where('status', 'ACTIVE')
													->where('hotel_id',$Hotel->id)
													->where('room_category_id',$roomcategory->room_type_id)
													->orderBy('id', 'DESC')->first();
						//dd(DB::getQueryLog());
					  $template .= '<tr>
						<td valign="top" align="left" class="'.$classname.'"> 
							'.$roomcategory->type.' ('.$roomcategory->name.') 
						</td>
						<td valign="top" align="center" class="update_price '.$classname.'">
							'.$hotelseasonrate['ep_price'].'
						</td>
						<td valign="top" align="center" class="update_price '.$classname.'">
							'.$hotelseasonrate['cp_price'].'
						</td>
						<td valign="top" align="center" class="update_price '.$classname.'">
							'.$hotelseasonrate['map_price'].'
						</td>
						<td valign="top" align="center" class="update_price '.$classname.'">
							'.$hotelseasonrate['ap_price'].'
						</td>
					  </tr>';
					}
					 
					$template .= '
					<tr>
						<td style="text-align: center;font-size: 12px; padding: 9px 0;"class="'.$classname.'" colspan="5"><b style="color:green">This rate is valid from '.date("d M Y", strtotime($hotelseasonrate['start_date'])).' to '.date("d M Y", strtotime($hotelseasonrate['end_date'])).' Except for New Year, Christmas & Long weekend.</b></td>
					</tr>
					
					</tbody> 
					</table>
				</td>
			  </tr>
			  <tr>
                <td valign="top" align="center" class="'.$classname.'">
					<p>Please click on image for view more images!</p>
					<img alt="Ensober Logo" style="display:block;font-family:Arial, sans-serif;font-size:30px;line-height:34px;color:#000000;margin: 8px 0 15px;width: 85%; box-shadow: 5px 6px 22px 0px rgba(22, 29, 58, 0.36);" src="'.url('/storage/app/'.$Hotel->hotel_image).'" border="0">'; 
					
					foreach($hotelgalleries as $hotelgallery){
						$template .= '<img alt="Ensober Logo" style="display:none;font-family:Arial, sans-serif;font-size:30px;line-height:34px;color:#000000;margin: 8px 0 15px;width: 85%; box-shadow: 5px 6px 22px 0px rgba(22, 29, 58, 0.36);" src="'.url('/storage/app/'.$hotelgallery->image).'" border="0">';
					}
					
				$template .= '</td>
              </tr>
            </tbody>
			</table>';
			
			$c++;}
			$template .= '</td>
        </tr>
		
                 <tr>
          <td style="background-image:url('.url('public/asset/images/icon/BannerMadMimi.png').');height: 215px;background-size: 100% 100%;" valign="top" align="center"></td>
        </tr>

        <tr>
          <td style="padding:38px 30px;border-bottom: 7px solid #9d6116; background-color: #fff;" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody><tr>
                <td style="padding-bottom:16px;" valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody><tr>
                      <td valign="top" align="center"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.url('public/asset/images/icon/f.png').'" alt="fb" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:14px; color:#ffffff; max-width:26px;" width="26" border="0" height="26"></a></td>
                      <td style="width:6px;" width="6">&nbsp;</td>
                      <td valign="top" align="center"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.url('public/asset/images/icon/t.png').'" alt="tw" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:14px; color:#ffffff; max-width:27px;" width="27" border="0" height="26"></a></td>
                      <td style="width:6px;" width="6">&nbsp;</td>
                      <td valign="top" align="center"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.url('public/asset/images/icon/g.jpg').'" alt="yt" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:14px; color:#ffffff; max-width:26px;" width="26" border="0" height="26"></a></td>
                    </tr> 
                  </tbody></table></td> 
              </tr>
              <tr>
                <td style="font-family:Open Sans, Arial, sans-serif; font-size:11px; line-height:18px; color:#999999;" valign="top" align="center"><a href="#" target="_blank" style="color:#999999; text-decoration:underline;">T & C</a> | <a href="#" target="_blank" style="color:#999999; text-decoration:underline;">Privacy Policy</a> | <a href="#" target="_blank" style="color:#999999; text-decoration:underline;">Refund Policy</a><br>
                  © 2019 Ensober . All Rights Reserved .<br>
				  Our Hotels: Corbett Panorama - Jim Corbett, Pine Crest - Bhimtal ( Nainital ) & Hotel Vinayak - Haridwar.</td>
              </tr>
            </tbody></table></td> 
        </tr>
        <tr>
          <td style="line-height:1px;min-width:700px;background-color:#ffffff;"><img alt="" src="images/spacer.gif" style="max-height:1px; min-height:1px; display:block; width:700px; min-width:700px;" width="700" border="0" height="1"></td>
        </tr>
      </tbody></td>
  </tr>
</tbody></table>';

	//$template = "This is a testing!";

	return $template;  
	
	}
	
}
