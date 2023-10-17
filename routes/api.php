<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RateTemplateController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\EventInformationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Register dan Login
Route::apiResource('registers', RegisterController::class)->only('store');
Route::post('/login', [LoginController::class,'login']);

//RateTemplateController
Route::get('/rating', [RateTemplateController::class,'showRates']);

//TemplateController
Route::apiResource('main', TemplateController::class);

//OrderController
Route::apiResource('orders', OrderController::class)->only(['index','show','destroy']);
Route::post('/postOrder/{id}', [OrderController::class,'store']);
Route::get('/showOrderDetail/{order_code}', [OrderController::class,'showDetail']);

//WishController
Route::post('/AddWishIndex', [WishController::class,'index']);
Route::post('/AddWishStore/{id}', [WishController::class,'store']);
Route::post('/AddWishEdit/{id}', [WishController::class,'edit']);
Route::post('/AddWishUpdate/{id}', [WishController::class,'update']);
Route::post('/AddWishDestroy/{id}', [WishController::class,'destroy']);

//EventInformation
Route::get('/event', [EventInformationController::class,'index']);
Route::post('/event/update/{id}', [EventInformationController::class,'update']);
Route::post('/event/delete/{id}', [EventInformationController::class,'destroy']);
// Route::apiResource('eventInformations', EventInformationController::class)->only(['update','index','destroy']);

//VerificationController
Route::post('/Verification/{id}', [VerificationController::class,'update']);

//UserController
Route::post('/UserIndex/{id}', [UserController::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});