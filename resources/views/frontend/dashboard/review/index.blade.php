@extends('frontend.dashboard.layouts.master')

@section('title')
    {{$settings->site_name}} || My Reviews
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-star"></i>my reviews ({{@$reviews->count()}} reviews)</h3>
                        <div class="wsus__dashboard_review">
                            <div class="row">
                                @foreach($reviews as $review)
                                    <div class="col-xl-6">
                                        <div class="wsus__dashboard_review_item">
                                            <div class="wsus__dash_rev_img">
                                                <a href="{{route('product-detail.index', $review->product->slug)}}"><img src="{{asset($review->product->thumb_image)}}" alt="product" class="img-fluid w-100"></a>
                                            </div>
                                            <div class="wsus__dash_rev_text">
                                                <h5><a href="{{route('product-detail.index', $review->product->slug)}}">{{$review->product->name}}</a>
                                                    @if($review->status === 0)
                                                        <span class="badge badge-danger text-danger">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger text-success">Posted</span>
                                                    @endif
                                                    <span>{{date('d-m-y', strtotime($review->updated_at))}}</span>
                                                </h5>
                                                <p class="wsus__dash_review">
                                                    @for($i = 0; $i < $review->rate; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </p>
                                                <p class="mt-2 mb-4">"{{$review->review}}"</p>
                                                <ul class="mb-4">
                                                    @foreach($review->images as $review_image)
                                                        <li><img height="200" width="200" src="{{asset($review_image->image)}}" alt="product"
                                                                 class="img-fluid"></li>
                                                    @endforeach
                                                </ul>
                                                <ul>
                                                    <li><a href="#" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$review->id}}"><i
                                                                class="fal fa-edit"></i> edit</a></li>
                                                    <li><a href="{{route('user.review.destroy', $review->id)}}" class="delete-item"><i class="far fa-minus-circle"></i> delete</a></li>
                                                </ul>
                                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                                    <div class="accordion-item">
                                                        <div id="flush-collapse-{{$review->id}}" class="accordion-collapse collapse"
                                                             aria-labelledby="flush-collapseOne" data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <form action="{{route('user.review.update', $review->id)}}" method="post">
                                                                    @csrf
                                                                    <div class="wsus__riv_edit_single">
                                                                        <i class="fas fa-star"></i>
                                                                        <select name="rate" class="select_2" name="state">
                                                                            <option {{$review->rate === 1? 'selected': ''}} value="1">1</option>
                                                                            <option {{$review->rate === 2? 'selected': ''}} value="2">2</option>
                                                                            <option {{$review->rate === 3? 'selected': ''}} value="3">3</option>
                                                                            <option {{$review->rate === 4? 'selected': ''}} value="4">4</option>
                                                                            <option {{$review->rate === 5? 'selected': ''}} value="5">5</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="wsus__riv_edit_single text_area">
                                                                        <i class="far fa-edit"></i>
                                                                        <textarea name="review" cols="3" rows="3" placeholder="Your Review">{{$review->review}}</textarea>
                                                                    </div>
                                                                    <button type="submit" class="common_btn">submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    <div class="mt-5">
                                        @if($reviews->hasPages())
                                            {{$reviews->links()}}
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
