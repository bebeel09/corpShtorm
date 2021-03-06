<?php

namespace App;

use App\Http\Traits\HasPermissionsTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'sur_name', 'birthday', 'last_name', 'name', 'email', 'login', 'password', 'mobile_phone', 'work_phone', 'office_id', 'department_id', 'position', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function office()
    {
        return $this->belongsTo(Office::class);
    }


    public function department()
    {
        return $this->belongsTo(department::class);
    }

}
