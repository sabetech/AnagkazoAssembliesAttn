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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AttendanceController@index');
Route::get('/getpersons', 'AttendanceController@searchPerson');
Route::get('/getcouncils', 'AttendanceController@searchCouncil');
Route::post('postattendance', 'AttendanceController@postAttendance')->name('postAttendance');
Route::get('/attendance_report', 'AttendanceController@attendanceReport')->name('attendanceReport');
Route::post('toggle-form', 'AttendanceController@toggleForm');
//Route::get('/filter_option', 'AttendanceController@filter');
Route::get('/export', 'AttendanceController@exportAttendance');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
