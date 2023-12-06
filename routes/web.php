<?php

use App\Livewire\ManageProduct;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('accounts/{account}/manage', ManageAccount::class);
Route::post('/payments/set',[PaymentController::class,'callback'])->name('callback');

Route::post('/payments/msg',[PaymentController::class,'msg'])->name('msg');