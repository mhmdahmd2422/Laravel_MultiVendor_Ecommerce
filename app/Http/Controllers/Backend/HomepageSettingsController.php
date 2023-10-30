<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class HomepageSettingsController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $popular_cat_section = HomepageSetting::where('key', 'popular_category_section')->first();

        return view('admin.homepage-setting.index',
            compact(
                'categories',
                'popular_cat_section'
            ));
    }

    public function updatePopularCategorySection(Request $request)
    {
//        dd($request->all());
        $data = [
            [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one
            ],
            [
                'category' => $request->cat_two,
                'sub_category' => $request->sub_cat_two,
                'child_category' => $request->child_cat_two
            ],
            [
                'category' => $request->cat_three,
                'sub_category' => $request->sub_cat_three,
                'child_category' => $request->child_cat_three
            ],
            [
                'category' => $request->cat_four,
                'sub_category' => $request->sub_cat_four,
                'child_category' => $request->child_cat_four
            ],
        ];

        HomepageSetting::updateOrCreate(
            ['key' => 'popular_category_section'],
            ['value' => json_encode($data)]
        );

        flash('Updated Popular Categories Section', 'success');

        return redirect()->back();

    }
}
