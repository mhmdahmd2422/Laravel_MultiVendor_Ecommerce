<!--============================
    HEADER START
==============================-->
<header>
    <div class="container">
        <div class="row">
            <div class="col-2 col-md-1 d-lg-none">
                <div class="wsus__mobile_menu_area">
                    <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                </div>
            </div>
            <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                <div class="wsus_logo_area">
                    <a class="wsus__header_logo" href="{{route('home')}}">
                        <img src="{{asset($info->logo)}}" alt="logo" class="img-fluid w-100">
                    </a>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                <div class="wsus__search">
                    <form action="{{route('products.index')}}">
                        <input name="search" type="text" placeholder="Search..." value="{{request()->search}}">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                <div class="wsus__call_icon_area">
                    <div class="wsus__call_area">
                        <div class="wsus__call">
                            <i class="fas fa-user-headset"></i>
                        </div>
                        <div class="wsus__call_text">
                            <p>{{$info->email}}</p>
                            <p>{{$info->phone}}</p>
                        </div>
                    </div>
                    <ul class="wsus__icon_area">
                        <li><a href="{{route('user.wishlist.index')}}"><i class="fal fa-heart"></i><span class="wishlist_count">{{auth()->check()? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0}}</span></a></li>
{{--                        <li><a href="compare.html"><i class="fal fa-random"></i><span>03</span></a></li>--}}
                        <li><a class="wsus__cart_icon" href="#"><i
                                    class="fal fa-shopping-bag"></i><span id="cart-count">{{Cart::count()}}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wsus__mini_cart">
        <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
        <ul class="mini_cart_wrapper">
            @foreach(Cart::content() as $SidebarCartItem)
            <li>
                <div class="wsus__cart_img">
                    <a href="{{route('product-detail.index', $SidebarCartItem->options->slug)}}"><img src="{{asset($SidebarCartItem->options->image)}}" alt="product" class="img-fluid w-100"></a>
                    <a id="{{$SidebarCartItem->rowId}}" class="wsis__del_icon remove-sidebar-item" href="#"><i class="fas fa-minus-circle"></i></a>
                </div>
                <div class="wsus__cart_text">
                    <a class="wsus__cart_title" href="{{route('product-detail.index', $SidebarCartItem->options->slug)}}">
                        {{$SidebarCartItem->name}}
                        <small>({{$SidebarCartItem->qty}} Item)</small>
                    </a>
                    <p>{{$settings->currency_icon}}{{$SidebarCartItem->price}}</p>
                    <small>Variants Per Item: {{$settings->currency_icon}}{{$SidebarCartItem->options->variants_totalPrice}}</small>
                </div>
            </li>
            @endforeach
            @if(Cart::content()->isEmpty())
                <li class="text-center">Cart Is Empty!</li>
            @endif
        </ul>
        <div class="mini_cart_actions {{Cart::content()->isEmpty()? 'd-none' : ''}}">
            <h5>sub total <span id="mini_cart_subtotal">{{$settings->currency_icon}}{{getCartTotal()}}</span></h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn" href="{{route('cart-details')}}">view cart</a>
                <a class="common_btn" href="{{route('user.checkout')}}">checkout</a>
            </div>
        </div>
    </div>

</header>

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
            //update bag icon counter
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
                        fetchSidebarCartProducts();
                        getSidebarCartSubtotal();
                        getCartCount();
                        toastr.success(data.message);
                    },
                    error: function (data) {
                    }
                })
            })
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
<!--============================
    HEADER END
==============================-->


<!--============================
    MAIN MENU START
==============================-->
@include('frontend.layouts.menu')
<!--============================
    MAIN MENU END
==============================-->

