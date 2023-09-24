@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Variant</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Product Variant</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.products-variant.update', $variant->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Variant Name</label>
                                <input name="name" type="text" class="form-control" value="{{$variant->name}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option {{$variant->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$variant->status == 0 ? 'selected': ''}} value="0">Inactive</option>
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
