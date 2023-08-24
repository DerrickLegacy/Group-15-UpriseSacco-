<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'username' => ['required', 'min:3', Rule::unique('members', 'username')],
            'phone_number' => ['required', Rule::unique('members', 'phone_number')],
            'password' => 'required|confirmed|min:6'
        ]);


        Member::create([
            'clientName' => $request->clientName,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ]);

        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('admin.members.show')->with('member', $member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit')->with('member', $member);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {


        $request->validate([
            'username' => ['required', 'min:3', Rule::unique('members', 'username')],
            'phone_number' => ['required', Rule::unique('members', 'phone_number')],
            'password' => 'required|confirmed|min:6'
        ]);

        $member->upate([
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => ($request->password)
        ]);

        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect('/admin/members');
    }
}