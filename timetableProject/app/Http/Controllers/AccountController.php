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
        return Account::find($id);
    }

    public function store(Request $request)
    {
        return Account::create($request->validate([
            'ugId' => ['ugId'],
            'fName' => ['fName'],
            'lName' => ['lName'],
            'faculty' => ['faculty'],
            'password' => Hash::make(['password']),
            'department' => ['department'],
            'programme' => ['programme'],
            'active' => 'true',
        ]));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->validate([
            'ugId' => ['ugId'],
            'fName' => ['fName'],
            'lName' => ['lName'],
            'faculty' => ['faculty'],
            'department' => ['department'],
            'programme' => ['programme'],
        ]));

        return $account;
    }

    public function delete(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->validate()([
            'active' => 'false' 
        ]));

        return 204;
    }
}
