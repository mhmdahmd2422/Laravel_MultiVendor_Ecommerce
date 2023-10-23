@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Flash Sale
@endsection

@section('content')

<!--============================
        DAILY DEALS START
    ==============================-->
<section id="wsus__daily_deals">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header rounded-0">
                    <h3>flash sale</h3>
                    <div class="wsus__offer_countdown">
                        <span class="end_text">ends time :</span>
                        <div class="simply-countdown simply-countdown-one"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($flash_sale_items as $item)
            <div class="col-xl-3">
                <div class="wsus__offer_det_single">
                    <div class="wsus__product_item">
                        @if(productListing($item->product))
                            <span class="wsus__new">{{productListing($item->product)}}</span>
                        @endif
                        @if(checkDiscount($item->product))
                            <span class="wsus__minus">-{{discountPercent($item->product->price, $item->product->offer_price)}}%</span>
                        @endif
                        <a class="wsus__pro_link" href="{{route('product-detail.index', $item->product->slug)}}">
                            <img src="{{asset($item->product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                            @if(isset($item->product->gallery[1]))
                                <img src="{{asset($item->product->gallery->last()->image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @else
                                <img src="{{asset($item->product->thumb_image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @endif
                        </a>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">{{$item->product->category->name}}</a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(120 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="{{route('product-detail.index', $item->product->slug)}}">{{$item->product->name}}</a>
                            @if(checkDiscount($item->product))
                                <p class="wsus__price">{{$settings->currency_icon}}{{$item->product->offer_price}}
                                    <del>{{$settings->currency_icon}}{{$item->product->price}}</del>
                                </p>
                            @else
                                <p class="wsus__price">{{$settings->currency_icon}}{{$item->product->price}}
                                </p>
                            @endif
                            <form class="shopping-cart-form">
                                <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                @foreach($item->product->variants as $variant)
                                    <div class="d-none">
                                        <select class="select_2" name="variant_items[]">
                                            @foreach($variant->ActiveVariantItems as $VariantItem)
                                                <option {{$VariantItem->is_default == 1 ? 'selected' : ''}} value="{{$VariantItem->id}}">{{$VariantItem->name}} ({{$settings->currency_icon}}{{$VariantItem->price}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                                <input name="quantity" type="hidden" min="1" max="100" value="1" />
                                <button class="add_cart" href="#" type="submit">add to cart</button>
                            </form>
                        </div>
                    </div>
                    <div class="wsus__offer_progress">
                        <p><span>{{$item->product->quantity}} items left!</span></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($flash_sale_items->hasPages())
            <div class="mt-5">
                {{$flash_sale_items->links()}}
            </div>
        @endif
    </div>
</section>
<!--============================
    DAILY DEALS END
==============================-->

@endsection
@push('scripts')
    <script>
        var d = new Date(),
            countUpDate = new Date();
        d.setDate(d.getDate() + 90);
        console.log({{date('d', strtotime($flash_sale_date->end_date))}});
        $(document).ready(function (){
            simplyCountdown('.simply-countdown-one', {
                year: {{date('Y', strtotime($flash_sale_date->end_date))}},
                month: {{date('m', strtotime($flash_sale_date->end_date))}},
                day: {{date('d', strtotime($flash_sale_date->end_date))}},
            });
        })
    </script>
    <script>
        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //add product to cart
            $('.shopping-cart-form').on('submit', function (e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    data: formData,
                    url: '{{route('add-to-cart')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            getCartCount();
                            fetchSidebarCartProducts();
                            getSidebarCartSubtotal();
                            toastr.success(data.message);
                        }else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                        toastr.error(data.message);
                    }
                })
            })
            function getCartCount() {
                $.ajax({
                    method: 'GET',
                    url: '{{route('cart-count')}}',
                    success: function (data) {
                        $('#cart-count').text(data);
                    },
                    error: function (data) {
                        console.log(data)
                    }
                })
            }
            //update sidebar cart on change
            function fetchSidebarCartProducts(){
                $.ajax({
                    method: 'GET',
                    url: '{{route('cart-products')}}',
                    success: function (data) {
                        let miniCart = $('.mini_cart_wrapper');
                        miniCart.html('');
                        var html = '';
                        for(let item in data){
                            let product = data[item];
                            html += `<li>
                                    <div class="wsus__cart_img">
                                    <a href="{{url('product-detail')}}/${product.options.slug}"><img src="{{asset('/')}}${product.options.image}" alt="product" class="img-fluid w-100"></a>
                                    <a id="${product.rowId}" class="wsis__del_icon remove-sidebar-item" href="#"><i class="fas fa-minus-circle"></i></a>
                                    </div>
                                    <div class="wsus__cart_text">
                                    <a class="wsus__cart_title" href="{{url('product-detail')}}/${product.options.slug}">
                                    ${product.name}
                                    (${product.qty} item)
                                    </a>
                                    <p>{{$settings->currency_icon}}${product.price}</p>
                                    <small>Variants Per Item: {{$settings->currency_icon}}${product.options.variants_totalPrice}</small>
                                    </div>
                                    </li>`
                        }
                        miniCart.html(html);
                        if(miniCart.find('li').length === 0){
                            $('.mini_cart_actions').addClass('d-none');
                            miniCart.html('<li class="text-center">Cart Is Empty!</li>');
                        }else{
                            $('.mini_cart_actions').removeClass('d-none');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            }
            function getSidebarCartSubtotal(){
                $.ajax({
                    method: 'GET',
                    url: '{{route('cart-products-total')}}',
                    success: function (data) {
                        $('#mini_cart_subtotal').text("{{$settings->currency_icon}}"+data);
                    },
                    error: function (data) {
                        console.log(data)
                    }
                })
            }
        })
    </script>
@endpush
