<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class Admin extends Authenticatable
{

      use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

     protected $guarded = ['id'];

     protected $guard = "admin-web";


    public function setting() {
        return $this->morphOne('\App\Models\PersonalSetting','belong');
    }


    public function userHasRole($role_name)
    {
        if($this->roles()->whereName($role_name)->first()!=null){
            return true;
        }
        return false;
    }
}
