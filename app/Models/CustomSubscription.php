<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSubscription extends Model
{
    use HasFactory;
     protected $guarded = ['id'];
     protected $table = "custom_subscriptions";

     public function user(){
        return $this->belongsTo("App\Models\Admin","admin_id");
     }

      public function customer(){
        return $this->belongsTo("App\Models\User","user_id");
     }
}
