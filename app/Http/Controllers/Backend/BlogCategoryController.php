<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => ['required', 'string', 'max:50', 'unique:blog_categories,name'],
           'status' => ['required', 'boolean'],
        ],[
            'name.unique' => 'Category Name Already Exists'
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr('New Blog Category Created', 'success', 'success');
        flash('New Blog Category Created', 'success');

        return redirect()->route('admin.blog-category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('admin.blog.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:blog_categories,id,.$id'],
            'status' => ['required', 'boolean'],
        ],[
            'name.unique' => 'Category Name Already Exists'
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr('Blog Category Updated', 'success', 'success');
        flash('Blog Category Updated', 'success');

        return redirect()->route('admin.blog-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return response(['status' => 'success', 'message' => 'Blog Category Has Been Deleted']);
    }

    public function changeStatus(Request $request)
    {
        $category = BlogCategory::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
