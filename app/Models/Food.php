<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory;
    use SoftDeletes;

protected $guarded = ['id'];

 public static function category() {
  return   ['Breakfast','Lunch','Snack','Dinner','Other'];
}

 public function entered_by(){
       return $this->belongsTo(Admin::class,'entered_by_id');
     }
}
