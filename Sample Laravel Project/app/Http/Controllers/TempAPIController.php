<?php

namespace App\Http\Controllers;

use Mail;
use PHPMailer\PHPMailer;
use View;
use Carbon\Carbon;
use App\Lead;
use App\Country;
use App\Region;
use App\City;
use App\Hotel;
use App\Operator;
use App\Contacts;
use App\SendQuotationRate;
use App\PaymentSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\AdminRequest;
use App\HotelSeasonRate;
use App\Transport;
use App\Voucher;
use App\RoomCategory;
use App\HotelGallery;
use App\RoomTypes;
use App\Activity;
use App\ActivityVoucher;
use PDF;
use Storage;
use Log;
use DB;
use DateTime;
use App\FollowupLead;
use App\SendQuotation;
use App\HotelAmenity;
use App\RoomBookedDetails;
use App\RoomInventory;
use App\Vender;
use App\ActivityCat;
use App\AgentContact;
use QrCode;
Use Exception;
use Validator;
use App\Via;
use App\ITIRoute;
use App\ITIBasicInfo;
use App\ITITransport;
use App\ITIHotel;
use App\ITIActivity;
use App\ITIPrice;
use App\ITIDayWiseItinerary;
use App\WebsiteOrder;
use App\WebsiteOrderPayment; 

class TempAPIController extends Controller{
	
