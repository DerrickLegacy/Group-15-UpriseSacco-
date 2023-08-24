<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function update(Request $request){
        $id = $request->input('client_id');
        $interest = $request->input('interest');
        $payment_period = $request->input('payment_period');
        $start_date = $request->input('start_date');
        $loan_application_no = $request->input('loan_application_no');

        // dd($request);
        DB::update('update loan set grant_status = ? , interest_rate = ?, payment_period = ?, start_date = ? where client_id = ? and loan_application_no = ? ', ['Granted',$interest, $payment_period, $start_date, $id,  $loan_application_no ]);
        return redirect('admin/requests');
    }
}
