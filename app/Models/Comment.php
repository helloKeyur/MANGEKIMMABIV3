<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

   protected $guarded = ['id'];

    public function comments() {
        return $this->morphMany(Comment::class,'belong');
      }


     public function likes() {
        return $this->morphMany(Reaction::class,'belong');
      }  


      public function emojis() {
       return $this->belongsToMany(Emoji::class, 'comment_emoji','emoji_id','comment_id');
      }

      public function post(){
       return $this->belongsTo("App\Models\Post",'belong_id')->whereNotNull("name");
     }

      public function comment(){
       return $this->belongsTo("App\Models\Comment",'belong_id')->whereNotNull("content");;
     }


      public function user(){
       return $this->belongsTo(User::class,'user_id');
     }
}
