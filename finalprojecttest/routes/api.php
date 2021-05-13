<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Weather;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoOAuthController;
use App\Http\Controllers\S3;
use App\Http\Controllers\TravelController;

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
Route::post('weather/{zipcode}', [Weather::class, 'index']);
Route::get('todo/', [TodoController::class, 'index']);
Route::get('todo/{token}/{projectID}', [TodoOAuthController::class, 'projects']);
Route::get('todoistoauth/{cmd}', [TodoOAuthController::class, 'logout']);
Route::get('s3', [S3::class, 'getBucket']);
Route::put('s3', [S3::class, 'putBucket']);
Route::get('travel', [TravelController::class, 'index']);

