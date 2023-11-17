<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class CodSettingsController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $setting = CodSetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
            ]
        );
        flasher('Updated Successfully!', 'success');
        return redirect()->back();
    }
}
