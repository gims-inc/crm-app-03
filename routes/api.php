<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::group(['middleware' => ['auth:sanctum']], function () {

//protected routes


});

Route::post('/payments/set',[PaymentController::class,'callback'])->name('api.v1.callback');

Route::post('/payments/msg',[PaymentController::class,'msg'])->name('api.v1.msg');

        

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
