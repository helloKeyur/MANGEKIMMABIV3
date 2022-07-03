<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

     public static function category() {
       return   ['Circuit 1','Circuit 2','Other'];
     }

    public function entered_by(){
       return $this->belongsTo(Admin::class,'entered_by_id');
     }
}
