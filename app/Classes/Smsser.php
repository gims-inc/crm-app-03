<?php


namespace App\Classes;

use App\Models\Account;
use App\Models\Customer;

class Smsser{

    private $apiKey = null; 
    
    // To Do --set default account id for testing purposes.   
 
    
    public function __construct(){
        $this->apiKey = '1234567890';  //Your API Key from smsgate
    }


        private function sendSMS($to, $message){
            $url = "http://smsgateway.com/send";
            
            $data=array(
                'user' => "your_username",   // Your Username
                'passwd'=>"your_password",   // Password
                'from' => "SenderID",       // The sender ID that you have entered on the gateway
                'to' => "$to",             // Phone number to which message is sent
                'text' => "$message");      // Message content

                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);

                return $result;
        }


        public  function sendMessage($phoneNumber,$msg) { 
           //ToDo queue on failure
           return self::sendSMS($phoneNumber, $msg); //we shal see

        }

        

}