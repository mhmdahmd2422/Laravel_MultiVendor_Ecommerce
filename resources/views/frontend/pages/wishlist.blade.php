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
                                            <button class="btn-sm btn-danger wishlist-product-decrement">-</button>
                                            <input name="quantity" class="product-qty" type="text" min="1" max="100" value="1" readonly/>
                                            <button class="btn-sm btn-success wishlist-product-increment">+</button>
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
