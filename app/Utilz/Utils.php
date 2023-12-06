<?php

namespace App\Utilz;

use DateTime;
use Exception;


use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Payments;

/*
 *ALL_PROJECT_UTILITIES_TO_RESIDE_HERE
 * 
 * create your static fuction:
 * 
 * public static function staticMethod() {
 *   echo "Hello World!";
 * }
 * 
 * =====Usage=====
 * 
 * Call static method
 * Utils::staticMethod();
 * 
 * Regenerate the Composer autoloader
 * $ composer dump-autoload
 *
 */

class Utils
{
     /*
    * METHOD ONE
    * generate customer account numbers based on their ensures its unique
    * phonenumber-customer primary number
    */
    public static function generateUniqueAccountNumber()
    {
        do {
            $accountNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Account::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }
    
    /*
    * METHOD TWO
    * generate customer account numbers based on their ensures its unique
    * phonenumber-customer primary number
    */

    public static function setAccountNumber($phoneNumber)
    {


        try {
            ((isset($phoneNumber)) && (is_string($phoneNumber)) && strlen($phoneNumber > 9)) ? $phoneNumber : throw new Exception("Invalid string!");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        $formatedNumber = substr($phoneNumber, -9);
        $exists = Account::where('accountNumber', $formatedNumber)->first();
        // if ($exists){
        //     return -1
        // }else{
        //     return $formatedNumber;
        // }

        return (($exists) ? -1 : $formatedNumber);
    }

    /*

    * LOCAL FUNC
    * generate paddded numbers
    * 
    */

    // function generatePaddedNumber($number, $length)
    // {

    //     $numberStr = (string) $number;

    //     // Calculate the number of zeros to pad
    //     $zerosToPad = $length - strlen($numberStr);

    //     // Pad the number with zeros to the desired length
    //     $paddedNumber = str_pad($numberStr, $length, '0', STR_PAD_LEFT);

    //     return $paddedNumber;
    // }

    /*

    *
    * generate product serial numbers
    * ProductName lamp/battery
    */

    public static function setSerialNumber($productName = 'Battery', $len = 6)
    { //To Test Output

        $productCount = Product::where('productName', $productName)->count();

        $productCount += 1;

        $numberStr = (string) $productCount;

        $zerosToPad = $len - strlen($numberStr);

        $paddedNumber = str_pad(
            $numberStr,
            $len,
            '0',
            STR_PAD_LEFT
        );

        $prefix = strtoupper(substr($productName, 0, 3));

        // return $prefix . '-' . $paddedNumber;
        return $paddedNumber;
    }

    /*
    * description
    * set the Batch Number
    * 
    */
    public static function setBatchNumber()
    {

        $currentDateTime = new DateTime(); // Get the current date and time

        $batchNumber = $currentDateTime->format('Ymd'); // Format as YYYYMMDD

        return $batchNumber; // Output: 20230822 (example)

    }

    
    /*
    * description
    * 
    */
    public static function setSerialNumberTwo()
    {
        $currentDateTime = new DateTime(); // Get the current date and time

        $batchNumber = $currentDateTime->format('Ymd'); // Format as YYYYMMDD

        // Remove the first two numbers and replace them with "CPL"
        $batchNumber = 'CPL-' . substr($batchNumber, 2);

        // Add the current time in HHMM format
        $batchNumber .= $currentDateTime->format('Hi');

        return $batchNumber; // Output: CPL-231023 (example, assuming the time is 10:23)
    }

 
    

    /*
    * description
    * 
    */
    public static function itemFilter($entity)
    {

        return 0;
    }


    /*
    * description
    * 
    */
    public static function getRemainingDays($accountNumber)
    {
       
    }

    /*
    * description
    * 
    */
    public static function getRemainingAmount($accountNumber)
    {
       
    }



    /*
    * decription
    *https://blade-ui-kit.com/blade-icons?set=1#search
    */
}
