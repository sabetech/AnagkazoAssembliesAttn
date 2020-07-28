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
Route::post('toggle-form-basic', 'AttendanceController@toggleForm');
Route::post('council/toggle-form-council', 'CouncilAttendanceController@toggleForm');
//Route::get('/filter_option', 'AttendanceController@filter');
Route::post('/export', 'AttendanceController@exportAttendance');
Route::post('/council/export-council', 'CouncilAttendanceController@export');



///Councils ...
Route::get('/council/bantama', function () {
    return redirect()->route('council_attendance_form', 3);
});

Route::get('/council/ofaakor', function () {
    return redirect()->route('council_attendance_form', 5);
});

Route::get('/council/ayeduase', function () {
    return redirect()->route('council_attendance_form', 7);
});

Route::Get('/council/bouake', function () {
    return redirect()->route('council_attendance_form', 12);
});

Route::Get('/council/burkina', function () {
    return redirect()->route('council_attendance_form', 11);
});

Route::Get('/council/santa-maria', function () {
    return redirect()->route('council_attendance_form', 8);
});

Route::Get('/council/awoshie', function () {
    return redirect()->route('council_attendance_form', 2);
});

Route::Get('/council/bingerville', function () {
    return redirect()->route('council_attendance_form', 10);
});

Route::Get('/council/nyanyanor', function () {
    return redirect()->route('council_attendance_form', 4);
});

Route::Get('/council/yopougon', function () {
    return redirect()->route('council_attendance_form', 13);
});

Route::Get('/council/divo', function () {
    return redirect()->route('council_attendance_form', 14);
});

Route::Get('/council/india', function () {
    return redirect()->route('council_attendance_form', 15);
});

Route::Get('/council/asokwa', function () {
    return redirect()->route('council_attendance_form', 9);
});

Route::Get('/council/abeka', function () {
    return redirect()->route('council_attendance_form', 1);
});

Route::Get('/council/sowutuom', function () {
    return redirect()->route('council_attendance_form', 6);
});


Route::get('/council/report', 'CouncilAttendanceController@report');
Route::get('/council/{id}', 'CouncilAttendanceController@getCouncilForm')->name('council_attendance_form');




Route::get('/getbranches', 'CouncilAttendanceController@getBranches');
Route::get('/getpastors', 'CouncilAttendanceController@getPastors');
Route::get('/shepherds', 'CouncilAttendanceController@getShepherds');

Route::post('postCouncilAttendance', 'CouncilAttendanceController@postCouncilAttendance')
    ->name('postCouncilAttendance');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
