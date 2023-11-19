@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Order Tracking
@endsection
@section('content')
<!--============================
    TRACKING ORDER START
==============================-->
<section id="wsus__login_register">
    <div class="container">
        <div class="wsus__track_area">
            <div class="row">
                <div class="col-xl-5 col-md-10 col-lg-8 m-auto">
                    <form class="tack_form" id="track-form">
                        <h4 class="text-center">order tracking</h4>
                        <p class="text-center">track your order status</p>
                        <div class="wsus__track_input">
                            <label class="d-block mb-2">invoice id*</label>
                            <input id="invoice-id" name="invoice_id" type="text" placeholder="H25-21578455">
                        </div>
                        <div class="wsus__track_input">
                            <label class="d-block mb-2">email address*</label>
                            <input id="email" name="email" type="email" placeholder="Email">
                        </div>
                        <button id="track-submit" type="submit" class="common_btn">track</button>
                    </form>
                </div>
            </div>
            <div class="row track-info d-none">
                <div class="col-xl-12">
                    <div class="wsus__track_header">
                        <div class="wsus__track_header_text">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6 col-lg-3">
                                    <div class="wsus__track_header_single">
                                        <h5>Ordered At:</h5>
                                        <p id="order-date"></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-lg-3">
                                    <div class="wsus__track_header_single">
                                        <h5>Ordered by:</h5>
                                        <p id="order-name"></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-lg-3">
                                    <div class="wsus__track_header_single">
                                        <h5>status:</h5>
                                        <p id="order-status"></p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-lg-3">
                                    <div class="wsus__track_header_single border_none">
                                        <h5>payment method:</h5>
                                        <p id="order-payment"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <ul class="progtrckr" data-progtrckr-steps="4">
                        <li class="progtrckr_done icon_one check_mark">Order pending</li>
                        <li class="progtrckr_done icon_two ">order Processing</li>
                        <li class="icon_three">on the way</li>
                        <li class="icon_four">delivered</li>
                    </ul>
                </div>
                <div class="col-xl-12">
                    <a href="{{route('home')}}" class="common_btn"><i class="fas fa-chevron-left"></i> back to Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    TRACKING ORDER END
==============================-->

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#track-form').on('submit', function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            let sendBtn = $('#track-submit');
            $.ajax({
                method: 'POST',
                url: '{{route('order-track.track')}}',
                data: formData,
                beforeSend: function () {
                    $('.track-info').addClass('d-none');
                    sendBtn.css({'background' : '#0088CC'});
                    sendBtn.html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                    sendBtn.attr('disabled', true);
                },
                success: function (data) {
                    if(data.status === 'success'){
                        sendBtn.css({'background' : '#198754'});
                        sendBtn.html('<i class="fas fa-check"></i>');
                        resetTrackSendBtn();
                        $('.track-info').removeClass('d-none');
                        $('#order-date').text(data.order_at);
                        $('#order-name').text(data.order_by);
                        $('#order-status').text(data.order_status);
                        $('#order-payment').text(data.payment);
                        orderProgress(data.order_status);
                    }else{
                        sendBtn.css({'background' : '#dc3545'});
                        sendBtn.html('Error');
                        toastr.error('Something Went Wrong!');
                        resetTrackSendBtn();
                    }
                },
                error: function (data) {
                    let errors = data.responseJSON.errors;
                    console.log(errors);
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    })
                    sendBtn.css({'background' : '#dc3545'});
                    sendBtn.html('Error');
                    resetTrackSendBtn();
                }
            })
        })
        function orderProgress(orderStatus) {
            if(
                orderStatus === 'Processed and ready to ship' ||
                orderStatus === 'Dropped-Off' ||
                orderStatus === 'Out for delivery' ||
                orderStatus === 'Delivered' ||
                orderStatus === 'Shipped'
            ){
                $('.icon_two').addClass('check_mark');
            }
            if(
                orderStatus === 'Delivered' ||
                orderStatus === 'Out for delivery'
            ){
                $('.icon_three').addClass('check_mark');
            }
            if(
                orderStatus === 'Delivered'
            ){
                $('.icon_four').addClass('check_mark');
            }
        }
        function resetTrackSendBtn() {
            setTimeout(
                function()
                {
                    let sendBtn = $('#track-submit');
                    sendBtn.attr('disabled', false);
                    sendBtn.css({'background' : '#0088CC', 'class' : 'common_btn'});
                    sendBtn.html('Track');
                }, 1500);
        }
    })
</script>
@endpush
