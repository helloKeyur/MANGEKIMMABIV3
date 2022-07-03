<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use Image;

class WorkoutController extends Controller
{
  public function index()
  {

    $vars['title']  = "Workouts";
    $vars['sub_title'] = "Blog Management";
    $vars['Workouts'] =  Workout::get();
    // return view('backend.workouts.index', compact('vars'));
    return view('v3.backend.workouts.index', compact('vars'));
  }



  public function store(Request $request)
  {
    $request['date'] = date('Y-m-d', strtotime($request['date']));
    $input = $request->all();

    //     if($request['img']!=null){
    //     $file = $request['img'];
    //     $file_name = time().'_'.$file->getClientOriginalName();
    //     $image = Image::make($file);
    //      $original_path = public_path().'/images/workout/';
    //     $image->save($original_path.$file_name);


    //     $input['img_url'] = '/images/workout/'.$file_name;
    // }
    $input['entered_by_id'] = \Auth::user()->id;
    $workout = Workout::create($input);
    return response()->json($workout);
  }

  public function show($id)
  {
    $workout = Workout::find($id);
    $view = view('V3.backend.workouts._view', ['row' => $workout])->render();
    return response()->json($view);
  }

  public function edit($id)
  {
    $workout = Workout::find($id);
    $view = view('v3/backend.workouts._edit', ['row' => $workout])->render();
    return response()->json($view);
  }


  public function workouts_dates($date)
  {
    $date = date('Y-m-d', strtotime($date));
    $workout = Workout::where('date', $date)->get();

    $view = view('v3.backend.workouts._day_workout_div', ['row' => $workout, 'date' => $date])->render();
    return response()->json($view);
  }



  public function update(Request $request, $id)
  {
    $workout =  Workout::find($id);
    $request['date'] = date('Y-m-d', strtotime($request['date']));

    $input = $request->all();

    //     if($request['img']!=null){
    //     $file = $request['img'];
    //     $file_name = time().'_'.$file->getClientOriginalName();
    //     $image = Image::make($file);
    //      $original_path = public_path().'/images/workout/';
    //     $image->save($original_path.$file_name);


    //     $input['img_url'] = '/images/workout/'.$file_name;
    // }



    $input['entered_by_id'] = \Auth::user()->id;
    $workout->update($input);

    return response()->json($workout);
  }



  public function destroy($id)
  {
    $workout = Workout::find($id);
    $workout->update(['deleted_by_id' => \Auth::user()->id]);
    $workout->delete();
    return \Response::Json('Delete Success', 200);
  }
}