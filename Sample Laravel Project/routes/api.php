<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

// For visiting card save
Route::post('/saveVisitingCard', 'OperatorController@saveVisitingCard');
Route::get('/scanvisitingcard', 'OperatorController@sendHotelRateByCardPic');

// Temp APIs for corbettking.com
Route::post('/gethotelrate', 'TempAPIController@GetHotelRate');
Route::post('/gethotelroomavailablity', 'TempAPIController@checkHotelRoomAvailablity');

// Save website order
Route::post('/saveorder', 'TempAPIController@saveOrder');
Route::get('/updatestatusorder/{order_id}', 'TempAPIController@updateStatusOrder');
Route::get('/getorder/{order_id}', 'TempAPIController@getOrder');
Route::get('/sendcorfirmation/{order_id}', 'TempAPIController@sendCofirmationEmail');

// Website Payment
Route::post('/savepayment', 'TempAPIController@saveOrderPayment');
