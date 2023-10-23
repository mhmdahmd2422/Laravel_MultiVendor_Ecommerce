@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Payment
@endsection
@section('content')
    <!--============================
        PAYMENT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <h2>Payment Successful!</h2>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->

@endsection
@push('scripts')

@endpush
