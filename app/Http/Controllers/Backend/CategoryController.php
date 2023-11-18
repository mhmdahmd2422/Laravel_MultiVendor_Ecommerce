<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'string', 'max:50', 'not_in:empty'],
            'name' => ['required', 'string', 'max:50', 'unique:categories'],
            'status' => ['required', 'boolean',],
        ]);

        $category = new Category();
        $alert = 'A New Category Has Been Created';
        $route = 'admin.category.index';

        return $this->submitForm($request, $category, $alert, $route);
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
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'icon' => ['required', 'string', 'max:50', 'not_in:empty'],
            'name' => ['required', 'string', 'max:50', 'unique:App\Models\Category,name,'.$category->id],
            'status' => ['required', 'boolean',],
        ]);

        $alert = 'Category Has Been Updated!';
        $route = 'admin.category.index';

        return $this->submitForm($request, $category, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $sub_category = SubCategory::where('category_id', $category->id)->count();
        if($sub_category > 0){
            return response(['status' => 'error', 'message' => 'This Category contains Sub-Items!!']);
        }
        $products = Product::where('category_id', $category->id)->get();
        $response = checkBeforeCategoryDelete($category, 'category_id');
        //method will return model or response if check resulted error
        if(isset($response->id)){
            $response->delete();
            return response(['status' => 'success', 'message' => 'Category Has Been Deleted Successfully!']);
        }else{
            return $response;
        }
    }

    public function submitForm(Request $request, $category, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category = changeRelatedProductsAdminStatus($category, 'category_id', $request->status);
        $category->status = $request->status;
        $category->save();

        toastr()->success($alert);

        if ($route != null) {
            return redirect()->route($route);
        }else {
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request){
        $category = Category::findOrFail($request->id);
        $category = changeRelatedProductsAdminStatus($category, 'category_id', $request->status);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
