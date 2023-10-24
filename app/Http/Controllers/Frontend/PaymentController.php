<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaypalSetting;
use App\Models\Product;
use App\Models\Transaction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function index()
    {
        if(!Session::has(['address', 'shipping'])){
            return redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

    public function storeOrder(
        $payment_method,
        $payment_status,
        $transaction_id,
        $payable_amount,
        $payable_currency)
    {
        $settings = GeneralSetting::first();

        //save order details here
        $order = new Order();
        $order->invoice_id = getToken();
        $order->user_id = Auth::user()->id;
        $order->sub_total = getMainCartTotal();
        $order->total = getPaymentAmount();
        $order->currency = $settings->currency_name;
        $order->currency_icon = $settings->currency_icon;
        $order->product_quantity = Cart::count();
        $order->payment_method = $payment_method;
        $order->payment_status = $payment_status;
        $order->order_address = json_encode(Session::get('address'));
        $order->order_shipping = json_encode(Session::get('shipping'));
        $order->order_coupon = json_encode(Session::get('coupon'));
        $order->order_status = 0;
        $order->save();

        //save product(s) in order here
        foreach (Cart::content() as $item){
            $product = Product::find($item->id);
            $order_product = new OrderProduct();
            $order_product->order_id = $order->id;
            $order_product->product_id = $product->id;
            $order_product->vendor_id = $product->vendor_id;
            $order_product->product_name = $product->name;
            $order_product->product_variants = json_encode($item->options->variants);
            $order_product->product_variants_total = $item->options->variants_totalPrice;
            $order_product->unit_price = $item->price;
            $order_product->quantity = $item->qty;
            $order_product->save();
        }

        //save transaction details here
        $trasaction = new Transaction();
        $trasaction->order_id = $order->id;
        $trasaction->transaction_id = $transaction_id;
        $trasaction->payment_method = $payment_method;
        $trasaction->amount = getPaymentAmount();
        $trasaction->converted_amount = $payable_amount;
        $trasaction->converted_amount_currency = $payable_currency;
        $trasaction->save();

    }

    public function clearSession()
    {
        Cart::destroy();
        Session::forget([
            'shipping',
            'address',
            'coupon',
        ]);
    }

    public function paypalConfig()
    {
        $paypal_settings = PaypalSetting::first();
        $config = [
            'mode'    => $paypal_settings->mode === 1? 'live': 'sandbox',
            'sandbox' => [
                'client_id'         => $paypal_settings->client_id,
                'client_secret'     => $paypal_settings->secret_key,
                'app_id'            => env('APP_KEY'),
            ],
            'live' => [
                'client_id'         => $paypal_settings->client_id,
                'client_secret'     => $paypal_settings->secret_key,
                'app_id'            => env('APP_KEY'),
            ],

            'payment_action' => 'Sale',
            'currency'       => $paypal_settings->currency,
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];
        return $config;
    }

    public function payWithPaypal()
    {
//        foreach (Cart::content() as $item){
//            dd($item->options->variants_totalPrice);
//            $order_product->product_variants_total = $item->options['variants_totalPrice'];
//
//        }
        $config = $this->paypalConfig();
        $paypalSettings = PaypalSetting::first();
        $appSettings = GeneralSetting::first();

        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        //calculate payment amount depend on currency rate
        $total = getPaymentAmount();
        if($appSettings->currency_name !== $paypalSettings->currency){
            $payableAmount = round($total * $paypalSettings->currency_rate, 2);
        }else{
            $payableAmount = $total;
        }

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.paypal.success'),
                "cancel_url" => route('user.paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value" => $payableAmount,
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != null){
            foreach ($response['links'] as $link){
                if($link['rel'] == 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }
        return redirect()->route('paypal.cancel');
    }

    public function Paypalsuccess(Request $request){
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if(isset($response['status']) && $response['status'] == 'COMPLETED'){
            //Add transaction data to DB and empty cart
            $paypalSettings = PaypalSetting::first();
            //calculate payment amount depend on currency rate
            $total = getPaymentAmount();
            $payable_amount = round($total * $paypalSettings->currency_rate, 2);
            $this->storeOrder('paypal', 1, $response['id'], $payable_amount, $paypalSettings->currency);
            //clear session
            $this->clearSession();
            return redirect()->route('user.payment.success');
        }
        return redirect()->route('user.paypal.cancel');
    }

    public function cancel(){
        //redirect to purchase page with error message
        flasher('Something Went Wrong!', 'error');
        return redirect()->route('user.payment');
    }

}
