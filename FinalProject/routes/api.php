<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelController;

use App\Http\Controllers\MapController;

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
Route::get('travel', [TravelController::class, 'getCities']);
Route::post('/travel/add', [TravelCOntroller::class, 'addCities']);
Route::get('/travel/{cmd}', [TravelController::class, 'logout']);

Route::get('/travel/map/{city}', [MapController::class, 'getCityInfo']);
