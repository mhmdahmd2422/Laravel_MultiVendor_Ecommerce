@php
    //check if sub/child is null? break: return last registered non-null
    $lastKey = [];
    foreach ($single_cat_section_two[0] as $key => $category){
        if($category === null){
            break;
        }
        $lastKey = [$key => $category];
    }
    if(array_keys($lastKey)[0] === 'category'){
        $category = \App\Models\Category::find($lastKey['category']);
        $products = \App\Models\Product::setEagerLoads([])
        ->activeApproved()
        ->where('category_id', $category->id)
        ->orderBy('id', 'DESC')
        ->take(12)
        ->get();
    }elseif(array_keys($lastKey)[0] === 'sub_category'){
        $category = \App\Models\SubCategory::find($lastKey['sub_category']);
        $products = \App\Models\Product::setEagerLoads([])
        ->activeApproved()
        ->where('sub_category_id', $category->id)
        ->orderBy('id', 'DESC')
        ->take(12)
        ->get();
    }else{
        $category = \App\Models\ChildCategory::find($lastKey['child_category']);
        $products = \App\Models\Product::setEagerLoads([])
        ->activeApproved()
        ->where('child_category_id', $category->id)
        ->orderBy('id', 'DESC')
        ->take(12)
        ->get();
    }
@endphp
<!--============================
    ELECTRONIC PART START
