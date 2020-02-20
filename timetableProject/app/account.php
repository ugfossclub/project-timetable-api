<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'ugId','fName', 'lName', 'faculty', 'password', 'department', 'programme', 'active'
    ];

    public function timetable()
    {
        return $this->hasOne('App\Timetable', 'aid', 'id');
    }
}
