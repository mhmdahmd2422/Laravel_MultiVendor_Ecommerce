<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $general_settings = GeneralSetting::first();
        return view('admin.settings.index', compact('general_settings'));
    }

    public function generalSettingsUpdate(Request $request)
    {
        $request->validate([
           'site_name' => ['required', 'string', 'max:50'],
            'layout' => ['required', 'string', 'max:3'],
            'contact_email' => ['required', 'email'],
            'currency_name' => ['required', 'string', 'max:3'],
            'currency_icon' => ['required', 'string', 'max:1'],
            'timezone' => ['required', 'string', 'max:50'],
        ]);


        $setting = GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->site_name,
                'layout' => $request->layout,
                'contact_email' => $request->contact_email,
                'currency_name' => $request->currency_name,
                'currency_icon' => $request->currency_icon,
                'timezone' => $request->timezone,
            ],
        );

        flash()->addSuccess('General Settings Has Been Updated');
        return redirect()->back();
    }
}
