<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $vars['title'] = 'Mange Kimambi';

        return view('frontend.index',compact('vars'));
    }

       public function delete_any($table,$id){
        if(Schema::hasColumn($table, 'deleted_at'))
        {
        $data =\DB::table($table)->where('id',$id)->update(['deleted_at'=>Carbon::now(),'deleted_by_id'=>Auth::user()->id]);
        }
        else{
        $data =\DB::table($table)->where('id',$id)->delete();
        }
        return \Response::Json('Delete Success', 200);
    }




   
}
