<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\Reaction;
use App\Models\Comment;
use App\Models\User;
use App\Models\Emoji;
use App\Models\PostViewer;
use App\Models\Food;
use App\Models\Workout;
use Auth;

class ApiPostController extends Controller
{

       // public function fixComment(){
       //  $comments = Comment::get();
       //  foreach($comments as $comment){
       //      $comment->update(["is_verified" => $comment->user->is_verified ]);
       //  }
       // }


        public function search_post(Request $request){

             if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }

         if(Auth::user()->status == "Banned"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($post),
            ]);

         }

         $posts = Post::where('name', 'LIKE', '%' . User::decrypter($request->name) . '%');
         $posts = $posts->with(
            ['media' => function ($q) {
            $q->select('belong_id','file_path','type','is_featured');
            },
            'categories' => function ($q) {
               $q->select('categories.id','name');
            }]
          )->select('id','name','content','published_at')->orderBy('published_at','DESC')->paginate(10);

           foreach($posts as $post){
            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("post_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();
           }

            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);
        }


        public function getPostCustom($id,$category_id,$type,$count){

             if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }
            
        if(Auth::user()->status == "Banned"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes" ,)] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($post),
            ]);

         }


         if(Auth::user()->is_subscribed == "false"){
           
            $post = [];
            $response = (object)array('id' => 0,  'name' =>"HAUJA LIPIA MANGE KIMAMBI APP","content" => "Lipa sasa kufurahia hudumazetu","published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => url('/images/notpaid.png') ,"type" => "Image","is_featured" => "Yes" ,)] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
            $post[] = $response;
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($post),
            ]);

         }




          if($count == "all"){
            $count = 10;
          }

           $post = Post::find($id);

           if(!$post){
                 return response()->json([
                'success' => false,
                'message' => User::encrypter("Post Not Found"),
                ]);
            }


            if($type != "greater" && $type != "less"){
                 return response()->json([
                'success' => false,
                'message' => User::encrypter("Query Errors"),
                ]);
            }

           $posts  = Post::where('status',"Published")->where("is_video_segment","No");

           if($category_id != "all"){
           $posts = $posts->whereHas('categories', function ($q) use($category_id) {
                   $q->where("category_id",$category_id);
               });
           }

          if($type == "greater"){
                   $posts = $posts->where('published_at','<',Carbon::now())->where('published_at','>',$post->published_at);
          }else{
           $posts = $posts->where('published_at','<',Carbon::now())->where('published_at','<',$post->published_at);
          }



 


          $posts = $posts->with(
            ['media' => function ($q) {
            $q->select('belong_id','file_path','type','is_featured');
            },
            'categories' => function ($q) {
               $q->select('categories.id','name');
            }]
          )->select('id','name','content','published_at')->orderBy('published_at','DESC')->take($count)->get();

           foreach($posts as $post){
            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("post_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();
           }

            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);



        }


        public function getPostById($id){

             if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }

             if(Auth::user()->status == "Banned"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes" ,)] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($post),
            ]);

         }


         if(Auth::user()->is_subscribed == "false"){
           
            $post = [];
            $response = (object)array('id' => 0,  'name' =>"HAUJA LIPIA MANGE KIMAMBI APP","content" => "Lipa sasa kufurahia hudumazetu","published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => url('/images/notpaid.png') ,"type" => "Image","is_featured" => "Yes" ,)] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
            $post[] = $response;
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($post),
            ]);

         }




            $post  = Post::where('id',$id)->with(
            ['media' => function ($q) {
            $q->select('belong_id','file_path','type','is_featured');
            },
            'categories' => function ($q) {
               $q->select('categories.id','name');
            }]
          )->select('id','name','content','published_at')->first(); 

            if(!$post){
                 return response()->json([
                'success' => false,
                'message' => User::encrypter("Post Not Found"),
                ]);
            }

            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("post_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();

             return response()->json([
                'success' => true,
                'post' => $post,
            ]);


        }
       

        public function getPost($from , $to , $limit = 10){

             if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }
         
         if(Auth::user()->is_subscribed == "true"){
            $user = User::find(Auth::user()->id);
            if(Carbon::parse($user->end_of_subscription_date) < Carbon::now()){
                $user->update(["is_subscribed" => "false"]);
            }  
         } 

           if(Auth::user()->is_subscribed == "false"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"HAUJA LIPIA MANGE KIMAMBI APP","content" => "Lipa sasa kufurahia hudumazetu","published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => url('/images/notpaid.png') , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
            $post[] = $response;
             $posts = (object)array('current_page' => 1,"data" => $post,"first_page_url" => "","from" => 0 ,"last_page" => 0, "last_page_url" => "" , "links" => []); 
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);
         }



            
         if(Auth::user()->status == "Banned"){
            $post = [];

            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;

           $posts = (object)array('current_page' => 1,"data" => $post,"first_page_url" => "","from" => 0 ,"last_page" => 0, "last_page_url" => "" , "links" => []); 
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);

         }

          $posts  = Post::where('status',"Published")->where("is_video_segment","No");

          if($from != "all" && $to != "all"){
            try {
                   $from = Carbon::parse($from)->startOfDay();
                   $to = Carbon::parse($to)->endOfDay();
                   $posts = $posts->where('published_at','<',Carbon::now())->whereBetween('published_at',[$from,$to]);
                }catch (\Exception $e) {

                }
          }else{
           $posts = $posts->where('published_at','<',Carbon::now()); 
          }

          if($limit == "all"){
            $limit = 10;
          }


          $posts = $posts->with(
            ['media' => function ($q) {
            $q->select('belong_id','file_path','type','is_featured');
            },
            'categories' => function ($q) {
               $q->select('categories.id','name');
            }]
          )->select('id','name','content','published_at')->orderBy('published_at','DESC')->paginate($limit);

           foreach($posts as $post){
            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("post_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();
           }

            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);

    }

    public function getAllVideo($from , $to , $limit = 10){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }

         if(Auth::user()->status == "Banned"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;
          $posts = (object)array('current_page' => 1,"data" => $post,"first_page_url" => "","from" => 0 ,"last_page" => 0, "last_page_url" => "" , "links" => []);
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);

         }

         $posts  = Post::where('status',"Published")->where("is_video_segment","Yes");

          if($from != "all" && $to != "all"){
            try {
                   $from = Carbon::parse($from)->startOfDay();
                   $to = Carbon::parse($to)->endOfDay();
                   $posts = $posts->where('published_at','<',Carbon::now())->whereBetween('published_at',[$from,$to]);
                }catch (\Exception $e) {

                }
          }else{
           $posts = $posts->where('published_at','<',Carbon::now()); 
           }

          if($limit == "all"){
            $limit = 10;
          }


          $posts = $posts->with(
            ['media' => function ($q) {
            $q->select('belong_id','file_path','type','is_featured');
            },
            'categories' => function ($q) {
               $q->select('categories.id','name');
            }]
          )->select('id','name','content','published_at')->orderBy('published_at','DESC')->paginate($limit);

           foreach($posts as $post){
            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();
           }

            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]); 
    }

    public function postViewer($post_id){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }

       // $check =   PostViewer::where("user_id",$user_id)->where("post_id",$post_id)->exists();
        PostViewer::create(["user_id" => Auth::user()->id , "post_id" => $post_id ]);
         return response()->json([
                'success' => true,
                'message' => User::encrypter("Submited succesfully"),
            ]);

    }

    public function getCategories(){
     $cats =   Category::select("id","name")->where('state','online')->orderBy('arrangement', 'asc')->get();
        return response()->json([
            'success' => true,
            'cats' => User::encrypter($cats),
        ]);
    }

    public function getAllPostByCategories($from , $to , $limit = 10, $category_id){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }


        if(Auth::user()->is_subscribed == "false"){
 $post = [];
            $response = (object)array('id' => 0, 'name' =>"HAUJA LIPIA MANGE KIMAMBI APP","content" => "Lipa sasa kufurahia hudumazetu","published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => url('/images/notpaid.png') , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
            $post[] = $response;
             $posts = (object)array('current_page' => 1,"data" => $post,"first_page_url" => "","from" => 0 ,"last_page" => 0, "last_page_url" => "" , "links" => []); 
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);
         }




         if(Auth::user()->status == "Banned"){
            $post = [];
            $response = (object)array('id' => 0, 'name' =>"UMEFUNGIWA KUTAZAMA HABARI ZA MANGE KIMAMBI APP","content" => Auth::user()->banned_reason ,"published_at" => Auth::user()->updated_at, "media" => [(object)array('belong_id' => 1,"file_path" => "https://cdn.pixabay.com/photo/2016/10/09/17/28/banned-1726366__340.jpg" , "type" => "Image","is_featured" => "Yes")] ,"categories" => [(object)array('id' => 1,"name" => "ZA MOTO")],"like_count" => 0 ,"liked_by" => [], "comment_count" => 0);
          $post[] = $response;
          $posts = (object)array('current_page' => 1,"data" => $post,"first_page_url" => "","from" => 0 ,"last_page" => 0, "last_page_url" => "" , "links" => []);
            return response()->json([
                'success' => true,
                'posts' => User::encrypter($posts),
            ]);

         }

        $posts  = Post::where('status',"Published")->whereHas('categories', function($q)use($category_id){
            $q->where('category_id',$category_id);
        });

        if($from != "all" && $to != "all"){
            try {
                $from = Carbon::parse($from)->startOfDay();
                $to = Carbon::parse($to)->endOfDay();
                $posts = $posts->where('published_at','<',Carbon::now())->whereBetween('published_at',[$from,$to]);
            }catch (\Exception $e) {

            }
        }else{
           $posts = $posts->where('published_at','<',Carbon::now()); 
        }
        if($limit == "all"){
            $limit = 10;
        }


        $posts = $posts->with(
            ['media' => function ($q) {
                $q->select('belong_id','file_path','type','is_featured');
            },
                'categories' => function ($q) {
                    $q->select('categories.id','name');
                }]
        )->select('id','name','content','published_at')->orderBy('published_at','DESC')->paginate($limit);

        foreach($posts as $post){
            $post->like_count =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->count();
            $post->liked_by =  Reaction::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->where("react","Like")->where("user_id",Auth::user()->id)->pluck("user_id")->toArray();
            $post->comment_count =  Comment::where("belong_type","App\Models\Post")->where("belong_id",$post->id)->count();
            $post->date_reader = Carbon::parse($post->published_at)->diffForHumans();
           }

        return response()->json([
            'success' => true,
            'posts' => User::encrypter($posts),
        ]);
    }


    public function getPostComments($id){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }


        if(Auth::user()->status == "Banned"){
             return response()->json([
            'success' => true,
            'comments' => User::encrypter([]),
           ]);
         }


         if(Auth::user()->is_subscribed == "false"){

            return response()->json([
            'success' => true,
            'comments' => User::encrypter([]),
           ]);
         }


          $check =   PostViewer::where("user_id",Auth::user()->id)->where("post_id",$id)->exists();
         if(!$check){
              PostViewer::create(["user_id" => Auth::user()->id , "post_id" => $id ]);
         }
      
          $Comments = Comment::where("belong_type","App\Models\Post")->where("belong_id",$id)

          ->with(
            ['comments' => function ($q) {
                $q->with(
                  [
                     'emojis' => function ($q) {
                    $q->select('emoji.id','img_url');
                      }
                  ]
                )->select('id','user_id','belong_id','name','is_verified','content','created_at','user_img_url');
            },
           'emojis' => function ($q) {
                    $q->select('emoji.id','img_url');
                }]
           )->select("id","user_id","name","content","is_verified","created_at","user_img_url")->latest()->paginate(10);

           foreach($Comments as $comment){
            $comment->like_count =  Reaction::where("belong_type","App\Models\Comment")->where("belong_id",$comment->id)->where("react","Like")->count();
            $comment->liked_by =  Reaction::where("belong_type","App\Models\Comment")->where("belong_id",$comment->id)->where("react","Like")->pluck("user_id")->toArray();
            $comment->comment_count =  Comment::where("belong_type","App\Models\Comment")->where("belong_id",$comment->id)->count();
           }

           return response()->json([
            'success' => true,
            'comments' => User::encrypter($Comments),
        ]);
    }

    public function getFood($date){

      if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }
           
     if(Auth::user()->status == "Banned"){   
        return response()->json([
            'success' => true,
            'foods' => User::encrypter([]),
        ]);
    }


     if(Auth::user()->is_subscribed == "false"){ 
        return response()->json([
            'success' => true,
            'foods' => User::encrypter([]),
        ]);
    }




       $foods = Food::where("date",$date)->select("name","img_url","date","takes_time","person","category","description")->get();
         return response()->json([
            'success' => true,
            'foods' => User::encrypter($foods),
        ]);
    }

    public function getWorkout($date){

       if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }
          
      if(Auth::user()->status == "Banned"){  
        return response()->json([
            'success' => true,
            'workout' => User::encrypter([]),
        ]);
    }
       $workout = Workout::where("date",$date)->select("name","img_url","video_url","date","exercise_time","circuit","description")->get();
         return response()->json([
            'success' => true,
            'workout' => User::encrypter($workout),
        ]);  
    }


    public function submitComment(Request $request){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }


        if(Auth::user()->is_subscribed == "false"){
           return response()->json([
            'success' => true,
            'message' => User::encrypter('Haujafanya malipo'),
           ]);
         }



           $input = $request->all();

        //  if(isset($input['emojis']) && is_array($input['emojis'])){
        //         $text = "with emoji";
        //     }else{
        //        $text = "with no emoji";  
        //     }

        // return response()->json([$text,$request->all()]);

        if(Auth::user()->comment_status == "Banned"){
             return response()->json([
            'success' => true,
            'message' => User::encrypter('Banned from comments'),
        ]);
         }

      

        if(!strlen($input["content"]) && !(isset($input['emojis']) && is_array(User::decrypter($input['emojis'])) )) {
           return response()->json([
            'success' => true,
            'message' => User::encrypter('Empty comment not accepted'),
        ]);
        }


         if(isset($input['type']) && User::decrypter($input['type']) == "post"){

          $post = Post::find(User::decrypter($input['id']));

            if(!$post){
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Commented Post Not Found'),
            ], 401);
            }


          $comment =  Comment::create([
               'user_id' => Auth::user()->id,
               'belong_type' => 'App\Models\Post',
               'belong_id' => $post->id,
               'post_id' => $post->id,
               'name' => Auth::user()->username,
               'is_verified' => Auth::user()->is_verified,
               'user_img_url' => Auth::user()->img_url,
               'content' => User::decrypter($input['content']),
            ]);

           if(isset($input['emojis']) && is_array(User::decrypter($input['emojis']))){
                $text = "with emoji";
                $comment->emojis()->sync(User::decrypter($input['emojis']));
            }else{
               $text = "with no emoji";  
            }

          return response()->json([
                'success' => true,
                'message' => User::encrypter("Submited succesfully".$text),
            ]);


         }elseif(isset($input['type']) && User::decrypter($input['type']) == "comment"){
           $main_comment = Comment::find(User::decrypter($input['id']));
            if(!$main_comment){
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Commented Comment Not Found'),
            ], 401);
            }
            
            $comment =  Comment::create([
               'user_id' => Auth::user()->id,
               'belong_type' => 'App\Models\Comment',
               'belong_id' => User::decrypter($input['id']),
               'post_id' =>  $main_comment->post_id,
               'name' => Auth::user()->username,
               'is_verified' => Auth::user()->is_verified,
               'user_img_url' => Auth::user()->img_url,
               'content' => User::decrypter($input['content']),
            ]);

            if(isset($input['emojis']) && is_array(User::decrypter($input['emojis']))){
               $text = "with emoji";
               $comment->emojis()->sync(User::decrypter($input['emojis'])); 
            }else{
               $text = "with no emoji";  
            }

            

            return response()->json([
                'success' => true,
                'message' => User::encrypter("Submited succesfully ".$text),
            ]);
        }else{
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Invalid React type please us post or comment'),
            ], 401);
        }

    }

    public function getEmoj(){

        $emoj = Emoji::select("id","img_url")->get();
        foreach($emoj as $em){
           $em->img_url = url('/').$em->img_url; 
        }
         return response()->json([
                'success' => true,
                'emoj' => User::encrypter($emoj),
            ]);
    }

    public function submitLikes(Request $request){

         if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }else{
            Auth::user()->update(["is_subscribed" => "true"]);
        }

        $input = $request->all();

        // $input['react'] = User::decrypter($input['react']);
        // $input['id'] = User::decrypter($input['id']);
        // $input['type'] = User::decrypter($input['type']);

       


        if(!isset($input['react']) || !in_array(User::decrypter($input['react']),["Like","Dislike"])){
           return response()->json([
                'success' => false,
                'message' => User::encrypter('Invalid React please us Like or Dislike'),
            ], 401);
        }
        if(isset($input['type']) && User::decrypter($input['type']) == "post"){
            $post = Post::find(User::decrypter($input['id']));
            if(!$post){
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Reacted Post Not Found'),
            ], 401);
            }


           
        if(User::decrypter($input['react'] )== "Like"){
             
             Reaction::create([
               'user_id' => Auth::user()->id,
               'belong_type' => 'App\Models\Post',
               'belong_id' => $post->id,
               'post_id' => $post->id,
               'name' => Auth::user()->username,
               'react' => User::decrypter($input['react']),
            ]);

         }else{
            Reaction::where("belong_type","App\Models\Post")->where("user_id",Auth::user()->id)->where("belong_id",$post->id)->delete();
         }
           

            return response()->json([
                'success' => true,
                'message' => User::encrypter("Submited succesfully"),
            ]);
        }elseif(isset($input['type']) && User::decrypter($input['type']) == "comment"){
           $Comment = Comment::find(User::decrypter($input['id']));
            if(!$Comment){
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Reacted Comment Not Found'),
            ], 401);
            }

             if(User::decrypter($input['react']) == "Like"){
             Reaction::create([
               'user_id' => Auth::user()->id,
               'belong_type' => 'App\Models\Comment',
               'belong_id' => $Comment->id,
               'post_id' => $Comment->post_id,
               'name' => Auth::user()->username,
               'react' => User::decrypter($input['react']),
            ]);
             }else{
              Reaction::where("belong_type","App\Models\Comment")->where("user_id",Auth::user()->id)->where("belong_id",$Comment->id)->delete();
             }

            return response()->json([
                'success' => true,
                'message' => User::encrypter("Submited succesfully"),
            ]);
        }else{
               return response()->json([
                'success' => false,
                'message' => User::encrypter('Invalid React type please us post or comment'),
            ], 401);
        }
    }
}
