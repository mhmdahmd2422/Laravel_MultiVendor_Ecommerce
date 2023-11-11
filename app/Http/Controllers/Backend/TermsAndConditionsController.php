<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TermsAndConditions;
use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    public function index()
    {
        $terms = TermsAndConditions::first();
        return view('admin.terms-and-conditions.index', compact('terms'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
        ]);

        TermsAndConditions::updateOrCreate(
            ['id' => 1],
            ['content' => $request->content]
        );

        toastr('Terms And Conditions Is Updated', 'success', 'success');
        flash('Terms And Conditions Is Updated', 'success');

        return redirect()->back();
    }
}
