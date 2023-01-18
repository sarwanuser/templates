<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontend

Route::get('/', function () {
    return view('welcome');
});

// clear cache
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
    return "<h1 style='text-align: center;'>!!Cache cleared successfully!</h1>";
});

// Get the current database connection info
Route::get('/artisan-database', function() {
	try {
		print_r('databse name= '.DB::connection()->getDatabaseName());
	} catch (\Exception $e) {
		die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

Route::get('testpdf/', 'ItineraryController@downloadSendQuotation');

Route::get('/viewhotel/{id}', 'CommanController@viewHotel');


// Hotel

Route::get('/admin', 'AdminController@index');

Route::post('/admin/login/action', 'AdminController@adminLogin');


// clear cache
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');   
    return "<h1 style='text-align: center;'>Cache cleared successfully !</h1>";
});


