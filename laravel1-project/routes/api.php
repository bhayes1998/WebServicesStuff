<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Weather;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoOAuthController;

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
