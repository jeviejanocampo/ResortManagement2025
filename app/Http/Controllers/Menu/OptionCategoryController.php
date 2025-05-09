<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\OptionCategoryRequest;
use App\Models\OptionCategory;
use Illuminate\Support\Facades\Auth;

class OptionCategoryController extends Controller
{
    public function index()
    {
        $categories = OptionCategory::latest()->get();
        return view('menu.option_categories', compact('categories'));
    }

    public function store(OptionCategoryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        
        OptionCategory::create($data);

        return redirect()->route('categories')->with('success', 'Category created successfully.');
    }

    public function update(OptionCategoryRequest $request, OptionCategory $category)
    {
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(OptionCategory $category)
    {
        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully.');
    }
}
