<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        $deletedCategory = Category::onlyTrashed()->get();
        return view('category',['categories' => $category, 'deletedCategory' => $deletedCategory]);
    }

    public function add()
    {
        return view('category-add');       
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);

        $category = Category::create($request->all());
        return redirect('categories')->with(['success' => 'Add new category successfully']);
    }

    public function edit($slug)
    {
        $category = Category::where('slug',$slug)->first();
        return view('category-edit',['category' => $category]);
    }

    public function update(request $request,$slug)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);

        $category = Category::where('slug', $slug)->first();
        $category->slug = null;
        $category->update($request->all());
        return redirect('categories')->with(['success' => 'Category Updated successfully']);
    }

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category->delete($slug);
        return redirect('categories')->with(['success' => 'Category Deleted successfully']);
    }

    public function restore($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->first();
        $category->restore();
        return redirect('categories')->with('success', 'Category Restored successfully');
    }
}
