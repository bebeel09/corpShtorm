<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
         'title', 'repeats', 'className', 'user_id', 'start', 'end', 'user_id'
    ];
}
