@extends('admin.layouts.master')

@section('content')

<section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            @if($errors->all())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>{{ $error }}</strong>
                        <button type="button" class="close" data-bs-dismiss="alert" style="float: right; background: transparent;">×</button>
                    </div>
                @endforeach
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong style=" color: black;">{{ $message }}</strong>
                    <button type="button" class="close" data-bs-dismiss="alert" style="float: right; background: transparent;">×</button>
                </div>
            @endif
            <h2 class="section-title">Hi, {{Auth::user()->name}}!</h2>
            <p class="section-lead">
                Change Your Profile Details On This Page.
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Profile Info</h4>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="d-flex align-items-center justify-content-center m-4">
                                    <img alt="image" src="{{asset(Auth::user()->image)}}" class="rounded-circle profile-widget-picture " style="width: 4rem; height: 4rem;">
                                    <label class="ml-4">Change Photo -></label>
                                    <input type="file" name="image" class="form-control ml-4">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control" value="{{Auth::user()->name}}">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>User Name</label>
                                        <input name="username" type="text" class="form-control" value="{{Auth::user()->username}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input name="email" type="text" class="form-control" value="{{Auth::user()->email}}">
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input name="phone" type="tel" class="form-control" value="{{Auth::user()->phone}}">
                                    </div>
                                </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card">
                    <form method="post" action="{{route('admin.password.update')}}">
                        @csrf
                        <div class="card-header">
                            <h4>Edit Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group ml-4">
                                    <label>Old Password</label>
                                    <input name="current_password" type="password" class="form-control">
                                </div>
                                <div class="form-group ml-4">
                                    <label>New Password</label>
                                    <input name="password" type="password" class="form-control">
                                </div>
                                <div class="form-group ml-4">
                                    <label>Confirm New Password</label>
                                    <input name="password_confirmation" type="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
    </section>

@endsection
