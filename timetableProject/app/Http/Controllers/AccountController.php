<?php

namespace App\Http\Controllers;

use App\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Account::all();
    }


    public function show($id)
    {
        $account = Account::find($id);
        return response()->json($account, 200);
    }

    public function store(Request $request)
    {
        return Account::create($request->only('ugId', 'fName', 'lName', 'faculty', 'password', 'department', 'programme', 'active'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->only('ugId', 'fName', 'lName', 'faculty', 'password', 'department', 'programme'));
        return $account;
    }

    public function delete(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->update([
            'active' => '0'
        ]);

        return 204;
    }
}
