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
use App\Http\Controllers\PaymentController;


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
Route::apiResource('main', TemplateController::class)->only(['index', 'show', 'destroy']);
Route::post('/postTemplate', [TemplateController::class, 'store']);
Route::post('/updateTemplate/{id}', [TemplateController::class, 'update']);

//OrderController
Route::apiResource('orders', OrderController::class)->only(['index','show','destroy']);
Route::post('/postOrder/{id}', [OrderController::class,'store']);
Route::get('/showOrderDetail/{order_code}', [OrderController::class,'showDetail']);

//WishController
Route::apiResource('/wishes', WishController::class)->only('index','show','update','destroy');
Route::post('/AddWish/{id}', [WishController::class,'store']);

//EventInformation
Route::get('/event', [EventInformationController::class,'index']);
Route::post('/event/update/{id}', [EventInformationController::class,'update']);
// Route::apiResource('eventInformations', EventInformationController::class)->only(['update','index','destroy']);

//VerificationController
Route::post('/Verification/{id}', [VerificationController::class,'update']);

//PaymentController
Route::post('/webhook/midtrans', [PaymentController::class,'webhook']);

//UserController
Route::post('/UserIndex/{order_id}', [UserController::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});