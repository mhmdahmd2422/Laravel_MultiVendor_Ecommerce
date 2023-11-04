@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Footer Data</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.footer-data.update', 1)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Footer Logo</label>
                                @if($footer_contact?->logo)
                                    <img width="100px" style="display: block; margin: 1rem 0 1rem 0;" class="bg-dark" src="{{asset($footer_contact->logo)}}">
                                @endif
                                <input name="logo" type="file" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" type="text" class="form-control" value="{{$footer_contact->phone?? old('phone')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" value="{{$footer_contact->email?? old('email')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" type="text" class="form-control" value="{{$footer_contact->address?? old('address')}}">
                            </div>
                            <div class="form-group">
                                <label>Copyrights</label>
                                <input name="copyrights" type="text" class="form-control" value="{{$footer_contact->copyrights?? old('copyrights')}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
