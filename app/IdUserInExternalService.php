<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdUserInExternalService extends Model
{
    protected $fillable = ['user_id', 'netAngels_id', 'updated_at', 'created_at'];
}
