<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emoji;
use Image;

class EmojiController extends Controller
{
    public function index()
    {

        $vars['title']  = "Emojis";
        $vars['sub_title'] = "Blog Management";
        $vars['emojis'] =  Emoji::get();
        return view('v3.backend.emojis.index', compact('vars'));
    }



    public function store(Request $request)
    {

        $input = $request->all();
        if ($request['img'] != null) {
            $file = $request['img'];
            $file_name = time() . '_' . $file->getClientOriginalName();
            $image = Image::make($file);
            $original_path = public_path() . '/images/emojis/';
            $image->save($original_path . $file_name);


            $input['img_url'] = '/images/emojis/' . $file_name;
        }

        $input['entered_by_id'] = \Auth::user()->id;
        $emoji = Emoji::create($input);

        $view = view('backend.emojis._tr', ['row' => $emoji])->render();
        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Emoji save successful',
                'redirect_to' => route('emojis.index')
            ]);
        }
        return response()->json($view);
    }



    public function edit(Request $request, $id)
    {
        $emoji = Emoji::find($id);
        $view = view('backend.emojis._edit', ['row' => $emoji])->render();
        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'error' => false,
                'emoji' => $emoji,
            ]);
        }
        return response()->json($view);
    }




    public function update(Request $request, $id)
    {
        $emoji =  Emoji::find($id);
        $input = $request->all();
        if (isset($request['img']) && $request['img'] != null) {
            $file = $request['img'];
            $file_name = time() . '_' . $file->getClientOriginalName();
            $image = Image::make($file);
            $original_path = public_path() . '/images/emojis/';
            $image->save($original_path . $file_name);

            $input['img_url'] = '/images/emojis/' . $file_name;
        }

        $input['entered_by_id'] = \Auth::user()->id;
        $emoji->update($input);

        $view = view('backend.emojis._tr', ['row' => $emoji])->render();
        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Emoji updated successful',
                'redirect_to' => route('emojis.index')
            ]);
        }
        return response()->json($view);
    }



    public function destroy($id)
    {
        $emoji = Emoji::find($id);
        $emoji->delete();
        // return \Response::Json('Delete Success', 200);
        return response()->json([
            'status' => true,
            'message' => "Your Record has been Deleted!",
            'redirect_to' => route('emojis.index'),
        ]);
    }
}