<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
     use SoftDeletes;
    protected $guarded = ['id'];


     public function categories() {
       return $this->belongsToMany(Category::class, 'post_categories');
      }

      public function media() {
        return $this->morphMany(Media::class,'belong');
      }

      public function comments() {
        return $this->morphMany(Comment::class,'belong');
      }

      public function likes() {
        return $this->morphMany(Reaction::class,'belong');
      }


       public function post_viewers() {
        return $this->hasMany(PostViewer::class,'post_id');
      }


      public function post_comments() {
        return $this->hasMany(Comment::class,'post_id');
      }

       public function post_reactions() {
        return $this->hasMany(Reaction::class,'post_id');
      }

         public function enteredBy(){
        return $this->belongsTo('App\Models\Admin','author_id');
    }


    public static function is_video_segment() {
      return   ['Yes','No'];
    }
}
