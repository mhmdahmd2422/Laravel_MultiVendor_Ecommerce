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
                        <h4>Create Vendor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.vendor.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Banner</label>
                                <input name="banner" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input name="phone" type="text" class="form-control phone-number" value="{{old('phone')}}">
                                </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input name="email" type="email" class="form-control" value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" type="text" class="form-control" value="{{old('address')}}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="summernote"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Facebook URL</label>
                                <input name="fb_url" type="text" class="form-control" value="{{old('fb_url')}}">
                            </div>
                            <div class="form-group">
                                <label>Twitter URL</label>
                                <input name="tw_url" type="text" class="form-control" value="{{old('tw_url')}}">
                            </div>
                            <div class="form-group">
                                <label>Instagram URL</label>
                                <input name="insta_url" type="text" class="form-control" value="{{old('insta_url')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
