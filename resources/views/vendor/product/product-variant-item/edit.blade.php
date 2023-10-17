@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Variant Item
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>Edit Product Variant</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.product-variant-items.update', $item->id)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="wsus__dash_pro_single">
                                        <label>Variant Name</label>
                                        <input name="variant_name" type="text" class="form-control" value="{{$item->variant->name}}" readonly>
                                        <input name="variant_id" type="hidden" class="form-control" value="{{$item->variant->id}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label>Variant Item Name</label>
                                        <input name="name" type="text" class="form-control" value="{{$item->name}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label>Item Price <code>(Set 0 For Free Item)</code></label>
                                        <input name="price" type="number" step="any" class="form-control" value="{{$item->price}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label for="inputState" style="margin-right: 3.3rem">Is Default?</label>
                                        <select name="is_default" class="form-control">
                                            <option {{$item->status == 1 ? 'selected': ''}} value="1">Active</option>
                                            <option {{$item->status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label for="inputState" style="margin-right: 3.3rem">Status</label>
                                        <select name="status" id="inputState" class="form-control">
                                            <option {{$item->status == 1 ? 'selected': ''}} value="1">Yes</option>
                                            <option {{$item->status == 0 ? 'selected': ''}} value="0">No</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush


