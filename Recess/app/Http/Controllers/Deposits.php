<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Deposits extends Controller
{
    //
}


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;

class DepositController extends Controller
{
    /**
     * Display a listing of the members.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }

    /**
     * Store a newly created member in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ReceiptNumber' => 'required|integer',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'depositPerformance' => 'required|integer',
        ]);

        $member = Member::create([
            'ReceiptNumber' => $request->input('ReceiptNumber'),
            'date' => $request->input('date'),
            'amount' => $request->input('amount'),
            'depositPerformance' => $request->input('depositPerformance'),
        ]);

        return response()->json($member, 201);
    }

    /**
     * Update the specified member in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ReceiptNumber' => 'integer',
            'date' => 'date',
            'amount' => 'numeric',
            'depositPerformance' => 'integer',
        ]);

        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->update($request->all());

        return response()->json($member, 200);
    }

    /**
     * Remove the specified member from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'Member deleted'], 200);
    }
}
