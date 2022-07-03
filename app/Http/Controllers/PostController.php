<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Media;
use App\Models\Category;
use App\Models\Comment;
use App\Models;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\ApiNotificationController;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $vars['title']  = "Post list";
        $vars['sub_title'] = "Blog Management";
        $vars['posts'] =  Post::orderBy('id', 'DESC')->get();
        return view('backend.post.index', compact('vars'));
    }

    public function create()
    {
        // dd(['2022-01-05T15:47',Carbon::parse('2022-01-05T15:47')->timestamp]);
        $vars['title']  = "Create a Post";
        $vars['sub_title'] = "Blog Management";
        $vars['categories'] =  Category::select('id', 'name')->get();
        $vars['gotoback'] =  route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString());
        return view('v3.backend.post.create', compact('vars'));
    }

    public function store(Request $request)
    {

        if ($request->status == 'date_time') {
            $request->status = 'Published';
            $request->published_at = Carbon::parse($request->published_at);
        } else if ($request->status == 'Published') {
            $request->published_at = Carbon::now();
        } else {
            $request->published_at = Carbon::parse($request->published_at);
        }
        $input = $request->all();

        $post = Post::create([
            'name' => $request->name,
            'status' => $request->status,
            'content' => $request->content,
            'published_at' => Carbon::parse($request->published_at),
            'author_id' => Auth::user()->id,
        ]);

        if ($post->status == "Published" && (in_array(1, $request->categories) || in_array(2, $request->categories))) {
            if (Carbon::parse($request->published_at) > Carbon::now()) {
                $notification_response =  ApiNotificationController::sendNotifications($request->name, " ", $post->id, Carbon::parse($request->published_at));
            } else {
                $notification_response =  ApiNotificationController::sendNotifications($request->name, " ", $post->id);
            }
            $notification_response = json_decode($notification_response);
            if (isset($notification_response->id)) {
                $notification_id = $notification_response->id;
                if (strlen($notification_id)) {
                    $post->update(["notification_id" => $notification_id]);
                } else {
                    $post->update(["notification_id" => "error"]);
                }
            } else {
                $post->update(["notification_id" => "error"]);
            }
        }


        if (isset($request['image'])) {
            foreach ($request['image'] as $image) {
                $post->media()->create([
                    'file_path' => $image,
                    'type' => 'Image',
                    'belong_type' => 'App\Models\Post',
                    'belong_id' => $post->id,
                    'entered_by_id' => Auth::user()->id,
                ]);
            }
        }

        if (isset($request['video'])) {
            foreach ($request['video'] as $video) {
                $post->media()->create([
                    'file_path' => $video,
                    'type' => 'Video',
                    'belong_type' => 'App\Models\Post',
                    'belong_id' => $post->id,
                    'entered_by_id' => Auth::user()->id,
                ]);
            }
        }


        $post->categories()->sync($request->categories);
        // return response()->json(true);
        return response()->json([
            'status' => true,
            'message' => 'New Post is added successfully.',
            'redirect_to' => route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString())
        ]);
    }

    public function show($id)
    {
        $post = Post::find(decrypt($id));
        $view = view('v3.backend.post._view', ['row' => $post])->render();
        // return response()->json($view);
        return $view;
    }

    public function edit($id)
    {
        $vars['post'] = Post::find(decrypt($id));

        $vars['title']  = "Edit a Post";
        $vars['sub_title'] = $vars['post']->name;
        $vars['categories'] =  Category::select('id', 'name')->get();
        $vars['gotoback'] =
            route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString());
        return view('v3.backend.post.edit', compact('vars'));
    }


    public function media_is_featured($id, $madia)
    {
        Media::where('belong_id', $id)->where('belong_type', 'App\Models\Post')->update(['is_featured' => 'No']);
        $vars['media'] = Media::find($madia);
        $vars['media']->update(['is_featured' => 'Yes']);

        return response()->json();
    }


    public function post_list($time)
    {
        $vars['sub_title'] = "Blog Management";


        $custom_data = explode('~', $time);
        $from_date =  $custom_data[0];
        $to_date  =  $custom_data[1];
        $vars['time'] = $time;
        $vars['title']  = "Post list from " . $from_date . "  to  " . $to_date;
        $vars['posts'] = Post::whereBetween('created_at', [Carbon::parse($from_date)->startOfDay(),  Carbon::parse($to_date)->endOfDay()])->orderBy('id', 'DESC')->get();
        // return view('backend.post.index', compact('vars'));
        return view('v3.backend.post.index', compact('vars'));
    }



    public function update(Request $request, $id)
    {
        $input = $request->all();
        $post = Post::find(decrypt($id));
        $old_status = $post->status;
        $post->update([
            'name' => $request->name,
            'status' => $request->status,
            'content' => $request->content,
            'published_at' => Carbon::parse($request->published_at),
            'author_id' => Auth::user()->id,
        ]);

        if ($old_status == "Draft" && $request->status == "Published" && (in_array(1, $request->categories) || in_array(2, $request->categories))) {
            if ($post->notification_id && $post->notification_id != "error") {
                ApiNotificationController::cancel_nofitication($post->notification_id);
            }

            if (Carbon::parse($request->published_at) > Carbon::now()) {
                $notification_response =  ApiNotificationController::sendNotifications($request->name, "Click to view new post", $post->id, Carbon::parse($request->published_at));
            } else {
                $notification_response =  ApiNotificationController::sendNotifications($request->name, "Click to view new post", $post->id);
            }
            $notification_response = json_decode($notification_response);
            if (isset($notification_response->id)) {
                $notification_id = $notification_response->id;
                if (strlen($notification_id)) {
                    $post->update(["notification_id" => $notification_id]);
                } else {
                    $post->update(["notification_id" => "error"]);
                }
            } else {
                $post->update(["notification_id" => "error"]);
            }
        }

        DB::table('media')->where('belong_type', 'App\Models\Post')->where('belong_id', $post->id)->delete();
        if (isset($request['image'])) {
            foreach ($request['image'] as $image) {
                $post->media()->create([
                    'file_path' => $image,
                    'type' => 'Image',
                    'belong_type' => 'App\Models\Post',
                    'belong_id' => $post->id,
                    'entered_by_id' => Auth::user()->id,
                ]);
            }
        }
        if (isset($request['video'])) {
            foreach ($request['video'] as $video) {
                $post->media()->create([
                    'file_path' => $video,
                    'type' => 'Video',
                    'belong_type' => 'App\Models\Post',
                    'belong_id' => $post->id,
                    'entered_by_id' => Auth::user()->id,
                ]);
            }
        }
        $post->categories()->sync($request->categories);
        // return response()->json(true);
        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully.',
            'redirect_to' => route('post.edit', encrypt($post->id))
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->update(['deleted_by_id' => Auth::user()->id]);
        $post->delete();
        // return response()->json();
        return response()->json([
            'status' => true,
            'message' => "Your Record has been Deleted!",
            'redirect_to' => route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString()),
        ]);
    }

    public function delete_comment($id)
    {
        $comment = Comment::find($id);
        $comment->update(['deleted_by_id' => Auth::user()->id]);
        $comment->delete();
        // return response()->json();
        return response()->json([
            'status' => true,
            'message' => "Your Record has been Deleted!",
            'redirect_to' => route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString()),
        ]);
    }

    public function sendNotificationCustom($id)
    {

        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Error Post not found....!']);
        }

        if ($post->status != "Published") {
            return response()->json(['error' => 'Error Post is not Published....!']);
        }

        if ($post->status == "Published") {
            if ($post->notification_id && $post->notification_id != "error") {
                ApiNotificationController::cancel_nofitication($post->notification_id);
            }

            if (Carbon::parse($post->published_at) > Carbon::now()) {
                $notification_response =  ApiNotificationController::sendNotifications($post->name, " ", $post->id, Carbon::parse($post->published_at));
            } else {
                $notification_response =  ApiNotificationController::sendNotifications($post->name, " ", $post->id);
            }
            $notification_response = json_decode($notification_response);
            if (isset($notification_response->id)) {
                $notification_id = $notification_response->id;
                if (strlen($notification_id)) {
                    $post->update(["notification_id" => $notification_id]);
                } else {
                    $post->update(["notification_id" => "error"]);
                }
            } else {
                $post->update(["notification_id" => "error"]);
            }
        }

        return response()->json("Notifications was successfully sent");
    }
}