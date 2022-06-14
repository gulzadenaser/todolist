<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\Vehicles\VehicleController;
use App\Http\Controllers\ApiControllers\Vehicles\CategoryController;
use App\Http\Controllers\ApiControllers\PassportAuthController;
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
//register user through API and login to get the token value
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
//check if the request is authenticated through API with valid token, and sanitize all user inputs
Route::group(['middleware' => ['auth:api', 'XssSanitizer']],function(){
  Route::resource('vehicle', VehicleController::class,['as'=>'api']);
  Route::resource('category', CategoryController::class,['as'=>'api']);
});