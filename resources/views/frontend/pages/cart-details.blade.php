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
                                            <a href="{{route('product-detail.index', $cartItem->options->slug)}}" style="font-weight: bold">{{$cartItem->name}}</a>
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
                            @if($cart_banner_one->status ==1)
                                <a href="{{$cart_banner_one->banner_url}}">
                                    <img class="img-fluid w-100" src="{{asset($cart_banner_one->banner_image)}}" alt="Banner">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            @if($cart_banner_two->status ==1)
                                <a href="{{$cart_banner_two->banner_url}}">
                                    <img class="img-fluid w-100" src="{{asset($cart_banner_two->banner_image)}}" alt="Banner">
                                </a>
                            @endif
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

