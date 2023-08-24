<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RegisterDepositController extends Controller
{
    public function register_depo(Request $request){
        // $client_name = $request->input('client_name');
        $client_id = $request->input('client_id');
        $deposit_amount = $request->input('deposit_amount');
        $receiptNumber = $request->input('receiptNumber');
        $date = $request->input('date');
        // dd($receiptNumber);


        DB::insert('insert into contributions (receipt_no, client_id, client_pledge_cleared, deposit_date) values (?, ?, ?, ?)', [$receiptNumber, $client_id, $deposit_amount, $date]);
        return redirect('admin/deposits');
    }
}
