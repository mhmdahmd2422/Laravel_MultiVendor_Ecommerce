<!--============================
   MONTHLY TOP PRODUCT START
==============================-->
<section id="wsus__monthly_top" class="wsus__monthly_top_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="wsus__monthly_top_banner">
                    <div class="wsus__monthly_top_banner_img">
                        @if($banner_one->status ==1)
                        <a href="{{$banner_one->banner_url}}">
                            <img class="img-fluid w-100" src="{{asset($banner_one->banner_image)}}" alt="Banner">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header for_md">
                    <h3>Popular Categories</h3>
                    <div class="monthly_top_filter">
                        @php
                            $products = [];
                        @endphp
                        @foreach($popular_categories as $popular_category)
                            @php
                                //check if sub/child is null? break: return last registered non-null
                                $lastKey = [];
                                foreach ($popular_category as $key => $category){
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
                                    ->take(12)
                                    ->get();
                                }elseif(array_keys($lastKey)[0] === 'sub_category'){
                                    $category = \App\Models\SubCategory::find($lastKey['sub_category']);
                                    $products[] = \App\Models\Product::setEagerLoads([])
                                    ->where('sub_category_id', $category->id)
                                    ->orderBy('id', 'DESC')
                                    ->take(12)
                                    ->get();
                                }else{
                                    $category = \App\Models\ChildCategory::find($lastKey['child_category']);
                                    $products[] = \App\Models\Product::setEagerLoads([])
                                    ->where('child_category_id', $category->id)
                                    ->orderBy('id', 'DESC')
                                    ->take(12)
                                    ->get();
                                }
                            @endphp
                            <button class="{{$loop->index === 0? 'auto_click active': ''}}" data-filter=".category-{{$loop->index}}">{{$category->name}}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row grid">
                    @foreach($products as $key => $product)
                        @foreach($product as $item)
                            <div class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3  category-{{$key}}">
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
        </div>
    </div>
</section>
<!--============================
   MONTHLY TOP PRODUCT END
==============================-->


