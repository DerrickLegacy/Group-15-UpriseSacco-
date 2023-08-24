<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use DB;


class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $members = DB::select('SELECT * FROM members');
     $member_count = DB::select('SELECT * FROM contributions');
     $sum_deposit = 0;
    //  dd($member_count);


     foreach ($member_count as $key => $row) {
        $sum_deposit += (float) $row->client_pledge_cleared;
     }
    //  dd($sum_deposit);
      return view('admin.deposits.index', compact('members', 'member_count', 'sum_deposit'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function register()
   {
        //
   }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
      {
        //
      }

    /**
     * Display the specified resource.
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Deposit $deposit)
    {
        //
    }
}




