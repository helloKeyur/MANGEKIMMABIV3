<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{

    public function showLoginForm(){

       // DATABASE BACK AFTER USER DELETION USER ******************************

        // $old_user = \DB::table('users2')->select('id')->where("id",">","203085")->limit(50000)->orderBy('id','ASC')->pluck('id')->toArray();

        // ->where("id",">","52344")


        // 52344
        //102575

        // $old_user = \DB::table('users2')->select('id')->limit(50000)->orderBy('id','ASC')->latest()->get();

        // 217380

        // dd(end($old_user));

        // $users = \App\Models\User::whereIn('id',$old_user)->delete();

        // dd($users);

        // dd(end($old_user));



       // DATABASE BACK AFTER USER DELETION COMMENTS ******************************

        // $old_user = \DB::table('comments2')->select('id')->where("id",">","74499")->limit(50000)->orderBy('id','ASC')->pluck('id')->toArray();

        // ->where("id",">","54255")


        // 52344
        //102575

        // $old_user = \DB::table('users2')->select('id')->limit(50000)->orderBy('id','ASC')->latest()->get();

        // 217380

        // dd(end($old_user));

        // $users = \App\Models\Comment::whereIn('id',$old_user)->delete();

        // dd($users);

        // dd(end($old_user));





       return view('auth.admin_login');
     }

     public function login(Request $request)
    {
        if(Auth::guard('admin-web')->attempt($request->only(['email', 'password']))){
             // return redirect()->intended(route('management.dashboard'));

            return redirect()->route('management.dashboard');
       }else{
            return redirect()->back()->withErrors(['email' => 'This Credential do not match with our records']);
        }

    }
}
