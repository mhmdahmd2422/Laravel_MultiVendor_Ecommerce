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
                        <h4>Create Product Variant</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.products-variant.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Variant Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                                <input name="product_id" type="hidden" class="form-control" value="{{$product->id}}">
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
