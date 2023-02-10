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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/user/availability', 'UserAvailabilityController@store');
    Route::get('/user/availabilities', 'UserAvailabilityController@getUserAvailabilities');
    Route::put('/update', 'UserAvailabilityController@updateAvailability');


});

Route::get('/user/{user_id}/availabilities', 'UserAvailabilityController@getUsersAvailabilities');
Route::get('/search/flights', 'FlightController@searchFlights');
Route::post('/login', 'AuthLoginController@login');
