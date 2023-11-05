<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $general_settings = GeneralSetting::first();
        $email_settings = EmailConfiguration::first();
        return view('admin.settings.index',
            compact(
                'general_settings',
                'email_settings'
            )
        );
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

    public function emailSettingsUpdate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'host' => ['required', 'string'],
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:50'],
            'port' => ['required', 'numeric'],
            'encryption' => ['required', 'string', 'max:3'],
        ]);

        $setting = EmailConfiguration::updateOrCreate(
            ['id' => 1],
            [
                'email' => $request->email,
                'host' => $request->host,
                'username' => $request->username,
                'password' => $request->password,
                'port' => $request->port,
                'encryption' => $request->encryption,
            ],
        );

        flash()->addSuccess('Email Settings Has Been Updated');
        return redirect()->back();
    }
}
