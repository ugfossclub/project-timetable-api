<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;

class TimetableController extends Controller
{


    public function index(Timetable $timetable)
    {

        $timetable=App\Timetable::all();
        dd($timetable);
    }

    public function create()
    {

    }


    public function store()
    {

        $request = new Timetable();
        $request->room=request('');
        $request->course = request('');
        $request->day = request('');
        $request->time= request('');
        $request->save()
        


    }
    public function update()
    {

    }
    public function delete()
    {

    }

    public function show()
    {

    }
}
