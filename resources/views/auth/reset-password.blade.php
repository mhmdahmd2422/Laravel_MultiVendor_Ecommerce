@extends('frontend.layouts.master')

@section('content')


<!--============================
    CHANGE PASSWORD START
==============================-->
<section id="wsus__login_register">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-md-10 col-lg-7 m-auto">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="wsus__change_password">
                        <h4>reset password</h4>
                        <div class="wsus__single_pass">
                            <label>email</label>
                            <input id="email" name="email" type="email" value="{{old('email', $request->email)}}" placeholder="E-mail" autocomplete="username">
                        </div>
                        <div class="wsus__single_pass">
                            <label>new password</label>
                            <input id="password" name="password" type="password" placeholder="New Password" autocomplete="new-password">
                        </div>
                        <div class="wsus__single_pass">
                            <label>confirm password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password" autocomplete="new-password">
                        </div>
                        <button class="common_btn" type="submit">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--============================
    CHANGE PASSWORD END
==============================-->
@endsection
