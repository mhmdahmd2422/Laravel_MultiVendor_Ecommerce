<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageUploadTrait;

    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'max:2048'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'button_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        $slider = new Slider();
        $imagePath = $this->uploadImage($request, 'banner', 'uploads');
        $alert = 'New Slider Has Been Created!';
        $route = 'admin.slider.index';

        return $this->submitForm($request, $slider, $imagePath, $alert, $route);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner' => ['image', 'max:2048'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'button_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        $slider = Slider::findOrFail($id);
        $imagePath = $this->updateImage($request, 'banner', 'uploads', $slider->banner);
        $alert = 'Slider Has Been Updated!';
        $route = 'admin.slider.index';

        return $this->submitForm($request, $slider, $imagePath, $alert, $route);
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $this->deleteImage($slider->banner);
        $slider->delete();

        return response(['status' => 'success', 'message' => 'Slider Has Been Deleted Successfully!']);
    }

    /**
     * @param Request $request
     * @param $slider
     * @param $alert
     * @param $route
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm(Request $request, $slider, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$slider->banner = $imagePath;}
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->button_url = $request->button_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
