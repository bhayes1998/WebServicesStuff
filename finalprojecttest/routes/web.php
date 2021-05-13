<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TodoOAuthController;
use App\Http\Controllers\TravelController;

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

Route::get('/about',function() {
	$d['name'] = "hayesbm3";
	$d['data'] = array();
	for ($i=0;$i<10;$i++) {
		array_push($d['data'],rand(0,100));
	}
	return view('about',$d);
});

Route::get('travel', function () {
    return view('travel');
});


Route::get("/room",[RoomController::class,'index']);
Route::get("/todo",function () {
	return view('todo');
});
Route::get("/todoistoauth", [TodoOAuthController::class, 'index']);
Route::get('/room/add', [RoomController::class,'add']);
Route::post('/room/add', [RoomController::class, 'addRoom']);
Route::get('todoistoauth/logout', [TodoOAuthController::class, 'logout']);
Route::get('s3', function() { return view('s3');});
Route::get('chart', function() { return view('chart');});
Route::get('travel/logout', [TravelController::class, 'logout']);
