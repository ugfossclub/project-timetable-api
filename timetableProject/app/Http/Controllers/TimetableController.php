<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;

class TimetableController extends Controller
{


    public function index(Timetable $timetable)
    {
        return Account::all();
    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        return Account::create($request->validate([
            'aid' => ['aid'],
            'room' => ['room'],
            'course' => ['course'],
            'day' => ['day'],
            'time' => ['time'],
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
    public function delete( $account = Account::findOrFail($id);
        $account->update($request->validate()([
            'active' => 'false' 
        ]));

        return 204;)
    {
        $account = Account::findOrFail($id);
        $account->update($request->validate()([
            'active' => 'false'
        ]));

        return 204;
    }

    public function show($id)
    {
        return Account::find($id);
    }
}
