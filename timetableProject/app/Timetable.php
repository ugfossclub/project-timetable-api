<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
  protected $fillable = [
      'aid', 'room', 'course', 'day', 'time'
  ];

public function accounts()
  {
    return $this->belongsTo('App\Account', 'aid', 'id');
  }
}
