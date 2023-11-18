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
                        <h4>Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <div>
                                    <img src="{{asset($product->thumb_image)}}" class="mt-3 mb-3" style="width: 15rem; height: 10rem;" alt="thumb_image">
                                </div>
                                <input  name="thumb_image" type="file" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input name="name" type="text" class="form-control" value="{{$product->name}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product SKU</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-barcode"></i>
                                                </div>
                                            </div>
                                            <input name="sku" type="text" class="form-control purchase-code" placeholder="ASDF-GHIJ-KLMN-OPQR" value="{{$product->sku}}">                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Quantity</label>
                                        <input name="quantity" type="number" class="form-control" value="{{$product->quantity}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Video Link</label>
                                        <input name="video_link" type="url" class="form-control" value="{{$product->video_link}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Product Category</label>
                                        <select name="category_id" id="inputState" class="form-control main-category">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option {{$product->category_id == $category->id ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Sub-Category</label>
                                        <select name="sub_category_id" id="inputState" class="form-control sub-category">
                                            <option value="">Select Sub Category</option>
                                            @foreach($sub_categories as $sub_category)
                                                <option {{$product->sub_category_id == $sub_category->id ? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Child-Category</label>
                                        <select name="child_category_id" id="inputState" class="form-control child-category">
                                            <option value="" >Select Child Category</option>
                                            @foreach($child_categories as $child_category)
                                                <option {{$product->child_category_id == $child_category->id ? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputState">Product Brand</label>
                                        <select name="brand_id" id="inputState" class="form-control">
                                            <option>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option {{$product->brand_id == $brand->id ? 'selected': ''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" class="summernote-simple">{!! $product->short_description !!}</textarea>
                            </div><div class="form-group">
                                <label>Long Description</label>
                                <textarea name="long_description" class="summernote-simple">{!! $product->long_description !!}</textarea>
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
                                            <input name="price" type="number" class="form-control currency" value="{{$product->price}}">
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
                                            <input name="offer_price" type="number" class="form-control currency" value="{{$product->offer_price}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Offer Start Date</label>
                                        <input name="offer_start_date" type="text" class="form-control datepicker" value="{{$product->offer_start_date}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Offer End Date</label>
                                        <input name="offer_end_date" type="text" class="form-control datepicker" value="{{$product->offer_end_date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="inputState">Listing Type</label>
                                        <select name="list_type" id="inputState" class="form-control">
                                            <option value="">Select</option>
                                            <option {{$product->list_type == 'new_arrival' ? 'selected': ''}} value="new_arrival">New Arrival</option>
                                            <option {{$product->list_type == 'featured_product' ? 'selected': ''}} value="featured_product">Featured</option>
                                            <option {{$product->list_type == 'top_product' ? 'selected': ''}} value="top_product">Top Product</option>
                                            <option {{$product->list_type == 'best_product' ? 'selected': ''}} value="best_product">Best Product</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="inputState">Status</label>
                                        <select name="status" id="inputState" class="form-control">
                                            <option value="">Select</option>
                                            <option {{$product->admin_status == 1 ? 'selected': ''}} value="1">Active</option>
                                            <option {{$product->admin_status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Product SEO Title</label>
                                <input name="seo_title" type="text" class="form-control" value="{{$product->seo_title}}">
                            </div>
                            <div class="form-group">
                                <label>Product SEO Description</label>
                                <textarea name="seo_description" class="summernote-simple">{!! $product->seo_description !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                        $('.sub-category').html(`<option value="">Select Sub Category</option>`)
                        $('.child-category').html(`<option value="">Select Child Category</option>`)
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
                        $('.child-category').html(`<option value="">Select Child Category</option>`)
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

