@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Cart
@endsection

@section('content')
    <!--============================
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                <tr class="d-flex">
                                    <th class="wsus__pro_img">
                                        product item
                                    </th>
                                    <th class="wsus__pro_name">
                                        product details
                                    </th>
                                    <th class="wsus__pro_tk">
                                        unit price
                                    </th>
                                    <th class="wsus__pro_tk">
                                        total
                                    </th>
                                    <th class="wsus__pro_select">
                                        quantity
                                    </th>
                                    <th class="wsus__pro_icon">
                                        <a href="" class="common_btn clear-cart">clear cart</a>
                                    </th>
                                </tr>
                                @if($cartItems->isEmpty())
                                    <td style="height: 4rem; font-size: larger; background-color: #0088CC !important;" class="badge bg-primary ml-5 align-baseline">Cart is empty!</td>
                                @endif
                                    @foreach($cartItems as $cartItem)
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img"><img src="{{url(asset($cartItem->options->image))}}" alt="product"
                                                                       class="img-fluid w-50">
                                        </td>
                                        <td class="wsus__pro_name">
                                            <p style="font-weight: bold">{{$cartItem->name}}</p>
                                            @foreach($cartItem->options->variants as $variantName => $variantDetails)
                                                <span>{{$variantName}}: {{$variantDetails['name']}}
                                                    ({{$variantDetails['price'] != 0?
                                                        '+'.$settings->currency_icon.$variantDetails['price']:
                                                         'No Charge'}})
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="wsus__pro_tk unit_price">
                                            <h6>{{$settings->currency_icon}}{{$cartItem->price}}</h6>
                                        </td>
                                        <td class="wsus__pro_tk">
                                            <h6 id="{{$cartItem->rowId}}">
                                                {{$settings->currency_icon}}{{($cartItem->price + $cartItem->options->variants_totalPrice) * $cartItem->qty}}
                                            </h6>
                                        </td>
                                        <td class="wsus__pro_select">
                                            <form class="product_qty_wrapper">
                                                <button class="btn-sm btn-danger product-decrement">-</button>
                                                <input class="product-qty" data-rowid="{{$cartItem->rowId}}" type="text" min="1" max="100" value="{{$cartItem->qty}}" readonly/>
                                                <button class="btn-sm btn-success product-increment">+</button>
                                            </form>
                                        </td>
                                        <td class="wsus__pro_icon">
                                            <a class="remove-item" id="{{$cartItem->rowId}}" href=""><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span class="cart_subtotal">{{$settings->currency_icon}}{{getCartTotal()}}</span></p>
                        <p>discount: <span id="discount_total">-{{$settings->currency_icon}}{{getCartDiscount()}}</span>
                        </p>
                        <p class="total"><span>total:</span>
                            <span id="cart_total">
                                @if(Session::has('coupon'))
                                    @if(Session::get('coupon')['discount_type'] === 'amount')
                                        {{$settings->currency_icon}}{{getCartTotal() - (Session::get('coupon')['discount_value'])}}
                                    @elseif(Session::get('coupon')['discount_type'] === 'percent')
                                        {{$settings->currency_icon.getCartTotal() - (round(getCartTotal() * (Session::get('coupon')['discount_value']/100),2))}}
                                    @endif
                                @else
                                    {{$settings->currency_icon.getCartTotal()}}
                                @endif
                            </span></p>
                        <form id="coupon_form">
                            <input id="coupon-code" name="coupon_code" type="text" placeholder="Coupon Code">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <div id="coupon_tag">
                            @if(Session::has('coupon'))
                                <p>Coupon Applied: {{Session::get('coupon')['coupon_name']}}
                                    <a class="remove-item" id="remove-coupon" href="">
                                        <i class="far fa-times"></i></a>
                                </p>
                            @endif
                        </div>
                        <a class="common_btn mt-4 w-100 text-center" href="{{route('user.checkout')}}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{route('home')}}"><i
                                class="fab fa-shopify"></i>continue shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_2.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_3.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Increment product quantity and calc total onclick
            $('.product-increment').on('click', function(e){
                e.preventDefault();
                let input = $(this).siblings('.product-qty');
                let qty = parseInt(input.val()) +1;
                let row_id = input.data('rowid');
                $.ajax({
                    url: '{{route('update-quantity')}}',
                    method: 'POST',
                    data : {
                        row_id: row_id,
                        quantity: qty,
                    },
                    success: function (data) {
                        if(data.status === 'success'){
                            input.val(qty);
                            let productId = '#'+row_id;
                            let totalAmount = "{{$settings->currency_icon}}"+data.product_total;
                            $(productId).text(totalAmount);
                            getCartSubtotal();
                            calculateCouponDiscount();
                            getCartCount();
                            fetchSidebarCartProducts()
                            toastr.success(data.message);
                        }else if(data.status === 'error'){
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                    }
                })
            })
            // decrement product quantity and calc total onclick
            $('.product-decrement').on('click', function(e){
                e.preventDefault();
                let input = $(this).siblings('.product-qty');
                let qty = parseInt(input.val()) -1;
                let row_id = input.data('rowid');
                if(qty > 0){
                    input.val(qty);
                }else{
                    return;
                }
                $.ajax({
                    url: '{{route('update-quantity')}}',
                    method: 'POST',
                    data : {
                        row_id: row_id,
                        quantity: qty,
                    },
                    success: function (data) {
                        let productId = '#'+row_id;
                        let totalAmount = "{{$settings->currency_icon}}"+data.product_total;
                        $(productId).text(totalAmount);
                        getCartSubtotal();
                        calculateCouponDiscount();
                        getCartCount();
                        fetchSidebarCartProducts()
                        toastr.success(data.message);
                    },
                    error: function (data) {
                    }
                })
            })
            //remove item from cart
            $('.remove-item').on('click', function (e){
                e.preventDefault();
                let row_id = $(this).attr('id');
                $.ajax({
                        url: '{{route('remove-item')}}',
                        method: 'POST',
                        data: {
                            row_id: row_id,
                        },
                        success: function (data) {
                            fetchSidebarCartProducts();
                            calculateCouponDiscount();
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
            //remove item from sidebar cart
            $('body').on('click', '.remove-sidebar-item', function (e){
                e.preventDefault();
                let row_id = $(this).attr('id');
                $.ajax({
                    url: '{{route('remove-item')}}',
                    method: 'POST',
                    data: {
                        row_id: row_id,
                    },
                    success: function (data) {
                        // Reload the Page
                        location.reload();
                    },
                    error: function (data) {
                    }
                })
            })
            //clear cart button
            $('body').on('click', '.clear-cart', function (event){
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are You Sure You Want To Clear Cart?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: '{{route('clear-cart')}}',
                            success: function (data) {
                                if(data.status == 'success'){
                                    Swal.fire(
                                        'Cart Is Cleared!',
                                        data.message,
                                        'success'
                                    ).then((result) => {
                                        // Reload the Page
                                        location.reload();
                                    });
                                }else if (data.status == 'error'){
                                    location.reload();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }
                        })
                    }
                })
            })
            //add coupon to cart
            $('#coupon_form').on('submit', function (e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    data: formData,
                    url: '{{route('apply-coupon')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            calculateCouponDiscount();
                            $('#coupon_tag').html(
                                `<p>Coupon Applied: ${data.coupon_name}
                                <a class="remove-item" id="remove-coupon" href="">
                                <i class="far fa-times"></i></a>
                                </p>
                                `);
                            removeCoupon();
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
            //remove coupon from cart
            function removeCoupon(){
                var removeTag = $('#coupon_tag').find('a');
                removeTag.on('click', function (e){
                    e.preventDefault();
                    $.ajax({
                        method: 'GET',
                        url: '{{route('remove-coupon')}}',
                        success: function (data) {
                            if(data.status == 'success'){
                                $('#coupon_tag').html('');
                                $('#coupon_code').val('');
                                $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                                $('#cart_total').text("{{$settings->currency_icon}}"+data.cart_total);
                                toastr.success(data.message);
                            }else if (data.status == 'error') {
                                toastr.error(data.message);
                            }
                        },
                        error: function (data) {
                            console.log(data.message);
                        }
                    })
                })
            }
            var removeTag = $('#coupon_tag').find('a');
            removeTag.on('click', function (e){
                e.preventDefault();
                $.ajax({
                    method: 'GET',
                    url: '{{route('remove-coupon')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            $('#coupon_tag').html('');
                            $('#coupon_code').val('');
                            $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                            $('#cart_total').text("{{$settings->currency_icon}}"+data.cart_total);
                            toastr.success(data.message);
                        }else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                        console.log(data.message);
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
            //update sidebar on change
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
                                    <a href="${product.options.slug}"><img src="{{asset('/')}}${product.options.image}" alt="product" class="img-fluid w-100"></a>
                                    <a id="${product.rowId}" class="wsis__del_icon remove-sidebar-item" href="#"><i class="fas fa-minus-circle"></i></a>
                                    </div>
                                    <div class="wsus__cart_text">
                                    <a class="wsus__cart_title" href="${product.options.slug}">
                                    ${product.name}
                                    (${product.qty} item)
                                    </a>
                                    <p>{{$settings->currency_icon}}${product.price}</p>
                                    <smallVariants Per Item: {{$settings->currency_icon}}${product.options.variants_totalPrice}</small>
                                    </div>
                                    </li>`
                        }
                        miniCart.html(html);
                        getSidebarCartSubtotal();
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
            function getCartSubtotal(){
                $.ajax({
                    method: 'GET',
                    url: '{{route('cart-products-total')}}',
                    success: function (data) {
                        $('.cart_subtotal').text("{{$settings->currency_icon}}"+data);
                    },
                    error: function (data) {
                        console.log(data)
                    }
                })
            }
            function calculateCouponDiscount(){
                $.ajax({
                    method: 'GET',
                    url: '{{route('calculate-coupon')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            $('#discount_total').text("-{{$settings->currency_icon}}"+data.discount_value);
                            $('#cart_total').text("{{$settings->currency_icon}}"+data.new_cart_total);
                        }else if (data.status == 'error') {
                            $.ajax({
                                method: 'GET',
                                url: '{{route('remove-coupon')}}',
                                success: function (data) {
                                    if (data.status == 'success') {
                                        $('#coupon_tag').html('');
                                        $('#coupon_code').val('');
                                        $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                                        $('#cart_total').text("{{$settings->currency_icon}}" + data.cart_total);
                                        toastr.success(data.message);
                                    } else if (data.status == 'error') {
                                        toastr.error(data.message);
                                    }
                                },
                                error: function (data) {
                                    console.log(data.message);
                                }
                            })
                        }
                    },
                    error: function (data) {
                        toastr.error(data.message);
                    }
                })
            }
        })
    </script>
@endpush