	// Get hotel season rate
	public function GetHotelRate(Request $request){
		$validator = Validator::make($request->all(), [
            'checkin'    => 'required',
            'hotel_id'   => 'required',
            'room_type'  => 'required',
        ]);
		
		try{
			$checkin = $request->checkin;
			$hotel_id = $request->hotel_id;
			$room_type = $request->room_type;
			$hotelseasonrate = HotelSeasonRate::where('start_date','<=', $checkin)
						->where('end_date','>=', $checkin)
						->where('status', 'ACTIVE')
						->where('hotel_id',$hotel_id)
						->where('room_type_id',$room_type)
						->orderBy('id', 'DESC')->first();	
			if($hotelseasonrate){ 
				return array('status'=>true,'data'=>$hotelseasonrate);
			}else{
				return array('status'=>false,'data'=>'');
			}
		}catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Error:'.$e);
        }
    }
	
	
	/**
     * Check room availability
     *
     * @param  $request
     * @return Array
     */     
    public function checkHotelRoomAvailablity(Request $request){
        try {
			$hotel_total_rooms = RoomCategory::where('hotel_id', $request->hotel)->where('room_type_id', $request->room_type)->sum('room_count');
			
			$total_room_booked = $this->getTotalRoomBooked($request->hotel, $request->room_type, $request->check_in);
			
			$available_room = $hotel_total_rooms-$total_room_booked;
			if($available_room >= $request->noofrooms){
				echo json_encode(array('status'=>true,'hotel_total_rooms'=>$hotel_total_rooms, 'total_room_booked' => $total_room_booked, 'available_room' => $available_room, 'noofrooms' => $request->noofrooms, 'msg' => ''));
			}else{
				echo json_encode(array('status'=>false,'hotel_total_rooms'=>$hotel_total_rooms, 'total_room_booked' => $total_room_booked, 'available_room' => $available_room, 'noofrooms' => $request->noofrooms, 'msg' => 'Room Not Available For This Date, Total Rooms: '.$hotel_total_rooms.' Total Booked Rooms: '.$total_room_booked));
			}
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	/**
     * Get total room booked
     *
     * @param  $hotel_id, $cat_id, $date
     * @return count
     */     
    public function getTotalRoomBooked($hotel_id, $room_cat_id, $date){
        try {
			DB::enableQueryLog();
            $roomavalable = RoomInventory::where('hotel_id', $hotel_id)->where('room_cat_id', $room_cat_id)->where('date', $date)->where('booking_status','!=','Canceled')->sum('no_of_room');
			return $roomavalable;
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
	
	/**
     * This function use for save the order
     *
     * @param  $request
     * @return $response 
     */     
    public function saveOrder(Request $request){ 
		
        try { 
            $order = new WebsiteOrder();
            $order->order_id = $request->order_id;
            $order->name = $request->name;
            $order->mobile = $request->mobile;
            $order->email = $request->email;
            $order->adult = $request->adult;
            $order->kids = $request->kids;
            $order->infant = $request->infant;
            $order->checkin = $request->checkin;
            $order->checkout = $request->checkout;
            $order->total_room = $request->total_room;
            $order->room_name = $request->room_name;
            $order->meal_plan = $request->meal_plan;
            $order->room_charge = $request->room_charge;
            $order->no_adult = $request->no_adult;
            $order->no_of_kid = $request->no_of_kid;
            $order->no_of_infant = $request->no_of_infant;
            $order->website = $request->website;
            $order->total_amount = $request->total_amount;
            $order->hotel_name = $request->hotel_name;
            $order->status = 'confirmed';
            $order->save();
				
			return response()->json(['status' => 1, 'error' => 0, 'msg' => 'Order save successfully!', 'data' => $order]);
        }catch(Exception $e) {
            return response()->json(['status' => 0, 'error' => 1, 'msg' => $e->getMessage(), 'data' => '']);
        }
    }
	
	
	/**
     * This function use for update the status of order
     *
     * @param  $order_id
     * @return $response
     */     
    public function updateStatusOrder($order_id){
		
        try {
            $order = WebsiteOrder::where('order_id', $order_id)->update(['status' => 'ordered']);
			
			return response()->json(['status' => 1, 'error' => 0, 'msg' => 'Order status updated successfully!',  'data' => $order]);
        }catch(Exception $e) {
            return response()->json(['status' => 0, 'error' => 1, 'msg' => $e->getMessage(), 'data' => '']);
        }
    }
	
	/**
     * This function use for get the order
     *
     * @param  $order_id 
     * @return $response
     */     
    public function getOrder($order_id){ 
		
        try {
            $order = WebsiteOrder::where('order_id', $order_id)->with('orderpayment')->get();
			if($order->count() >= 1){
				return response()->json(['status' => 1, 'error' => 0, 'msg' => 'Order details',  'data' => $order]);
			}else{
				return response()->json(['status' => 0, 'error' => 0, 'msg' => 'Order details',  'data' => $order]); 
			}
        }catch(Exception $e) {
            return response()->json(['status' => 0, 'error' => 1, 'msg' => $e->getMessage(), 'data' => '']);
        }
    }
	
	
	
	/**
     * This function use for save the order payment details
     *
     * @param  $request
     * @return $response
     */     
    public function saveOrderPayment(Request $request){
		
        try {
            $payment = new WebsiteOrderPayment();
            $payment->order_id = $request->order_id;
            $payment->razorpay_payment_id = $request->razorpay_payment_id;
            $payment->amount = $request->amount;
            $payment->save();
			
			// Send email
			$this->sendCofirmationEmail($request->order_id);
			return response()->json(['status' => 1, 'error' => 0, 'msg' => 'Payment save successfully!', 'data' => $payment]);
        }catch(Exception $e) {
            return response()->json(['status' => 0, 'error' => 1, 'msg' => $e->getMessage(), 'data' => '']);
        }
    }
	
	/**
     * This function use for save the order payment details
     *
     * @param  $request
     * @return $response
     */     
    public function sendCofirmationEmail($order_id){
		
        try {
			$order = WebsiteOrder::where('order_id', $order_id)->with('orderpayment')->first();
            // Send Confirmation Email
			$newlead = '<!DOCTYPE html>
						<html>
						<head>
						<style>
						table {
						  font-family: arial, sans-serif;
						  border-collapse: collapse;
						  width: 100%;
						}

						td, th {
						  border: 1px solid #dddddd;
						  text-align: left;
						  padding: 8px;
						}

						tr:nth-child(even) {
						  background-color: #dddddd;
						}
						</style>
						</head>
						<body>
						
						<h2>Booking Details</h2>

						<table>
						  <tr>
							<th>Order Number</th>
							<th>Hotel Name</th>
							<th>CheckIn</th>
							<th>CheckOut</th>
							<th>Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Adult</th>
							<th>Total Amount</th>
							<th>Status</th>
							<th>More Info</th>
						  </tr>';
						  $newlead .= '<tr>
											<td>'.$order->order_id.'</td>
											<td> '.$order->hotel_name.'</td>
											<td> '.$order->checkin.'</td>
											<td> '.$order->checkout.'</td>
											<td> '.$order->name.'</td>
											<td> '.$order->mobile.'</td>
											<td> '.$order->email.'</td>
											<td> '.$order->adult.'</td>
											<td> '.$order->total_amount.'</td>
											<td> Confirmed</td>
											<td>
												<a href="https://corbettking.com/orderinfo.php?order_id='.$order->order_id.'" target="_blank"> Know More </a>
											</td>
										  </tr>';
						$newlead .= '</table>

						</body>
						</html>';
				$subject = 'Thank you for your interest in the Ensober, Order No - '.$order->order_id;
				
				// Send to Customer
				$this->send($newlead, $subject, 'Sales@ensoberhotels.com', $order->email);
				
				// Send to admin
				$this->sendAdmin($newlead, 'New Booking - '.$order->order_id.', '.$order->hotel_name, 'Sales@ensoberhotels.com');
				
			return response()->json(['status' => 1, 'error' => 0, 'msg' => 'Email send successfully!', 'data' => '']);
        }catch(Exception $e) {
            return response()->json(['status' => 0, 'error' => 1, 'msg' => $e->getMessage(), 'data' => '']);
        }
    }
}
