<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\MapController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/travel', [TravelController::class, 'index']);
Route::post('/travel/add', [TravelCOntroller::class, 'addCities']);

Route::get('/travel/logout', [TravelController::class, 'logout']);
Route::get("/room",[RoomController::class,'index']);

Route::get('/travel/map/{city}', [MapController::class, 'getMap']);

