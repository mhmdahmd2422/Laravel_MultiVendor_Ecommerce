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
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="wsus__check_form">
                        <div class="d-flex">
                            <h3>Shipping Details</h3>
                            <a class="common_btn" href="" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: auto">
                                Add New Address</a>
                        </div>
                        <div class="row mb-5 saved-address">
                            @if($addresses->isEmpty())
                                <p style="margin-top: 2rem;">
                                    No Saved Addresses! Please Add An Address
                                </p>
                            @endif
                            @foreach($addresses as $address)
                            <div class="col-xl-6">
                                <div class="wsus__checkout_single_address">
                                    <div class="form-check">
                                        <input class="form-check-input address-input" data-id="{{$address->id}}" type="radio" name="flexRadioDefault"
                                               id="flexRadioDefault1">
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
                        <p class="wsus__product">shipping Method</p>
                        @foreach($shippings as $shipping)
                            <div class="form-check">
                                <input class="form-check-input shipping-input" type="radio" name="shipping"
                                       value="{{$shipping->id}}">
                                <label class="form-check-label" for="exampleRadios1">
                                    {{$shipping->name}}
                                    <span>(10 - 12 days)</span>
                                </label>
                            </div>
                        @endforeach
                        <div class="wsus__order_details_summery">
                            <p>subtotal: <span id="cart_subtotal">{{$settings->currency_icon}}{{getCartTotal()}}</span></p>
                            <p>discount: <span>-{{$settings->currency_icon}}{{getCartDiscount()}}</span></p>
                            <p>shipping fee: <span id="shipping_fee">+$0</span></p>
                            <p><b>total:</b> <span><b id="cart_total">{{$settings->currency_icon}}{{getMainCartTotal()}}</b></span></p>
                        </div>
                        <div class="terms_area">
                            <div class="form-check">
                                <input class="form-check-input agree-terms" type="checkbox" value="" id="flexCheckChecked3">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    I have read and agree to the website <a href="{{route('terms-and-conditions.index')}}">terms and conditions *</a>
                                </label>
                            </div>
                        </div>
                        <form action="" id="checkoutForm">
                            <input type="hidden" name="shipping_method_id" value="" id="shipping_method_id" >
                            <input type="hidden" name="shipping_address_id" value="" id="shipping_address_id" >
                        </form>
                        <a href="" id="submitCheckoutForm" class="common_btn">Place Order</a>
                    </div>
                </div>
            </div>
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
            //reset selectors and form values
            $('input[type="radio"]').prop('checked', false);
            $('#shipping_address_id').val("");
            $('#shipping_method_id').val("");

            //set chosen address
            $('.address-input').on('click', function (e) {
                $('#shipping_address_id').val($(this).data('id'));
            })
            // apply shipping method
            $('.shipping-input').on('click', function (e) {
                let shippingId = $(this).val();
                $.ajax({
                    url: '{{route('user.apply-shipping')}}',
                    method: 'POST',
                    data: {
                        shipping_id: shippingId,
                    },
                    success: function (data) {
                        if (data.status === 'success') {
                            $('#shipping_method_id').val(shippingId);
                            $('#cart_subtotal').text('{{$settings->currency_icon}}'+data.cart_total);
                            $('#shipping_fee').text('+{{$settings->currency_icon}}'+data.shipping_cost);
                            $('#cart_total').text('{{$settings->currency_icon}}'+data.new_cart_total);
                        } else if (data.status === 'error') {
                            $('.shipping-input').prop('checked', false);
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                    }
                })
            })
            //submit checkout form
            $('#submitCheckoutForm').on('click', function(event){
                event.preventDefault();
                if($('#shipping_address_id').val() == '') {
                    toastr.error('Please Select Shipping Address');
                }else if(!$('.agree-terms').prop('checked')){
                    toastr.error('Please Accept To Terms And Conditions');
                }else if($('#shipping_method_id').val() == ''){
                    toastr.error('Please Select Shipping Method');
                }else{
                    $.ajax({
                        url: '{{route('user.checkout-submit')}}',
                        method: 'POST',
                        data: $('#checkoutForm').serialize(),
                        beforeSend: function () {
                            $('#submitCheckoutForm').html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                        },
                        success: function (data){
                            if(data.status === 'success'){
                                $('#submitCheckoutForm').css({'background' : '#198754'});
                                $('#submitCheckoutForm').html('Going To Payment...');
                                //redirect user to payment page
                                window.location.href = data.redirect_url;
                            } else if (data.status == 'error') {
                                $('#submitCheckoutForm').css({'background' : '#dc3545'});
                                $('#submitCheckoutForm').html('Something Went Wrong');
                                toastr.error(data.message);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    })
                }
            })
        })
    </script>
@endpush
