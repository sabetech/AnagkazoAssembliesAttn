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

//use Illuminate\Routing\Route;

Route::get('/', 'AttendanceController@index');
Route::get('/getpersons', 'AttendanceController@searchPerson');
Route::get('/getcouncils', 'AttendanceController@searchCouncil');
Route::post('postattendance', 'AttendanceController@postAttendance')->name('postAttendance');
Route::get('/attendance_report', 'AttendanceController@attendanceReport')->name('attendanceReport');
Route::post('toggle-form', 'AttendanceController@toggleForm');
//Route::get('/filter_option', 'AttendanceController@filter');
Route::post('/export', 'AttendanceController@exportAttendance');



///Councils ...
Route::get('/council/{id}', 'CouncilAttendanceController@getCouncilForm');

// Route::get('/ofaakor', 'CouncilAttendanceController@ofaakor');
// Route::get('/bantama', 'CouncilAttendanceController@bantama');



Route::get('/getbranches', 'CouncilAttendanceController@getBranches');
Route::get('/getpastors', 'CouncilAttendanceController@getPastors');
Route::get('/shepherds', 'CouncilAttendanceController@getShepherds');

Route::post('postCouncilAttendance', 'CouncilAttendanceController@postCouncilAttendance')
    ->name('postCouncilAttendance');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
