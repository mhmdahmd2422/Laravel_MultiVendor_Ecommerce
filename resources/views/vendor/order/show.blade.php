@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Order Details
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fal fa-gift-card"></i>Order Details</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <div class="container">
                                    <div class="wsus__invoice_area">
                                        <div class="invoice_print">
                                            <div class="wsus__invoice_header">
                                                <div class="wsus__invoice_content">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                            <div class="wsus__invoice_single">
                                                                <h5>Invoice To</h5>
                                                                <h6>Name: {{$order->user->name}}</h6>
                                                                <p>Email: {{$order->user->email}}</p>
                                                                <p>Phone: {{$address->phone}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                            <div class="wsus__invoice_single text-md-center">
                                                                <h5>shipping information</h5>
                                                                <h6>({{$shipping->name}})</h6>
                                                                <p>{{ucfirst($address->address_type)}}</p>
                                                                <p>{{$address->address}}</p>
                                                                <p>{{$address->comment?? ''}}</p>
                                                                <p>{{ucfirst($address->city).', '.$address->country}}
                                                                    {{$address->zip_code?? ''}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="wsus__invoice_single text-md-end">
                                                                <h5>Order Details</h5>
                                                                <h6>Order Status: <span id="order_status_label">{{config('order_status.order_status_vendor')[$order->order_status]['details']}}</span></h6>
                                                                <p>Invoice ID: #{{$order->invoice_id}}</p>
                                                                <p>Payment Type: {{ucfirst($order->payment_method)}}</p>
                                                                <p>Payment Status: {{$order->payment_status === 0? 'Pending': 'Completed'}}</p>
                                                                <p>Transaction ID: #{{$order->transaction->transaction_id}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wsus__invoice_description">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th>#</th>
                                                                <th class="name">
                                                                    product
                                                                </th>

                                                                <th class="amount">
                                                                    unit price
                                                                </th>

                                                                <th class="amount">
                                                                    variants price
                                                                </th>

                                                                <th class="quentity">
                                                                    quantity
                                                                </th>
                                                                <th class="total">
                                                                    total
                                                                </th>
                                                            </tr>
                                                            @foreach($order->products as $product)
                                                                @if($product->vendor_id === \Illuminate\Support\Facades\Auth::user()->vendor->id)
                                                                    @php
                                                                        $variants = json_decode($product->product_variants);
                                                                        $total = 0;
                                                                        $total += ($product->unit_price+$product->product_variants_total)*$product->quantity;
                                                                    @endphp
                                                                    <tr>
                                                                        <td><b>{{++$loop->index}}</b></td>
                                                                        <td class="name">
                                                                            <p>{{$product->product_name}}</p>
                                                                            @foreach($variants as $key => $value)
                                                                                <span>{{$key}} : {{$value->name}}</span>
                                                                            @endforeach
                                                                        </td>
                                                                        <td class="amount">
                                                                            {{$settings->currency_icon}}{{$product->unit_price}}
                                                                        </td>
                                                                        <td class="amount">
                                                                            {{$settings->currency_icon}}{{$product->product_variants_total}}
                                                                        </td>
                                                                        <td class="quentity">
                                                                            {{$product->quantity}}
                                                                        </td>
                                                                        <td class="total">
                                                                            {{$settings->currency_icon}}{{($product->unit_price+$product->product_variants_total)*$product->quantity}}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wsus__invoice_footer">
                                                <p><span>Total Amount:</span> {{$settings->currency_icon}}{{$total}} </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mt-5">
                                                    <label style="font-size: medium">Order Status</label>
                                                    <select class="form-control mt-1" id="order_status" data-id="{{$order->id}}">
                                                        @foreach(config('order_status.order_status_vendor') as $key => $status)
                                                            <option {{$key === $order->order_status? 'selected': ''}} value="{{$key}}">{{$status['status']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-primary mt-3" id="order_status_submit">Save</button>
                                                </div>
                                            </div>
                                            <div class="col-md-7">

                                            </div>
                                            <div class="col-md-1">
                                                <div class="text-md-right mt-5">
                                                    <button class="btn btn-warning btn-icon icon-left print-invoice"><i class="fas fa-print"></i> Print</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#order_status_submit').on('click', function (event){
                let statusSelect = $('#order_status');
                let status = statusSelect.val();
                let orderId = statusSelect.data('id');
                $.ajax({
                    method: 'GET',
                    url: '{{route('vendor.orders.status')}}',
                    data: {
                        status: status,
                        id: orderId,
                    },
                    success: function (data) {
                        if(data.status === 'success'){
                            $('#order_status_label').text(data.order_status);
                            toastr.success(data.message)
                        }
                    },
                    error: function (data){
                        console.log(data);
                    }
                })
            })
            $('.print-invoice').on('click', function (event){
                //before print
                let originalContents = $('body').html();
                let printBody = $('.invoice_print');
                $('body').html(printBody.html());
                window.print();
                $('body').html(originalContents);
            })
        })
    </script>
@endpush
{{--TODO: order status selected option after print--}}

