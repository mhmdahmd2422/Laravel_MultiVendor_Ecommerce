@extends('vendor.layouts.master')

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
                        <h3><i class="fal fa-gift-card"></i>Product Gallery</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <div class="card-header mb-3">
                                    <h4>Selected Product: {{$product->name}}</h4>
                                </div>
                                <form action="{{route('vendor.products-image-gallery.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Image <code>(Multiple Image Upload is Supported)</code></label>
                                        <input name="image[]" type="file" class="form-control mb-2 mt-2" multiple>
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-5 mt-2">Upload</button>
                                </form> <div class="row">
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Product Images</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $dataTable->table() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endpush

