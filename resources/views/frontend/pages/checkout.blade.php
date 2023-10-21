@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Checkout
@endsection

@section('content')
    <!--============================
        CHECK OUT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <form class="wsus__checkout_form">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="wsus__check_form">
                            <h5>Billing Details <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">add
                                    new address</a></h5>
                            <div class="row mb-5 saved-address">
                                @if($addresses->isEmpty())
                                    <p style="margin-top: 3rem;">No Saved Addrress! Please <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                                            New Address</a></p>
                                @endif
                                @foreach($addresses as $address)
                                <div class="col-xl-6">
                                    <div class="wsus__checkout_single_address">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                   id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Select Address
                                            </label>
                                        </div>
                                            <ul>
                                                <li><span>name :</span> {{$address->name}}</li>
                                                <li><span>Phone :</span> {{$address->phone}}</li>
                                                <li><span>country :</span> {{$address->country}}</li>
                                                <li><span>city :</span> {{$address->city}}</li>
                                                <li><span>zip code :</span> {{$address->zip_code? : 'Not Provided'}}</li>
                                                <li><span>address :</span> {{$address->address}}</li>
                                                <li><span>comment :</span> {{$address->comment? : 'Not Provided'}}</li>
                                            </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="wsus__order_details" id="sticky_sidebar">
                            <p class="wsus__product">shipping Methods</p>
                            @foreach($shippings as $shipping)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping" id="{{$shipping->id}}"
                                           value="{{$shipping->id}}" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        {{$shipping->name}}
                                        <span>(10 - 12 days)</span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="wsus__order_details_summery">
                                <p>subtotal: <span>{{$settings->currency_icon}}{{getCartTotal()}}</span></p>
                                <p>shipping fee: <span>$20.00</span></p>
                                <p>tax: <span>$00.00</span></p>
                                <p><b>total:</b> <span><b>$140.00</b></span></p>
                            </div>
                            <a href="payment.html" class="common_btn">Place Order</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{route('user.address.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input name="name" type="text" placeholder="Address Name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <div class="wsus__topbar_select">
                                                <select name="type" class="select_2">
                                                    <option value="">Address Type *</option>
                                                    <option {{old('type') == 'home' ? 'selected' : ''}} value="home">Home</option>
                                                    <option {{old('type') == 'office' ? 'selected' : ''}} value="office">Office</option>
                                                    <option {{old('type') == 'other' ? 'selected' : ''}} value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="country">
                                                <option value="">Country / Region *</option>
                                                @foreach($countries as $country_code => $country)
                                                    <option {{old('country') == $country ? 'selected' : ''}} value="{{$country}}">{{$country}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input name="city" type="text" placeholder="Town / City *" value="{{old('city')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input name="phone" type="text" placeholder="Phone *" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input name="zip_code" type="text" placeholder="Zip Code" value="{{old('zip_code')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input name="address" type="text" placeholder="Address Line *" value="{{old('address')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <textarea name="comment" cols="3" rows="3" placeholder="Additional Comment">{{old('comment')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form mt-4" style="float: right">
                                            <input name="route" type="hidden" value="{{'user.checkout'}}">
                                            <button type="submit" class="btn btn-primary">Save Address</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Increment product quantity and calc total onclick
            $('.form-check-input').on('click', function (e) {
                let shippingId = $('.form-check-input').val
                $.ajax({
                    url: '{{route('update-quantity')}}',
                    method: 'POST',
                    data: {
                        shipping_id: shippingId,
                    },
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(data.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                    }
                })
            })
        })
    </script>
@endpush
