@extends('frontend.dashboard.layouts.master')

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <h4 class="mb-4">basic information</h4>
                                <form method="post" action="{{route('user.profile.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-user-tie"></i>
                                                        <input name="name" type="text" value="{{Auth::user()->name}}" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-user-tie"></i>
                                                        <input name="username" type="text" value="{{Auth::user()->username}}" placeholder="User Name">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="far fa-phone-alt"></i>
                                                        <input name="phone" type="number" value="{{Auth::user()->phone}}" placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fal fa-envelope-open"></i>
                                                        <input name="email" type="email" value="{{Auth::user()->email}}" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-md-6">
                                            <div class="wsus__dash_pro_img">
                                                <img src="{{Auth::user()->image ? asset(Auth::user()->image) : asset('frontend/images/ts-2.jpg')}}" alt="img" class="img-fluid w-100">
                                                <input name="image" type="file">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <button class="common_btn mt-2" type="submit">submit</button>
                                        </div>
                                    </div>
                                </form>
                                    <hr class="mb-4 mt-4 ml-5 mr-5">
                                    <div class="wsus__dash_pass_change">
                                        <h4 class="mb-4">change password</h4>
                                        <form method="post" action="{{route('user.password.update')}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-unlock-alt"></i>
                                                        <input name="current_password" type="password" placeholder="Current Password">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-6">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-lock-alt"></i>
                                                        <input name="password" type="password" placeholder="New Password">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-lock-alt"></i>
                                                        <input name="password_confirmation" type="password" placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <button class="common_btn" type="submit">submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
