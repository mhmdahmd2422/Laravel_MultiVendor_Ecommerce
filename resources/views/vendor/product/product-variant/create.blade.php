@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Create Password
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="mb-3">
                            <a href="{{route('vendor.products.index')}}" class="btn btn-warning" ><i class="fas fa-chevron-left"  style="margin-right: 0.8rem"></i>Back</a>
                        </div>
                        <h3><i class="fal fa-gift-card"></i>Create Product Variant</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <div class="card-header mb-3">
                                    <h4>Selected Product: {{$product->name}}</h4>
                                </div>
                                <form action="{{route('vendor.products-variant.store')}}" method="post">
                                    @csrf
                                    <div class="wsus__dash_pro_single">
                                        <label>Variant Name</label>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}">
                                        <input name="product_id" type="hidden" class="form-control" value="{{$product->id}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label for="inputState" style="margin-right: 3.3rem">Status</label>
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
            </div>
        </div>
    </section>
@endsection

@push('scripts')

@endpush

