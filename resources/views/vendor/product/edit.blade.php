@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Edit Variant Item
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>Edit Product</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="col-xl-3 col-sm-8 col-md-8 mb-4">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{asset($product->thumb_image) ? asset($product->thumb_image) : asset('frontend/images/ts-2.jpg')}}"  alt="img" class="img-fluid w-100">
                                            <input  name="thumb_image" type="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
                                                <label>Product Name</label>
                                                <input name="name" type="text" class="form-control" value="{{$product->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
                                                <label>Product SKU</label>
                                                <input name="sku" type="text" class="form-control purchase-code" placeholder="ASDF-GHIJ-KLMN-OPQR" value="{{$product->sku}}">                                        </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
                                                <label>Product Quantity</label>
                                                <input name="quantity" type="number" class="form-control" value="{{$product->quantity}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
                                                <label>Video Link</label>
                                                <input name="video_link" type="url" class="form-control" value="{{$product->video_link}}">
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="wsus__dash_pro_single">
                                                <label for="inputState">Product Category</label>
                                                <select name="category_id" id="inputState" class="form-control main-category">
                                                    <option>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option {{$product->category_id == $category->id ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="wsus__dash_pro_single">
                                                <label for="inputState">Sub-Category</label>
                                                <select name="sub_category_id" id="inputState" class="form-control sub-category">
                                                    @foreach($sub_categories as $sub_category)
                                                        <option {{$product->sub_category_id == $sub_category->id ? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="wsus__dash_pro_single">
                                                <label for="inputState">Child-Category</label>
                                                <select name="child_category_id" id="inputState" class="form-control child-category">
                                                    @foreach($child_categories as $child_category)
                                                        <option {{$product->child_category_id == $child_category->id ? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="summernote-simple">{!! $product->short_description !!}</textarea>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="mb-2">Long Description</label>
                                        <textarea name="long_description" class="summernote">{!! $product->long_description !!}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
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
                                            <div class="wsus__dash_pro_single">
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
                                            <div class="wsus__dash_pro_single">
                                                <label>Offer Start Date</label>
                                                <input name="offer_start_date" type="text" class="form-control datepicker" value="{{$product->offer_start_date}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="wsus__dash_pro_single">
                                                <label>Offer End Date</label>
                                                <input name="offer_end_date" type="text" class="form-control datepicker" value="{{$product->offer_end_date}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <label for="inputState">Product Brand</label>
                                                <select name="brand_id" id="inputState" class="form-control">
                                                    <option>Select Brand</option>
                                                    @foreach($brands as $brand)
                                                        <option {{$product->brand_id == $brand->id ? 'selected': ''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="wsus__dash_pro_single">
                                                <label for="inputState" style="margin-right: 0.7rem">Status</label>
                                                <select name="status" id="inputState" class="form-control">
                                                    <option value="">Select</option>
                                                    <option {{$product->status == 1 ? 'selected': ''}} value="1">Active</option>
                                                    <option {{$product->status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label>Product SEO Title</label>
                                        <input name="seo_title" type="text" class="form-control" value="{{$product->seo_title}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <label>Product SEO Description</label>
                                        <textarea name="seo_description" class="summernote-simple">{!! $product->seo_description !!}</textarea>
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
    <script>
        $(document).ready(function (){
            $('body').on('change', '.main-category', function (e){
                let id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: '{{route('vendor.get-subcategories')}}',
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
                    url: '{{route('vendor.get-childcategories')}}',
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

