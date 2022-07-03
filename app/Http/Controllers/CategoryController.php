<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $vars['title']  = "Categories";
        $vars['sub_title'] = "Blog Management";
        $vars['categories'] =  Category::orderBy('arrangement', 'asc')->get();
        // return view('backend.categories.index', compact('vars'));
        return view('v3.backend.categories.index', compact('vars'));
    }



    public function category_state(Request $request)
    {
        $Category = Category::find($request->id);
        if (!$Category) {
            return response()->json(['error' => 'Error Category not found....!']);
        }
        $Category->update(['state' => $request->category_state]);
        return response()->json();
    }


    public function category_arrangement(Request $request)
    {
        $Category = Category::find($request->id);
        if (!$Category) {
            return response()->json(['error' => 'Error Category not found....!']);
        }
        $Category->update(['arrangement' => $request->arrangement]);
        return response()->json();
    }




    public function store(Request $request)
    {

        $input = $request->all();
        $input['entered_by_id'] = \Auth::user()->id;
        $category = Category::create($input);


        $category->update(['arrangement' => Category::count() + 1]);

        $permission = Permission::create($input);
        if (str_replace(url('/'), "", \URL::previous()) == "/management/categories") {
            $view = view('v3.backend.categories._tr', ['row' => $category])->render();
            return response()->json($view);
        } else {
            return response()->json($category);
        }
    }



    public function edit($id)
    {
        $category = Category::find($id);
        $view = view('v3.backend.categories._edit', ['row' => $category])->render();
        return response()->json($view);
    }




    public function update(Request $request, $id)
    {
        $category =  Category::find($id);
        $permission =  Permission::find($id);
        $input = $request->all();
        $input['entered_by_id'] = \Auth::user()->id;
        $category->update($input);
        $permission->update($input);
        return redirect()->back()->withMessage('Transaction updated succesfull  ')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
    }



    public function destroy($id)
    {
        $category = Category::find($id);
        $permission = Permission::find($id);
        $category->update(['deleted_by_id' => \Auth::user()->id]);
        $category->delete();
        $permission->delete();
        return \Response::Json('Delete Success', 200);
    }
}