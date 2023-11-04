<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterGridTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridTitle;
use App\Models\FooterGridTwo;
use Illuminate\Http\Request;

class FooterGridTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterGridTwoDataTable $dataTable)
    {
        $grid_title = FooterGridTitle::first();
        return $dataTable->render('admin.footer.footer-grid-two.index', compact('grid_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-grid-two.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request);
        $grid_tab = new FooterGridTwo();
        $alert = 'New Grid Tab Created';
        $route = 'admin.footer-grid-two.index';

        return $this->submitForm($request, $grid_tab, $alert, $route);
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
        $footer_grid_two = FooterGridTwo::findOrFail($id);

        return view('admin.footer.footer-grid-two.edit', compact('footer_grid_two'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request);
        $grid_tab = FooterGridTwo::findOrFail($id);
        $alert = 'Grid Tab Is Updated';
        $route = 'admin.footer-grid-two.index';

        return $this->submitForm($request, $grid_tab, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grid_tab = FooterGridTwo::findOrFail($id);
        $grid_tab->delete();

        return response(['status' => 'success', 'message' => 'Grid Tab Has Been Deleted']);
    }

    public function changeTitle(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:50']
        ]);

        FooterGridTitle::updateOrCreate(
          ['id' => 1],
          ['grid_two_title' => $request->title]
        );
        flash('Grid Two Title Is Updated', 'success');

        return redirect()->back();
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'url' => ['required', 'URL', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);
    }

    public function submitForm(Request $request, $grid_tab, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $grid_tab->name = $request->name;
        $grid_tab->url = $request->url;
        $grid_tab->status = $request->status;
        $grid_tab->save();

        toastr()->success($alert);
        flash($alert, 'success');

        if ($route != null) {
            return redirect()->route($route);
        } else {
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request){
        $grid_tab = FooterGridTwo::findOrFail($request->id);
        $grid_tab->status = $request->status == 'true' ? 1 : 0;
        $grid_tab->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
