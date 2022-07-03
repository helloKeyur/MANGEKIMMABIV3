<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Image;

class FoodController extends Controller
{
    public function index()
    {

        $vars['title']  = "Foods";
        $vars['sub_title'] = "Blog Management";
        $vars['Foods'] =  Food::get();
        // return view('backend.foods.index', compact('vars'));
        return view('v3.backend.foods.index', compact('vars'));
    }



    public function store(Request $request)
    {
        $request['date'] = date('Y-m-d', strtotime($request['date']));
        $input = $request->all();

        //     if($request['img']!=null){
        //     $file = $request['img'];
        //     $file_name = time().'_'.$file->getClientOriginalName();
        //     $image = Image::make($file);
        //      $original_path = public_path().'/images/food/';
        //     $image->save($original_path.$file_name);


        //     $input['img_url'] = '/images/food/'.$file_name;
        // }
        $input['entered_by_id'] = \Auth::user()->id;
        $food = Food::create($input);
        return response()->json($food);
    }

    public function show($id)
    {
        $food = Food::find($id);
        $view = view('v3.backend.foods._view', ['row' => $food])->render();
        return response()->json($view);
    }

    public function edit($id)
    {
        $food = Food::find($id);
        $view = view('v3.backend.foods._edit', ['row' => $food])->render();
        return response()->json($view);
    }


    public function foods_dates($date)
    {
        $date = date('Y-m-d', strtotime($date));
        $food = Food::where('date', $date)->get();

        $view = view('v3.backend.foods._day_food_div', ['row' => $food, 'date' => $date])->render();
        return response()->json($view);
    }



    public function update(Request $request, $id)
    {
        $food =  Food::find($id);
        $request['date'] = date('Y-m-d', strtotime($request['date']));

        $input = $request->all();

        //     if($request['img']!=null){
        //     $file = $request['img'];
        //     $file_name = time().'_'.$file->getClientOriginalName();
        //     $image = Image::make($file);
        //      $original_path = public_path().'/images/food/';
        //     $image->save($original_path.$file_name);


        //     $input['img_url'] = '/images/food/'.$file_name;
        // }



        $input['entered_by_id'] = \Auth::user()->id;
        $food->update($input);

        return response()->json($food);
    }



    public function destroy($id)
    {
        $food = Food::find($id);
        $food->update(['deleted_by_id' => \Auth::user()->id]);
        $food->delete();
        return \Response::Json('Delete Success', 200);
    }
}