<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function allCategory()
    {
        $categories = Category::latest()->paginate(5);
        $trashCategories = Category::onlyTrashed()->latest()->paginate(3);

        return view('admin.category.index', compact('categories', 'trashCategories'));
    }

    public function addCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ] , [
            'name.required' => 'Please Input Category Name',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect::back()->with('success', 'Category added successfully');

    }

    public function editCategory(int $id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, int $id): RedirectResponse
    {
        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ]);

        return Redirect::route('all.category')->with('success', 'Category updated successfully');
    }


    public function deleteCategory(int $id): RedirectResponse
    {
        $category = Category::find($id);
        $category->delete();

        return Redirect::route('all.category')->with('success', 'Category deleted successfully');
    }

    public function restoreCategory(int $id): RedirectResponse
    {
        $category = Category::withTrashed()->find($id);
        $category->restore();

        return Redirect::route('all.category')->with('success', 'Category restored successfully');
    }

    public function permanentDeleteCategory(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->find($id);
        $category->forceDelete();

        return Redirect::route('all.category')->with('success', 'Category permanent deleted successfully');
    }
}
