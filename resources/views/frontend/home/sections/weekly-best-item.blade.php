<!--============================
    WEEKLY BEST ITEM START
==============================-->
<section id="wsus__weekly_best" class="home2_wsus__weekly_best_2 ">
    <div class="container">
        <div class="row">
        @foreach($product_slider_section as $section)
                @php
                    //check if sub/child is null? break: return last registered non-null
                    $lastKey = [];
                    foreach ($section as $key => $category){
                        if($category === null){
                            break;
                        }
                        $lastKey = [$key => $category];
                    }
                    if(array_keys($lastKey)[0] === 'category'){
                        $category = \App\Models\Category::find($lastKey['category']);
                        $products[] = \App\Models\Product::setEagerLoads([])
                        ->where('category_id', $category->id)
                        ->orderBy('id', 'DESC')
                        ->take(6)
                        ->get();
                    }elseif(array_keys($lastKey)[0] === 'sub_category'){
                        $category = \App\Models\SubCategory::find($lastKey['sub_category']);
                        $products[] = \App\Models\Product::setEagerLoads([])
                        ->where('sub_category_id', $category->id)
                        ->orderBy('id', 'DESC')
                        ->take(6)
                        ->get();
                    }else{
                        $category = \App\Models\ChildCategory::find($lastKey['child_category']);
                        $products[] = \App\Models\Product::setEagerLoads([])
                        ->where('child_category_id', $category->id)
                        ->orderBy('id', 'DESC')
                        ->take(6)
                        ->get();
                    }
                @endphp
            <div class="col-xl-6 col-sm-6">
                <div class="wsus__section_header">
                    <h3>{{$category->name}}</h3>
                </div>
                <div class="row weekly_best2">
                    @foreach($products as $key => $product)
                        @foreach($product as $item)
                            <div class="col-xl-4 col-lg-4">
                                <a class="wsus__hot_deals__single" href="{{route('product-detail.index', $item->slug)}}">
                                    <div class="wsus__hot_deals__single_img">
                                        <img src="{{asset($item->thumb_image)}}" alt="bag" class="img-fluid w-100">
                                    </div>
                                    <div class="wsus__hot_deals__single_text">
                                        <h5>{!! limitText($item->name) !!}</h5>
                                        <p class="wsus__rating">
                                            @php
                                                $avg_rate = $item->reviews()->avg('rate');
                                            @endphp
                                            @for($i = 0; $i<$avg_rate; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @for($j = $i; $j<5; $j++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                            <span>({{$item->reviews->count()}} review)</span>
                                        </p>
                                        @if(checkDiscount($item))
                                            <p class="wsus__tk">{{$settings->currency_icon}}{{$item->offer_price}} <del class="text-danger">{{$settings->currency_icon}}{{$item->price}}</del></p>
                                        @else
                                            <p class="wsus__tk">{{$settings->currency_icon}}{{$item->price}}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </div>
</section>
<!--============================
    WEEKLY BEST ITEM END
==============================-->
