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

Route::get('/', 'Pages@index');
Route::get('admin/login', 'Pages@login');
Route::get('admin/dashboard', 'Pages@dashboard');
Route::get('admin/vidyarthis', 'Pages@vidyarthis');
Route::get('admin/vidyarthis/add', 'Pages@addvidyarthi');
Route::get('admin/vidyarthis/edit/{id}', array('as' => 'admin/vidyarthis/edit', 'uses' => 'Pages@editvidyarthi'));
Route::get('admin/hawans', 'Pages@hawan');
Route::get('admin/hawans/add', 'Pages@addhawan');
Route::get('admin/hawans/edit/{id}', array('as' => 'admin/hawans/edit', 'uses' => 'Pages@edithawan'));
Route::match(['get', 'post'], 'admin/search', 'Pages@search');
Route::match(['get', 'post'], 'admin/add', 'Admins@addadmin');
Route::match(['get', 'post'], 'admin/admins', 'Admins@adminlist');
Route::get('admin/profile/edit/{id}', array('as' => 'admin/profile/edit', 'uses' => 'Admins@editadmin'));
Route::get('admin/setting', 'Pages@settings');
Route::get('admin/help', 'Pages@help');
Route::get('logout', 'Pages@logout');

/*--Ajax Routes--*/
Route::post('ajax', 'Ajax@index');
