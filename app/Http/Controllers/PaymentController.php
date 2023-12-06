<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use  App\Classes\Payments;
use App\Models\Payment;

class PaymentController extends Controller
{

    //To Do limit acces to only the sms forwader and the external payments api
    //midddleware etc


    /*
    * All Payment Records
    *
    */
    public function index(Request $request){
        // return Payment::all()->paginate();
    }


    /*
    * provide endpoints/url callbacks for incoming payment data 
    *
    */

    public function callback(Request $request){

        // Route::post('/payments/set',[App\Http\Controllers\API\V1\PaymentController::class,'callback'])->name('api.v1.callback');

        // Route::get('/payments/{id}/verify', [App\Http\Controllers\API\V1\PaymentController::class, 'verifyPayment'])->name('api.v1.payments.verify');

        $data = $request->all();

        //ToDo check if account exists if nont log it and return 
        //uresolved payments
        //account status --get tokens only for active accounts

     
        $newPayment = new Payments($data, 'callback');

        //Processing via Payemnts Clas
        dd($newPayment->props['name']); // we good

        // $newPayment->sendToken(); Under Development

        $newPayment->storePayment();

    }
    

    /*
    * provide endpoints/url callbacks for incoming payment data 
    *
    */

    public function msg(Request $request){

        // Route::post('/payments/msg',[App\Http\Controllers\API\V1\PaymentController::class,'msg'])->name('api.v1.msg');
        
        $data = $request->all();


        $newPayment = new Payments($data,'msg');

        //Processing via Payemnts Class
        $newPayment->storePayment();

    }



}
