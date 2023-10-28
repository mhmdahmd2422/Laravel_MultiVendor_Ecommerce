@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
        </div>
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">#{{$order->invoice_id}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{date('F d,Y', strtotime($order->created_at))}}<br><br>
                                    </address>
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        <div class="images mt-3">
                                            <img style="height: 2rem; width: 3rem;"
                                                @if($order->payment_method === 'paypal')
                                                {{"src=". url('backend/assets/img/paypal.png')}}
                                                    @elseif($order->payment_method === 'stripe')
                                                    {{"src=". url('backend/assets/img/stripe.svg')}}
                                                @endif
                                                >
                                            <b style="margin-top: 1rem; display: block;">Transaction
                                                ID: {{$order->transaction->transaction_id}}</b>
                                        </div>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Shipped To:</strong><br>
                                        <b>Name: </b>{{$order->user->name}}<br>
                                        ({{ucfirst($address->address_type)}})<br>
                                        <b>Address: </b>{{$address->address}}<br>
                                        {{$address->comment?? ''}}<br>
                                        {{ucfirst($address->city)}}{{$address->zip_code?? ''}}, {{$address->country}}
                                        <br>
                                        <b>Phone: </b>{{$address->phone}}<br>
                                        [{{$shipping->name}}]
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th class="text-center">Vendor</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Variants Total</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    @foreach($order->products as $product)
                                        @php
                                            $variants = json_decode($product->product_variants);
                                        @endphp
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td><a {{$product->product->slug? 'target="_blank"': ''}} href="{{$product->product->slug? route('product-detail.index', $product->product->slug): '#'}}"><b>{{$product->product_name}}</b></a>
                                                @foreach($variants as $type => $name)
                                                    <span
                                                        style="display: block; font-size: small">{{ucfirst($type)}}: {{ucfirst($name->name)}}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">{{$product->vendor->name}}</td>
                                            <td class="text-center">{{$order->currency_icon}}{{$product->unit_price}}</td>
                                            <td class="text-center">{{$product->quantity}}</td>
                                            <td class="text-center">{{$order->currency_icon}}{{$product->product_variants_total}}</td>
                                            <td class="text-right">{{$order->currency_icon}}{{($product->unit_price+$product->product_variants_total)*$product->quantity}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <div class="form-group order_status_section">
                                        <label>Order Status</label>
                                        <select name="order_status" id="order_status" data-id="{{$order->id}}" class="form-control">
                                            @foreach(config('order_status.order_status_admin') as $key => $value)
                                                <option {{$order->order_status === $key? 'selected': '' }} value="{{$key}}">{{$value['status']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group payment_status_section">
                                        <label>Payment Status</label>
                                        <select name="payment_status" id="payment_status" data-id="{{$order->id}}" class="form-control">
                                            <option {{$order->payment_status === 0? 'selected': ''}} value="0">Pending</option>
                                            <option {{$order->payment_status === 1? 'selected': ''}} value="1">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div
                                            class="invoice-detail-value">{{$order->currency_icon}}{{$order->sub_total}}</div>
                                    </div>
                                    @if($coupon)
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Discount</div>
                                            <div class="invoice-detail-value">
                                                @if($coupon->discount_type === 'amount')
                                                    -{{$order->currency_icon}}{{@$coupon->discount_value}}
                                                @elseif($coupon->discount_type === 'percent')
                                                    -{{$order->currency_icon}}{{getDiscountValueFromPercent(@$coupon->discount_value, $order->sub_total)}}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">
                                            +{{$order->currency_icon}}{{$shipping->cost}}</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div
                                            class="invoice-detail-value invoice-detail-value-lg">{{$order->currency_icon}}{{$order->total}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left print-invoice"><i class="fas fa-print"></i> Print</button>
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
            $('#order_status').on('change', function (event){
                let status = $(this).val();
                let orderId = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '{{route('admin.change-order-status')}}',
                    data: {
                        status: status,
                        id: orderId,
                    },
                    success: function (data) {
                        if(data.status === 'success'){
                            toastr.success(data.message)
                        }
                    },
                    error: function (data){
                        console.log(data);
                    }
                })
            })
            $('#payment_status').on('change', function (event){
                let status = $(this).val();
                let orderId = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '{{route('admin.change-payment-status')}}',
                    data: {
                        status: status,
                        id: orderId,
                    },
                    success: function (data) {
                        if(data.status === 'success'){
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
                $('.order_status_section').addClass('d-none');
                $('.payment_status_section').addClass('d-none');
                let printBody = $('.invoice-print');
                $('body').html(printBody.html());
                window.print();
                $('body').html(originalContents);
            })
        })
    </script>
@endpush
