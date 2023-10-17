@extends('frontend.layouts.master')
@section('title')
    {{$settings->site_name}} || Forget Password
@endsection
@section('content')
<!--============================
    FORGET PASSWORD START
==============================-->
<section id="wsus__login_register">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 m-auto">
                <div class="wsus__forget_area">
                    <span class="qiestion_icon"><i class="fal fa-question-circle"></i></span>
                    <h4>forgot your password ?</h4>
                    <p>enter the email address you registered with <span>e-shop</span></p>
                    <div class="wsus__login">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="wsus__login_input">
                                <i class="fal fa-envelope"></i>
                                <input id="email"name="email" type="email" value="{{old('email')}}" placeholder="Your Email">
                            </div>
                            <button class="common_btn" type="submit">send reset link to mail</button>
                        </form>
                    </div>
                    <a class="see_btn mt-4" href="{{ route('login') }}">go to login</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    FORGET PASSWORD END
==============================-->
@endsection
