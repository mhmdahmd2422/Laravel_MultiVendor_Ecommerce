<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'max:50', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:50', 'unique:sub_categories'],
            'status' => ['required', 'boolean',],
        ]);

        $sub_category = new SubCategory();
        $alert = 'A New Sub-Category Has Been Created';
        $route = 'admin.sub-category.index';

        return $this->submitForm($request, $sub_category, $alert, $route);
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
        $sub_category = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', compact('categories', 'sub_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sub_category = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => ['required', 'integer', 'max:50', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:50', 'unique:App\Models\SubCategory,name,'.$sub_category->id],
            'status' => ['required', 'boolean',],
        ]);

        $alert = 'Sub-Category Has Been Updated!';
        $route = 'admin.sub-category.index';

        return $this->submitForm($request, $sub_category, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->delete();

        return response(['status' => 'success', 'message' => 'Sub-Category Has Been Deleted Successfully!']);
    }

    public function submitForm(Request $request, $sub_category, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $sub_category->category_id = $request->category_id;
        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug($request->name);
        $sub_category->status = $request->status;
        $sub_category->save();

        toastr()->success($alert);

        if ($route != null) {
            return redirect()->route($route);
        } else {
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request){
        $sub_category = SubCategory::findOrFail($request->id);
        $sub_category->status = $request->status == 'true' ? 1 : 0;
        $sub_category->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
