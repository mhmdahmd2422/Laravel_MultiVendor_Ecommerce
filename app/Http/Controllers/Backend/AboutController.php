<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:500']
        ]);
        $about = About::find(1);
        $imagePath = $this->uploadImage($request, 'image', 'uploads');
        About::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content,
                'image' => empty(!$imagePath)? $imagePath: $about?->image,
            ]
        );

        toastr('About Page Is Updated', 'success', 'success');
        flash('About Page Is Updated', 'success');

        return redirect()->back();
    }
}
