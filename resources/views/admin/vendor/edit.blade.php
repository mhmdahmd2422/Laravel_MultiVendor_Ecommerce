@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Vendor</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Vendor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.vendor.update', $vendor->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Banner</label>
                                <div>
                                    <img src="{{asset($vendor->banner)}}" class="mt-3 mb-3" style="width: 15rem; height: 10rem;" alt="banner">
                                </div>
                                <input name="banner" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{$vendor->name}}">
                            </div>
                            <div class="form-group">
                                <label>User ID</label>
                                <input name="user_id" type="text" class="form-control" value="{{$vendor->user_id}}">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input name="phone" type="text" class="form-control phone-number" value="{{$vendor->phone}}">
                                </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input name="email" type="email" class="form-control" value="{{$vendor->email}}">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" type="text" class="form-control" value="{{$vendor->address}}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="summernote">{{$vendor->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Facebook URL</label>
                                <input name="fb_url" type="text" class="form-control" value="{{$vendor->fb_link}}">
                            </div>
                            <div class="form-group">
                                <label>Twitter URL</label>
                                <input name="tw_url" type="text" class="form-control" value="{{$vendor->tw_link}}">
                            </div>
                            <div class="form-group">
                                <label>Instagram URL</label>
                                <input name="insta_url" type="text" class="form-control" value="{{$vendor->insta_link}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{$vendor->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$vendor->status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
