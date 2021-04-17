<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API authenticate
Route::post('login', 'UserLoginController@userLogin');
Route::post('logout', 'UserLoginController@logout');


// API frontoffice
Route::post('enterParking', 'ParkingController@enterParking');
Route::put('exitParking', 'ParkingController@exitParking');
Route::get('getPayment/{id}', 'ParkingController@getPaymentByNoPayment');

//API Chart
Route::get('getDataPerMonth', 'ChartController@getDataPerMonth');
Route::get('getDataPerDay', 'ChartController@getDataPerDay');
Route::get('getDataPerYear', 'ChartController@getDataPerYear');

// API Report
Route::get('getDataReport', 'ReportController@getDataReport');
Route::post('getDataReportWithFilter', 'ReportController@getDataReportWithFilter');
Route::get('getDataReportActive', 'ReportController@getDataReportActive');
