<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebControllers\Vehicles\VehicleController;
use App\Http\Controllers\WebControllers\Vehicles\CategoryController;

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

Route::get('/', [VehicleController::class,'index'])->name('home');

Auth::routes();

//route group
//check if the user is authenticated and pass xss sanitazation when sending request
Route::group(['middleware' => ['auth','XssSanitizer']], function()
{
    Route::get('/home', [VehicleController::class,'index'])->name('home');
    Route::resource('/vehicle', VehicleController::class); 
    Route::get('/vehiclelist',[VehicleController::class,'getList']);
    Route::get('vehicle/delete/{id}', [VehicleController::class,'destroy'])->name('vehicle-delete');
    Route::resource('/category', CategoryController::class); 
    Route::get('/categorylist',[CategoryController::class,'getList']);
    Route::get('category/delete/{id}', [CategoryController::class,'destroy'])->name('category-delete');
});

