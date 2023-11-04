<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FooterData;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class FooterDataController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footer_contact = FooterData::first();

        return view('admin.footer.footer-data.index', compact('footer_contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'logo' => ['nullable', 'image', 'max:3000'],
           'phone' => ['nullable', 'phone'],
           'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:300'],
            'copyrights' => ['nullable', 'string', 'max:300'],
        ]);

        $footer_data = FooterData::find($id);
        $imagePath = $this->updateImage($request, 'logo', 'uploads', $footer_data?->logo);

        FooterData::updateOrCreate(
           ['id' => $id],
           [
               'logo' => empty(!$imagePath)? $imagePath: $footer_data?->logo,
               'phone' => $request->phone,
               'email' => $request->email,
               'address' => $request->address,
               'copyrights' => $request->copyrights,
           ]
        );

        flash('Updated Footer Contact Info', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
