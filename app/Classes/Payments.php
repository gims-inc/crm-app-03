<?php


namespace App\Classes;

define("ORG_NAME", "Orgarnisation Name");

use App\Models\Account;
// use App\Models\User;
// use App\Models\Product;
use App\Models\Package;
// use App\Models\Customer;
use App\Models\Payment;

use App\Classes\CustomerToken;
use  App\Classes\Smsser;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Payments{

    public $props = ([
            'amount' => '',
            'phone' => '',
            'trans_id' => '',
            'tt' => '',     // transactionTime
            'name' => '',
            'acn' => ''     // accountNumber
        ]);
   
    // private  $serialNumber;
    
    private  $metaJson;
    private  ?string $metaStr = null;
    private  string $type; //msg, callback
    private Account $account;
    private Package $package;
    private $serialNumber;
    private  $customerToken;
    private  $units;
    private  $balance;

    //balance from units calculation

    public function __construct($data, string $paymentType) { 
        
        $this->props = $this->setPaymentProperties($data, $paymentType);

        $this->account = $this->setAccount($this->props['acn']); // will this even work (:

        $this->package = $this->account->package; //from the model rlshnships

        $this->type = $paymentType;

        if ($this->type === 'msg'){

            $this->metaStr = $data['msg']; //SMS
            $this->metaJson = '';
        }
        
        if ($this->type === 'callback'){

            $this->metaStr = ''; //SMS
            $this->metaJson = json_encode($data);
        }
       
        $this->serialNumber = $this->account->product->serial_number; 

        // dd($this->serialNumber); //we good
        
        $this->balance  = $this->setNewBalance();

        $this->customerToken = $this->setCustomerToken();
        
        $this->units = $this->setUnits();

    }

    /*
    * description
    * 
    */

    private function setAccount($number): Account
    {
        $account = Account::where('account_number',$number)->first();
         return $account;
    }


    /*
    * description
    * 
    */
    public function setPaymentProperties($data, $paymentType){

    // dd($data);

    //---------------------------------------------------
    //  {    
    //     "TransactionType": "Pay Bill",
    //     "TransID":"RKTQDM7W6S",
    //     "TransTime":"20191122063845",
    //     "TransAmount":"10"
    //     "BusinessShortCode": "600638",
    //     "BillRefNumber":"invoice008",
    //     "InvoiceNumber":"",
    //     "OrgAccountBalance":""
    //     "ThirdPartyTransID": "",
    //     "MSISDN":"25470****149",
    //     "FirstName":"John",
    //     "MiddleName":""
    //     "LastName":"Doe"
    //  }

    //---------------------------------------------------
    // {
    //     "msg"=>"MPESA/equitel message string",
    // }


        

        if ($paymentType === 'msg'){ //MPESA message --SMS
            //set
            $message = $data['msg'];

            //ToDo msg processor

        }

        if ($paymentType === 'callback'){ //paymentAPIhandler

            //set

            // $transactionType = $data['TransactionType'];
            $transID = $data['TransID'];
            $transTime = $data['TransTime'];
            $transAmount = $data['TransAmount'];
            $businessShortCode = $data['BusinessShortCode'];
            $billRefNumber = $data['BillRefNumber'];
            // $invoiceNumber = $data['InvoiceNumber'];
            // $orgAccountBalance = $data['OrgAccountBalance'];
            // $thirdPartyTransID = $data['ThirdPartyTransID'];
            $msisdn = $data['MSISDN'];
            $firstName = $data['FirstName'];
            $middleName = $data['MiddleName'];
            $lastName = $data['LastName'];


           return $this->props = ([
            'amount' => $transAmount,
            'phone' =>   $msisdn,
            'trans_id' => $transID,
            'tt' =>  $transTime, //transactionTime
            'name' => $firstName." ".$lastName,
            'acn' => $billRefNumber,  //accountNumber
            ]);

        }
      
    }

    //ToDo Refactor

    /*
    * Lets say daily amount is 100 and customer pays 130,
    * what happens to the 30!?
    * Get the balance from the curren payment to be used with the next payment
    * from the units -- daily amount remainder
    */ 
    private function setNewBalance(){   //ToDo get old balance and add to amount

        $previousBalance = 0;  // get balance from the last payment record

        $lastpayment = Payment::where('account_number', $this->props['acn'])
                                ->latest('created_at')
                                ->first();

        // $previousBalance = ($lastpayment)? $lastpayment->balance : 0 ;

        $previousBalance = $lastpayment->balance ?? 0 ;

        $operatingAmount = (int)$this->props['amount'] + (int)$previousBalance;

        $currentBalance = ( $operatingAmount % (int)$this->package->daily_payment); //fmod(19,5.5);

        return $currentBalance;
    }


    private function setUnits(){

        $previousBalance = 0;  // get balance from the last payment record

        $lastpayment = Payment::where('account_number', $this->props['acn'])
                                ->latest('created_at')
                                ->first();

        $previousBalance = ($lastpayment)? $lastpayment->balance : 0 ;

        $operatingAmount = (int)$this->props['amount'] +  (int)$previousBalance;   

        $dividend = $operatingAmount;

        $divisor = (int)$this->package->daily_payment;
        
        $units = intdiv($dividend, $divisor); //floor($this->amount / $this->dailyAmount);

        return $units;
    }


    /*
    * 
    * use customertoken class to get a token for the account
    * queue the token to be sent to the customer
    *
    */
    public function setCustomerToken():string
    {

        $fieldObj = ([
            "amount"=>$this->props['amount'],
            "units"=>$this->units,
            "serial"=>$this->props['acn'],  // ?? serialNumber
        ]);//sample api request body

        $bodyData = json_encode($fieldObj);

        $apiCall = new CustomerToken();

        $resp = $apiCall->callAPI('POST', $bodyData); //ToDo define what happens if the recharge is declined

        //ToDo log resp

        return $resp['Recharge'];
    }

    /*
    *
    * 
    * Send Token to Customer
    */ 
    public function sendToken(){

        $msg = sprintf(".ORG_NAME.,\nToken for account number: %s. Token: %s.", $this->props['acn'], $this->customerToken);  //ToDo Token body  

        $sender = new Smsser();

        $sender->sendMessage($this->props['phone'], $msg); 
    }

     /*
    * description
    * 
    * account ?? customer ?? product ?? token
    * Token not assigned,
    * 
    */ 
    public function setIsResolved(){
        //Todo conditions for unresolved payments
        
        return true;
    }

    /*
    * description
    * 
    */
    public function storePayment()
    { // await token  and store the payment
        //ToDo fix payment migration file

       $newPayment = Payment::create([

            'amount'=> $this->props['amount'],
            'transaction_time'=> $this->props['tt'],
            'transaction_id'=> $this->props[''],
            'account_number'=> $this->props['acn'],
            'phone_number'=> $this->props['phone'],
            'name'=> $this->props['name'],
            'meta'=> $this->metaJson,
            'msg'=> $this->metaStr,
            'token_value'=> $this->customerToken,
            'balance'=> $this->balance,
            'units'=> $this->units,

            ]);

        return $newPayment;
    }

    /*
    * description
    * 
    * Get all payments for a specific account
    */ 
    public function getPayment(){
        // return $this->account::where('user_id',$id)->get();
        return $this->account->payments->paginate();
    }
  

}
