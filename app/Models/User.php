<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    
    public static function encrypter($data){
        $data =    json_encode($data);
        $cipher = "aes-256-cbc"; 
        $encryption_key = "3ae8a1c1cf412b27ecd7a87db49f830d";  
        $iv = "a4f051fdf0e638c5"; 
        $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 
        return $encrypted_data;
     }

     public static function decrypter($data){
        $cipher = "aes-256-cbc"; 
        $encryption_key = "3ae8a1c1cf412b27ecd7a87db49f830d";  
        $iv = "a4f051fdf0e638c5"; 
        $decrypted_data = openssl_decrypt($data, $cipher, $encryption_key, 0, $iv);  
        return $decrypted_data;
     }  

    public function user(){
         return $this->belongsTo("App\Models\Admin","banned_by_id");
     }

      public function commet_user(){
         return $this->belongsTo("App\Models\Admin","comment_banned_by_id");
     }

      public function screenshots(){
         return $this->hasMany("App\Models\Screenshot","user_id");
     }

      public function devices(){
         return $this->hasMany("App\Models\UserDevice","user_id");
     }

     public function comments(){
         return $this->hasMany("App\Models\Comment","user_id");
     }

      public function accessTokens()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
