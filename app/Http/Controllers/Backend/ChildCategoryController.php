<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.child-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'max:50', 'exists:categories,id'],
            'sub_category_id' => ['required', 'integer', 'max:50', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:50', 'unique:child_categories'],
            'status' => ['required', 'boolean',],
        ]);

        $child_category = new ChildCategory();
        $alert = 'A New Child-Category Has Been Created';
        $route = 'admin.child-category.index';

        return $this->submitForm($request, $child_category, $alert, $route);
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
        $categories = Category::all();
        $child_category = ChildCategory::findOrFail($id);
        $sub_categories = SubCategory::where('category_id', $child_category->category_id)->get();
        return view('admin.child-category.edit', compact('categories', 'sub_categories', 'child_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $child_category = ChildCategory::findOrFail($id);

        $request->validate([
            'category_id' => ['required', 'integer', 'max:50', 'exists:categories,id'],
            'sub_category_id' => ['required', 'integer', 'max:50', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:50', 'unique:App\Models\ChildCategory,name,'.$child_category->id],
            'status' => ['required', 'boolean',],
        ]);

        $alert = 'Child-Category Has Been Updated!';
        $route = 'admin.child-category.index';

        return $this->submitForm($request, $child_category, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $child_category = ChildCategory::findOrFail($id);
        $child_category->delete();

        return response(['status' => 'success', 'message' => 'Child-Category Has Been Deleted Successfully!']);
    }

    public function submitForm(Request $request, $child_category, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $child_category->category_id = $request->category_id;
        $child_category->sub_category_id = $request->sub_category_id;
        $child_category->name = $request->name;
        $child_category->slug = Str::slug($request->name);
        $child_category->status = $request->status;
        $child_category->save();

        toastr()->success($alert);

        if ($route != null) {
            return redirect()->route($route);
        } else {
            return redirect()->back();
        }
    }

    public function getSubCategories(Request $request){
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();

        return $subCategories;
    }

    public function changeStatus(Request $request){
        $child_category = ChildCategory::findOrFail($request->id);
        $child_category->status = $request->status == 'true' ? 1 : 0;
        $child_category->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