==============================-->
<section id="wsus__electronic2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header">
                    <h3>{{$category->name}}</h3>
                    <a class="see_btn" href=
                        "@php
                        if(array_keys($lastKey)[0] === 'category') echo route('products.index', ['category' => $category->slug]);
                        elseif (array_keys($lastKey)[0] === 'sub_category') echo route('products.index', ['sub_category' => $category->slug]);
                        else echo route('products.index', ['child_category' => $category->slug]);
                        @endphp"
                    >see more <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">
            @foreach($products as $product)
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        @if(productListing($product))
                            <span class="wsus__new">{{productListing($product)}}</span>
                        @endif
                        @if(checkDiscount($product))
                            <span class="wsus__minus">-{{discountPercent($product->price, $product->offer_price)}}%</span>
                        @endif
                        <a class="wsus__pro_link" href="{{route('product-detail.index', $product->slug)}}">
                            <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                            @if(isset($product->gallery[1]))
                                <img src="{{asset($product->gallery->last()->image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @else
                                <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @endif
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$product->id}}"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#" class="add-to-wishlist" data-id="{{$product->id}}"><i class="far fa-heart"></i></a></li>
{{--                            <li><a href="#"><i class="far fa-random"></i></a>--}}
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">{{$product->category->name}}</a>
                            <p class="wsus__pro_rating">
                                @php
                                    $avg_rate = $product->reviews()->avg('rate');
                                @endphp
                                @for($i = 0; $i<$avg_rate; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for($j = $i; $j<5; $j++)
                                    <i class="far fa-star"></i>
                                @endfor
                                <span>({{$product->reviews->count()}} review)</span>
                            </p>
                            <a class="wsus__pro_name" href="{{route('product-detail.index', $product->slug)}}">{{$product->name}}</a>
                            @if(checkDiscount($product))
                                <p class="wsus__price">{{$settings->currency_icon}}{{$product->offer_price}}
                                    <del>{{$settings->currency_icon}}{{$product->price}}</del>
                                </p>
                            @else
                                <p class="wsus__price">{{$settings->currency_icon}}{{$product->price}}
                                </p>
                            @endif
                            <form class="shopping-cart-form">
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                @foreach($product->variants as $variant)
                                    <div class="d-none">
                                        <select class="select_2" name="variant_items[]">
                                            @foreach($variant->ActiveVariantItems as $item)
                                                <option {{$item->is_default == 1 ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                                <input name="quantity" type="hidden" min="1" max="100" value="1" />
                                <button class="add_cart" href="#" type="submit">add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @foreach($products as $product)
            <section class="product_popup_modal">
                <div class="modal fade" id="exampleModal-{{$product->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                        class="far fa-times"></i></button>
                                <div class="row">
                                    <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                        <div class="wsus__quick_view_img">
                                            @if($product->video_link)
                                                <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                                   href="{{$product->video_link}}">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            @endif
                                            <div class="row modal_slider">
                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{url(asset($product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                                    </div>
                                                </div>
                                                @if($product->gallery->isNotEmpty())
                                                    @foreach($product->gallery as $image)
                                                        <div class="col-xl-12">
                                                            <div class="modal_slider_img">
                                                                <img src="{{url(asset($image->image))}}" alt="product" class="img-fluid w-100">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-xl-12">
                                                        <div class="modal_slider_img">
                                                            <img src="{{url(asset($product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="wsus__pro_details_text">
                                            <a class="title" href="#">{{$product->name}}</a>
                                            <p class="wsus__stock_area">
                                                @if(checkStock($product))
                                                    <span class="in_stock">in stock</span>
                                                @else
                                                    <span class="out_stock">out of stock</span>
                                                @endif
                                                <span>({{$product->quantity}} item)</span>
                                            </p>
                                            @if(checkDiscount($product))
                                                <h4>{{$settings->currency_icon}}{{$product->offer_price}}.00 <del>{{$settings->currency_icon}}{{$product->price}}.00</del></h4>
                                            @else
                                                <h4>{{$settings->currency_icon}}{{$product->price}}</h4>
                                            @endif
                                            <p class="review">
                                                @php
                                                    $avg_rate = $product->reviews()->avg('rate');
                                                @endphp
                                                @for($i = 0; $i<$avg_rate; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @for($j = $i; $j<5; $j++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                                <span>({{$product->reviews->count()}} review)</span>
                                            </p>
                                            <p class="description" style="font-style: italic; font-size: large">“ {{$product->short_description}} ”</p>
                                            <p class="brand_model"><span style="font-weight: bold">model :</span> {{$product->sku?? 'Not Provided'}} </p>
                                            <p class="brand_model mb-4"><span style="font-weight: bold">brand :</span> {{$product->brand->name}}</p>
                                            @if(checkDiscount($product))
                                                <div class="wsus_pro_hot_deals">
                                                    <h5>offer ending In : </h5>
                                                    <div class="simply-countdown simply-countdown-one"></div>
                                                </div>
                                            @endif
                                            <form class="shopping-cart-form">
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                @foreach($product->variants as $variant)
                                                    <div class="wsus__selectbox">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-sm-6">
                                                                <h5 class="mb-2">select {{$variant->name}}:</h5>
                                                                <select class="select_2" name="variant_items[]">
                                                                    @foreach($variant->ActiveVariantItems as $variantItem)
                                                                        <option {{$variantItem->is_default == 1 ? 'selected' : ''}} value="{{$variantItem->id}}">{{$variantItem->name}} ({{$settings->currency_icon}}{{$variantItem->price}})</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="wsus__quentity">
                                                    <h5>quantity :</h5>
                                                    <div class="select_number">
                                                        <input name="quantity" class="number_area" type="text" min="1" max="{{$product->quantity}}" value="1" />
                                                    </div>
                                                    <h3>$50.00</h3>
                                                </div>
                                                <ul class="wsus__button_area">
                                                    <li><button type="submit" class="add_cart" href="#">add to cart</button></li>
                                                    <li><a class="buy_now" href="#">buy now</a></li>
                                                    <li><a href="#" class="add-to-wishlist" data-id="{{$product->id}}"><i class="far fa-heart"></i></a></li>
{{--                                                    <li><a href="#"><i class="far fa-random"></i></a></li>--}}
                                                </ul>
                                            </form>
                                            <div class="wsus__pro_det_share">
                                                <h5>share :</h5>
                                                <ul class="d-flex">
                                                    <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                                    <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>
</section>
<!--============================
    ELECTRONIC PART END
==============================-->

@push('scripts')

@endpush
