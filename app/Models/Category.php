<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
     use SoftDeletes;

    protected $guarded = ['id'];


    public function enteredBy(){
        return $this->belongsTo('App\Models\Admin','entered_by_id');
    }
}
