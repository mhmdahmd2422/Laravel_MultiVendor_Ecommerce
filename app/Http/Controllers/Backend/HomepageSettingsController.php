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
        $categories = Category::active()->get();
        $popular_cat_section = HomepageSetting::where('key', 'popular_category_section')->first();
        $popular_cat_section = json_decode($popular_cat_section->value);
        $single_cat_section = HomepageSetting::where('key', 'single_category_section')->first();
        $single_cat_section = json_decode($single_cat_section->value);
        $single_cat_section_two = HomepageSetting::where('key', 'single_category_section_two')->first();
        $single_cat_section_two = json_decode($single_cat_section_two->value);
        $product_slider_section = HomepageSetting::where('key', 'product_slider_section')->first();
        $product_slider_section = json_decode($product_slider_section->value);
        return view('admin.homepage-setting.index',
            compact(
                'categories',
                'popular_cat_section',
                'single_cat_section',
                'single_cat_section_two',
                'product_slider_section',
            ));
    }

    public function updatePopularCategorySection(Request $request)
    {
        $request->validate([
            'cat_one' => ['required', 'integer'],
            'cat_two' => ['required', 'integer'],
            'cat_three' => ['required', 'integer'],
            'cat_four' => ['required', 'integer'],
        ],[
            'cat_one.required' => 'Category One Field Is Required',
            'cat_two.required' => 'Category Two Field Is Required',
            'cat_three.required' => 'Category Three Field Is Required',
            'cat_four.required' => 'Category Four Field Is Required',
        ]);
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

        return $this->categorySettingStore($data, $request->section);
    }

    public function updateSingleCategorySection(Request $request)
    {
        $request->validate([
            'cat_one' => ['required', 'integer'],
        ],[
            'cat_one.required' => 'Category Field Is Required',
        ]);
        $data = [
            [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one
            ],
        ];

        return $this->categorySettingStore($data, $request->section);
    }
    public function updateProductSliderSection(Request $request)
    {
        $request->validate([
            'cat_one' => ['required', 'integer'],
            'cat_two' => ['required', 'integer'],
        ],[
            'cat_one.required' => 'Part 1 Category Field Is Required',
            'cat_two.required' => 'Part 2 Category Two Field Is Required',
        ]);
        $data = [
            [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one
            ],[
                'category' => $request->cat_two,
                'sub_category' => $request->sub_cat_two,
                'child_category' => $request->child_cat_two
            ],
        ];

        return $this->categorySettingStore($data, $request->section);
    }

    public function categorySettingStore(array $data, string $key)
    {
        HomepageSetting::updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($data)]
        );

        flash('Updated Section Settings', 'success');

        return redirect()->back();
    }

}
