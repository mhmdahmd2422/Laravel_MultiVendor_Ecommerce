<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'image' => ['required', 'image', 'max:500'],
            'title' => ['required', 'string', 'max:200', 'unique:blogs,title'],
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $blog = new Blog();
        $blog->user_id = auth()->id();
        $alert = 'New Blog Is Created';
        $route = 'admin.blog.index';

        return $this->submitForm($request, $blog, $imagePath, $alert, $route);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = BlogCategory::active()->get();
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:500'],
            'title' => ['required', 'string', 'max:50', 'unique:blogs,title,'.$id],
        ]);

        $blog = Blog::findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', 'uploads', $blog->image);
        $blog->user_id = auth()->id();
        $alert = 'Blog Is Updated';
        $route = 'admin.blog.index';

        return $this->submitForm($request, $blog, $imagePath, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $this->deleteImage($blog->image);
        $blog->comments()->delete();
        $blog->delete();

        return response(['status' => 'success', 'message' => 'Blog Has Been Deleted']);
    }

    public function changeStatus(Request $request)
    {
        $blog = Blog::findOrFail($request->id);
        $blog->status = $request->status == 'true' ? 1 : 0;
        $blog->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function submitForm(Request $request, $blog, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:blog_categories,id'],
            'post_content' => ['required', 'string', 'max:10000'],
            'seo_title' => ['nullable', 'string', 'max:50'],
            'seo_description' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);

        if($imagePath != null){$blog->image = $imagePath;}
        $blog->category_id = $request->category_id;
        $blog->slug = Str::slug($request->title);
        $blog->title = $request->title;
        $blog->content = $request->post_content;
        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success($alert);
        flash($alert,'success');

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
