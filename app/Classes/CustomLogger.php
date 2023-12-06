<?php

namespace App\Classes;


use App\Models\CustomerLog;
use Illuminate\Support\Facades\DB;

class CustomLogger {


    // public function __construct(){

    // }


    public static function customlogger($entityId, $action){

        DB::table('sys_logs')->insert([
            'id'=> $entityId,
            'logged_at' => date("Y-m-d H:i:s"),
            'action' => $action
            ]);
    }

    public static function acountlogger($account_id, $action){

        DB::table('account_logs')->insert([
            'account_id' => $account_id,
            'logged_at' => date("Y-m-d H:i:s"),
            'action' => $action
            ]);
    }

    public static function customerLog($customer_id, $action){

        DB::table('customer_logs')->insert([
            'customer_id' => $customer_id,
            'logged_at' => date("Y-m-d H:i:s"),
            'action' => $action
            ]);
    }

}
