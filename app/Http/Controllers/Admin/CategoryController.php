<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('feedback')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500'
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500'
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has feedback
        if ($category->feedback()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category that has associated feedback.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}