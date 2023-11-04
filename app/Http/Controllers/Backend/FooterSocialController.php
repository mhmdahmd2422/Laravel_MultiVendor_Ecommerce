<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterSocialDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterSocial;
use Illuminate\Http\Request;

class FooterSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterSocialDataTable $dataTable)
    {
        return $dataTable->render('admin.footer.footer-social-link.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-social-link.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request);

        $footer_social = new FooterSocial();

        $alert = 'New Social Link Created';
        $route = 'admin.footer-social.index';

        return $this->submitForm($request, $footer_social, $alert, $route);
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
        $footer_social = FooterSocial::findOrFail($id);

        return view('admin.footer.footer-social-link.edit', compact('footer_social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request);
        $footer_social = FooterSocial::findOrFail($id);
        $alert = 'Social Link Updated';
        $route = 'admin.footer-social.index';

        return $this->submitForm($request, $footer_social, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $footer_social = FooterSocial::findOrFail($id);
        $footer_social->delete();

        return response(['status' => 'success', 'message' => 'Social Link Has Been Deleted']);
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100'],
            'url' => ['required', 'URL', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);
    }

    public function submitForm(Request $request, $footer_social, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $footer_social->icon = $request->icon;
        $footer_social->url = $request->url;
        $footer_social->name = $request->name;
        $footer_social->status = $request->status;
        $footer_social->save();

        toastr()->success($alert);
        flash($alert, 'success');

        if ($route != null) {
            return redirect()->route($route);
        } else {
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request){
        $social_link = FooterSocial::findOrFail($request->id);
        $social_link->status = $request->status == 'true' ? 1 : 0;
        $social_link->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
