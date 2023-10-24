<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class StripeSettingsController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'boolean'],
            'mode' => ['required', 'boolean'],
            'country' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'currency_rate' => ['required', 'numeric'],
            'client_id' => ['required', 'string'],
            'secret_key' => ['required', 'string'],
        ]);

        $setting = StripeSetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
                'mode' => $request->mode,
                'country' => $request->country,
                'currency' => $request->currency,
                'currency_rate' => $request->currency_rate,
                'client_id' => $request->client_id,
                'secret_key' => $request->secret_key
            ]
        );
        flasher('Updated Successfully!', 'success');
        return redirect()->back();
    }
}
