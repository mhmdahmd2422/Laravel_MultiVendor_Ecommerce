@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Variant Item</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product Variant Item</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.product-variant-items.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Variant Name</label>
                                <input name="variant_name" type="text" class="form-control" value="{{$variant->name}}" readonly>
                                <input name="variant_id" type="hidden" class="form-control" value="{{$variant->id}}">
                                <input name="product_id" type="hidden" class="form-control" value="{{$product->id}}">
                            </div>
                            <div class="form-group">
                                <label>Variant Item Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>Item Price <code>(Set 0 For Free Item)</code></label>
                                <input name="price" type="number" step="any" class="form-control" value="{{old('price')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Is Default?</label>
                                <select name="is_default" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
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
