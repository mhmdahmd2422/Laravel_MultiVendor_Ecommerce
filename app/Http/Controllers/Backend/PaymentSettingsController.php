<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use App\Models\StripeSetting;
use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\PayPal;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $paypal_settings = PaypalSetting::first();
        $stripe_settings = StripeSetting::first();
        return view('admin.payment-settings.index',
            compact(
                'paypal_settings',
                'stripe_settings',
            )
        );
    }

}
