<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsLoggedIn;
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

// Login Page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/index1', function () {
    return view('admin.index1');
});

// Login
Route::POST('/login', 'Auth\loginController@login');

Route::middleware([IsLoggedIn::class])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', 'Admin\AdminController@dashboard');

    // Registration By Admin
    Route::get('/admin/emp-registration', 'Auth\RegistrationController@index');
    Route::POST('/admin/new-emp-registration', 'Auth\RegistrationController@store');

    //  Allready Registered Employees
    Route::get('/admin/all-employee', 'Auth\RegistrationController@view');
    Route::get('/admin/edit-employee-{id}', 'Auth\RegistrationController@edit');
    Route::POST('/admin/update-employee-{id}', 'Auth\RegistrationController@update');
    Route::get('/admin/delete-employee-{id}', 'Auth\RegistrationController@delete');
    // Route::get('/admin/update-employee-{id}', 'Auth\RegistrationController@update');

    // show attendance by admin
    Route::get('/admin/attendance', 'Admin\AttendanceController@attendance');

    // Work Rating by admin
    Route::get('/admin/workRating', 'Admin\RatingController@rate');

    // Send request for Work Rating by admin to Client
    Route::get('/admin/request_workRating', 'Admin\WeeklyRatingController@RequestForRate');
    // Route::get('/admin/request_workRating_{id}', 'Admin\WeeklyRatingController@RequestForRate');

    // Add Client by admin
    Route::get('/admin/add-Client', 'Admin\ClientController@create');
    Route::POST('/admin/add-new-client', 'Admin\ClientController@store');

    // view, edit, update, delete the details of Client
    Route::get('/admin/all-Clients', 'Admin\ClientController@index');
    Route::get('/admin/edit-client-{id}', 'Admin\ClientController@edit');
    Route::POST('/admin/update-client-{id}', 'Admin\ClientController@update');
    Route::get('/admin/delete-client-{id}', 'Admin\ClientController@delete');

    // view page for Add Projects
    Route::get('/admin/add-projects', 'Admin\ProjectController@create');
    Route::POST('/admin/add-new-project', 'Admin\ProjectController@store');

    // view, edit, update, delete the details of Project
    Route::get('/admin/all-projects', 'Admin\ProjectController@index');
    Route::get('/admin/edit-project-{id}', 'Admin\ProjectController@edit');
    Route::POST('/admin/update-project-{id}', 'Admin\ProjectController@update');
    Route::get('/admin/delete-project-{id}', 'Admin\ProjectController@delete');



    // logout
    Route::POST('/logout', 'Auth\logOutController@logout');



    // Codes for Employees
    Route::get('/dashboard', 'User\UserController@welcome');
    Route::get('/presonal-information', 'User\UserController@PersonalInfo');
    // update Personal-Email or personal-mobile by 
    Route::get('/update_emp_details', 'User\UserController@UpdatePersonalInfo');
    
    
    // check-in
    Route::get('/check-in', 'User\AttendanceController@checkIn');
    
    // check-out
    Route::get('/check-out', 'User\AttendanceController@checkOut');

    // getTimer
    Route::get('/getTimer', 'User\AttendanceController@getTimer');

    
    // check users All attendance
    Route::get('/attendence/details', 'User\AttendanceController@attendance');
});




// client Handel
// Client Rating
    Route::get('/rate-to-employe-{id}', 'Client\ClientController@index');
    Route::POST('/client/send-weekly-rating', 'Client\ClientController@SendWeeklyRating');
