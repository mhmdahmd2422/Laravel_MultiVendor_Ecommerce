@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Wishlist
@endsection

@section('content')
<!--============================
    CART VIEW PAGE START
==============================-->
<section id="wsus__cart_view">
    <div class="container">
        <div class="row">
            @if($wishlist_items->isEmpty())
                <div class="col-xl-12">
                    <div class="wsus__cart_list cart_empty p-3 p-sm-5 text-center">
                        <p class="mb-4">your wishlist is empty</p>
                        <a href="{{route('products.index')}}" class="common_btn">
                            <i class="fal fa-store me-2"></i>
                            add products
                        </a>
                    </div>
                </div>
            @else
            <div class="col-12">
                <div class="wsus__cart_list wishlist">
                    <div class="table-responsive">
                        <table>
                            <tbody>
                            <tr class="d-flex">
                                <th class="wsus__pro_img">
                                    product photo
                                </th>

                                <th class="wsus__pro_name">
                                    product name
                                </th>

                                <th class="wsus__pro_status">
                                    stock
                                </th>

                                <th class="wsus__pro_tk">
                                    unit price
                                </th>

                                <th class="wsus__pro_select">
                                    quantity
                                </th>

                                <th class="wsus__pro_icon">
                                    options
                                </th>
                            </tr>
                            @foreach($wishlist_items as $item)
                                <tr class="d-flex">
                                    <td class="wsus__pro_img"><img src="{{asset($item->product->thumb_image)}}" alt="product"
                                                                   class="img-fluid w-100">
                                        <a class="remove-wishlist-item" data-id="{{$item->id}}" href=""><i class="far fa-times"></i></a>
                                    </td>

                                    <td class="wsus__pro_name">
                                        <a href="{{route('product-detail.index', $item->product->slug)}}"><p>{{$item->product->name}}</p></a>
                                    </td>


                                    <td class="wsus__pro_status">
                                        @if(checkStock($item->product))
                                            <p style="color: darkgreen !important;">in stock</p>
                                        @else
                                            <p style="color: darkred !important;">Out of stock</p>
                                        @endif
                                    </td>

                                    <td class="wsus__pro_tk">
                                        @if(checkDiscount($item->product))
                                            <h6 class="text-center">{{$settings->currency_icon}}{{$item->product->offer_price}} <del class="text-danger" style="display: block; margin-right: 0px">{{$settings->currency_icon}}{{$item->product->price}}</del></h6>
                                        @else
                                            <h6>{{$settings->currency_icon}}{{$item->product->price}}</h6>
                                        @endif
                                    </td>
                                    <form class="shopping-cart-form">
                                        <td class="wsus__pro_select">
                                            <button class="btn-sm btn-danger product-decrement">-</button>
                                            <input name="product_qty" class="product-qty" type="text" min="1" max="100" value="1" readonly/>
                                            <button class="btn-sm btn-success product-increment">+</button>
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                            <input type="hidden" name="wishlist_id" value="{{$item->id}}">
                                            @foreach($item->product->variants as $variant)
                                                <div class="d-none">
                                                    <select class="select_2" name="variant_items[]">
                                                        @foreach($variant->ActiveVariantItems as $item)
                                                            <option {{$item->is_default == 1 ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                            <button class="add_cart" href="#" type="submit">add to cart</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--============================
    CART VIEW PAGE END
==============================-->
@endsection

@push('scripts')
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
                    url: '{{route('user.wishlist.add-to-cart')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            toastr.success(data.message);
                            location.reload();
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
            //remove item from wishlist
            $('.remove-wishlist-item').on('click', function (e){
                e.preventDefault();
                let wishItem_id = $(this).data('id');
                $.ajax({
                    url: '{{route('user.wishlist.destroy')}}',
                    method: 'POST',
                    data: {
                        id: wishItem_id,
                    },
                    success: function (data) {
                        Swal.fire(
                            'Removed',
                            data.message,
                            'success'
                        ).then((result) => {
                            // Reload the Page
                            location.reload();
                        });
                    },
                    error: function (data) {
                    }
                })
            })
            // Increment product quantity
            $('.product-increment').on('click', function(e){
                e.preventDefault();
                let input = $(this).siblings('.product-qty');
                let qty = parseInt(input.val()) +1;
                input.val(qty);
            })
            // decrement product quantity
            $('.product-decrement').on('click', function(e){
                e.preventDefault();
                let input = $(this).siblings('.product-qty');
                let qty = parseInt(input.val()) -1;
                if(qty > 0){
                    input.val(qty);
                }else{
                    return;
                }
            })
        })
    </script>
@endpush
