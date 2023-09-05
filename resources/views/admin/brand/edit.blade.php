@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Brand</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Brand</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.brand.update', $brand->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Logo</label>
                                <div>
                                    <img src="{{asset($brand->logo)}}" class="mt-3 mb-3" style="width: 15rem; height: 10rem;" alt="logo">
                                </div>
                                <input name="logo" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{$brand->name}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Is Featured</label>
                                <select name="is_featured" id="inputState" class="form-control">
                                    <option {{$brand->is_featured == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$brand->is_featured == 0 ? 'selected': ''}} value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option {{$brand->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$brand->status == 0 ? 'selected': ''}} value="0">Inactive</option>
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
