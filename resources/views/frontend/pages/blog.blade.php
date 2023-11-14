@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Blog
@endsection
@section('content')
<!--============================
    BLOGS PAGE START
==============================-->
<section id="wsus__blogs">
    <div class="container">
        <div class="row">
            @if(request()->search)
                <h5>Search Results For: <div style="display: inline; font-style: italic;">{{request()->search}}</div></h5>
                <hr class="mt-2">
            @elseif(request()->category)
                <h5>Search Results For: <div style="display: inline; font-style: italic;">{{request()->category}}</div></h5>
                <hr class="mt-2">
            @endif
            @if($blogs->isEmpty())
                <div class="card">
                    <div class="card-body text-center">
                        <h4>No Blogs Found</h4>
                    </div>
                </div>
            @endif
            @foreach($blogs as $blog)
                <div class="col-xl-4 col-sm-6 col-lg-4 col-xxl-3">
                    <div class="wsus__single_blog wsus__single_blog_2">
                        <a class="wsus__blog_img" href="{{route('blog.index', $blog->slug)}}">
                            <img src="{{asset($blog->image)}}" alt="blog" class="img-fluid w-100">
                        </a>
                        <div class="wsus__blog_text">
                            <a class="blog_top red" href="#">{{$blog->category->name}}</a>
                            <div class="wsus__blog_text_center">
                                <a href="{{route('blog.index', $blog->slug)}}">{{limitText($blog->title, 45)}}</a>
                                <p class="date">{{date('M d Y', strtotime($blog->created_at))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="pagination">
            <div class="mt-5">
                @if($blogs->isNotEmpty())
                    @if($blogs->hasPages())
                        {{$blogs->withQueryString()->links()}}
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
<!--============================
    BLOGS PAGE END
==============================-->

@endsection
@push('scripts')

@endpush
