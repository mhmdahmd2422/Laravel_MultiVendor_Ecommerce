@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
{{--                            <div class="form-group">--}}
{{--                                <label class="col-form-label mb-2">Thumbnail</label>--}}
{{--                                <div class="col-sm-12 col-md-7">--}}
{{--                                    <div id="image-preview" class="image-preview">--}}
{{--                                        <label for="image-upload" id="image-label">Choose File</label>--}}
{{--                                        <input type="file" name="thumb_image" id="image-upload" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <input  name="thumb_image" type="file" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product SKU</label>
                                        <input name="sku" type="text" class="form-control purchase-code" placeholder="ASDF-GHIJ-KLMN-OPQR" value="{{old('sku')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Quantity</label>
                                        <input name="quantity" type="number" class="form-control" value="{{old('quantity')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Video Link</label>
                                        <input name="video_link" type="url" class="form-control" value="{{old('video_link')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Product Category</label>
                                        <select name="category_id" id="inputState" class="form-control main-category">
                                            <option>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Sub-Category</label>
                                        <select name="sub_category_id" id="inputState" class="form-control sub-category">
                                            <option>Select Sub Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Child-Category</label>
                                        <select name="child_category_id" id="inputState" class="form-control child-category">
                                            <option>Select Child Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Product Brand</label>
                                        <select name="brand_id" id="inputState" class="form-control">
                                            <option>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" class="summernote-simple"></textarea>
                            </div><div class="form-group">
                                <label>Long Description</label>
                                <textarea name="long_description" class="summernote-simple"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    $
                                                </div>
                                            </div>
                                            <input name="price" type="number" class="form-control currency" value="{{old('price')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Offer Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    $
                                                </div>
                                            </div>
                                            <input name="offer_price" type="number" class="form-control currency" value="{{old('offer_price')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Offer Start Date</label>
                                        <input name="offer_start_date" type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Offer End Date</label>
                                        <input name="offer_end_date" type="text" class="form-control datepicker" value="{{old('offer_end_date')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="inputState">Listing Type</label>
                                        <select name="list_type" id="inputState" class="form-control">
                                            <option value="">Select</option>
                                            <option value="new_arrival">New Arrival</option>
                                            <option value="featured_product">Featured</option>
                                            <option value="top_product">Top Product</option>
                                            <option value="best_product">Best Product</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="inputState">Status</label>
                                        <select name="status" id="inputState" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Product SEO Title</label>
                                <input name="seo_title" type="text" class="form-control" value="{{old('seo_title')}}">
                            </div>
                            <div class="form-group">
                                <label>Product SEO Description</label>
                                <textarea name="seo_description" class="summernote-simple"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            $('body').on('change', '.main-category', function (e){
                let id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: '{{route('admin.get-subcategories')}}',
                    data: {
                        id: id,
                    },
                    success : function (data) {
                        $('.sub-category').html(`<option>Select Sub Category</option>`)
                        $.each(data, function (i, item){
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error : function (xhr, status, error) {
                        console.log(error);
                    }
                })
            })

            $('body').on('change', '.sub-category', function (e){
                let id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: '{{route('admin.get-childcategories')}}',
                    data: {
                        id: id,
                    },
                    success : function (data) {
                        $('.child-category').html(`<option>Select Child Category</option>`)
                        $.each(data, function (i, item){
                            $('.child-category').append(`<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error : function (xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush

