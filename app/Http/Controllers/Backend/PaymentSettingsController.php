<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\PayPal;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $paypal_settings = PaypalSetting::first();
        return view('admin.payment-settings.index', compact('paypal_settings'));
    }

}
