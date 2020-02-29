<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;

class TimetableController extends Controller
{


    public function index(Timetable $timetable)
    {
        return Timetable::all();
    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        return Timetable::create($request->validate([
            'aid' => ['aid'],
            'room' => ['room'],
            'course' => ['course'],
            'day' => ['day'],
            'time' => ['time'],
        ]));



    }
    public function update(Request $request, $id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->update($request->validate([
            'aid' => ['aid'],
            'room' => ['room'],
            'course' => ['course'],
            'day' => ['day'],
            'time' => ['time'],
        ]));

        return $Timetable;
    }
    public function delete(Request $request, $id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->update([
            'active' => '0'
        ]);

        return 204;
    }

    public function show($id)
    {
        return Timetable::find($id);
    }
}
