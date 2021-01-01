<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function allCategory(Request $request)
    {
        return view('admin.category.index');
    }

    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ] , [
            'name.required' => 'Please Input Category Name',
        ]);

//        Category::insert([
//            'name' => $request->name,
//            'user_id' => Auth::user()->id,
//            'created_at' => Carbon::now()
//        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect::back()->with('success', 'Category added successfully');

    }
}
