<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function showAllCategories()
    {
        $categories = Category::query()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'published' => 'nullable',
            'category_template_id' => 'nullable',
            'parent_category_id' => 'nullable',
            'picture_id' => 'nullable',
            'page_size'=> 'nullable',
            'allow_customers_to_select_page_siz' => 'nullable',
            'subject_to_acl' => 'nullable',
            'limited_to_stories' => 'nullable',
            'deleted' => 'nullable',
            'display_order' => 'nullable'
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
