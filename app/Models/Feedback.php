<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
       use HasFactory;

       protected $guarded = ['id'];
       public function media() {
        return $this->morphMany(Media::class,'belong');
      }
}
