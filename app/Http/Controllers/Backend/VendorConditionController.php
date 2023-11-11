<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\VendorCondition;
use Illuminate\Http\Request;

class VendorConditionController extends Controller
{
    public function index()
    {
        $condition = VendorCondition::first();
        return view('admin.vendor-condition.index', compact('condition'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
        ]);

        VendorCondition::updateOrCreate(
          ['id' => 1],
          ['content' => $request->content]
        );

        toastr('Vendor Conditions Is Updated', 'success', 'success');
        flash('Vendor Conditions Is Updated', 'success');

        return redirect()->back();
    }
}
