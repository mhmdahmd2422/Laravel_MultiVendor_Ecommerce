@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || About Us
@endsection
@section('content')
<!--============================
    TERMS & CONDITION START
==============================-->
<section id="wsus__terms_condition">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h2>terms and condition</h2>
            </div>
            <div class="col-xl-12">
                <div class="wsus__terms_text">
                    <div class="card">
                        <div class="card-body">
                            <p>{!! @$terms->content !!}</p>

                            <h4>Contact Us</h4>
                            <p>If you have any questions about this Agreement, please contact us filling this <a
                                    href="contact.html">contact form</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    TERMS & CONDITION END
==============================-->

@endsection
@push('scripts')

@endpush
