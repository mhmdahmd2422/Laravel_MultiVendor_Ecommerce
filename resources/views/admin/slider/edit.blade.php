@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Slider</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.slider.update', $slider->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Banner</label>
                                <div>
                                    <img src="{{asset($slider->banner)}}" class="mt-3 mb-3" style="width: 15rem; height: 10rem;" alt="banner">
                                </div>
                                <input name="banner" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <input name="type" type="text" class="form-control" value="{{$slider->type}}">
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input name="title" type="text" class="form-control" value="{{$slider->title}}">
                            </div>
                            <div class="form-group">
                                <label>Starting Price</label>
                                <input name="starting_price" type="number" step="any" class="form-control" value="{{$slider->starting_price}}">
                            </div>
                            <div class="form-group">
                                <label>Button URL</label>
                                <input name="button_url" type="text" class="form-control" value="{{$slider->button_url}}">
                            </div>
                            <div class="form-group">
                                <label>Serial Order</label>
                                <input name="serial" type="text" class="form-control" value="{{$slider->serial}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option {{$slider->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$slider->status == 0 ? 'selected': ''}} value="0">Inactive</option>
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
