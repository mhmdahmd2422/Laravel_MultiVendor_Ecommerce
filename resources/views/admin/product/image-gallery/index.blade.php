@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Products Image Gallery</h1>
        </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Selected Product: {{$product->name}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.products-image-gallery.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Image <code>(Multiple Image Upload is Supported)</code></label>
                            <input name="image[]" type="file" class="form-control" multiple>
                            <input type="hidden" name="product" value="{{$product->id}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
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
</section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
