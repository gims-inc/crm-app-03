<?php

namespace App\Classes;

use App\Models\Account;
use App\Models\User;
use App\Models\Product;
use App\Models\Package;
use App\Models\Customer;

use Illuminate\Support\Facades\Session;

class AccMgr{


    /*
     * Manage accounts
     * Assign Products to accounts
     * Reconcile payments vs packages
     * get -days left,amount paid, remaining balance,days left
     * 
     * 
    */

    // public $accountNumber;

     /*
    * description
    * 
    */
    public static function setAccStatus($accountNumber, $newStatus){
        //[pending,active,inactive,suspended,closed]
        try {

        $account = Account::find($accountNumber);//use where

        if ($account) {
            // Update the status
                $account->status = $newStatus;
            // Save the changes to the database
                $account->save(); 
                //ToDo log activity on customer
            }

            return 0;
        } catch (\Exception $e) {
            // Handle the exception here
            return 'Error: ' . $e->getMessage();
        }
    }

     /*
    * description
    * 
    */
    public static function assignProduct($accountNumber, $productId){

        try {

            //ToDo log activity on customer/product
            // add product id to account
            // change product whereat to field.

            // $account = Account::find($accountNumber);

            // // check if product is already assigned to another account and notify:
            // $available = Account::where('productId',$productId)->exists();

            // //decline notification logic based on $available 
            // if ($available || is_null($account)) {
            //     Session::flash('error', 'Product assignment failed. The product is already assigned to another account!');
            //     return 'Error: ' . $e->getMessage();
            // } else{
            //     $account->productId=$productId;
            //     $account->save();
            //     Session::flash('success','Product added successfully');
            // }
                
            $account = Account::find($accountNumber);

            // Check if the product is already assigned to another account
            $existingAccount = Account::where('product_id', $productId)->first();

            if ($existingAccount) {
                Session::flash('error', 'Product assignment failed. The product is already assigned to another account!');
                return 'Error: Product is already assigned to another account.';
            }

            if (is_null($account)) {
                Session::flash('error', 'Account not found.');
                return 'Error: Account not found.';
            }

            // If we reach this point, the product can be assigned to the account
            $account->productId = $productId;
            $account->save();
            Session::flash('success', 'Product added successfully');

            return 0;
        } catch (\Exception $e) {
            // Handle the exception here
            // Session::flash('error', 'Product assignment failed. The product is already assigned to another account!');
            //\Log::error('Product assignment failed: ' . $e->getMessage());
            
            return 'Error: ' . $e->getMessage();

        }

    }

     /*
    * description
    * 
    */
    public static function assignPackage($accountNumber, $packageId){

        try {

            //ToDo log activity on customer/account
            // add package id to the product

            $account = Account::find($accountNumber);

            if ($account) {
                // Update the status
                    $account->package_id = $packageId;
                // Save the changes to the database
                    $account->save(); 
                    //ToDo log activity on customer
                }

            
            // if ($someErrorCondition) {
            //     throw new Exception('An error occurred while assigning the package.');
            // }
            
            // If everything is successful, return a success message or data.
            return 0;
        } catch (\Exception $e) {
            // Handle the exception here
            return 'Error: ' . $e->getMessage();
        }

    }

    // \Log::error('Product creation failed: ' . $e->getMessage());

}