@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Blog
@endsection
@section('content')
<!--============================
    BLOGS DETAILS START
==============================-->
<section id="wsus__blog_details">
    <div class="container">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-8">
                <div class="wsus__main_blog">
                    <div class="wsus__main_blog_img">
                        <img src="{{asset($blog->image)}}" alt="blog" class="img-fluid w-100">
                    </div>
                    <p class="wsus__main_blog_header">
                        <span><i class="fas fa-user-tie"></i> by {{$blog->user->name}}</span>
                        <span><i class="fal fa-calendar-alt"></i> {{date('M d Y', strtotime($blog->created_at))}}</span>
                        <span><i class="fal fa-comment-alt-smile"></i> 0 Comment</span>
                    </p>
                    <div class="wsus__description_area">
                        <h1>{{$blog->title}}</h1>
                        {!! $blog->content !!}
                    </div>
                    <div class="wsus__share_blog">
                        <p>share:</p>
                        <ul>
                            <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="twitter" href="https://twitter.com/share?url={{url()->current()}}&text={{$blog->title}}"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="linkedin" href="https://www.linkedin.com/shareArticle?url={{url()->current()}}&title={{$blog->title}}&summary={{limitText($blog->content, 20)}}"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    <div class="wsus__related_post">
                        <div class="row">
                            <div class="col-xl-12">
                                <h5>More posts</h5>
                            </div>
                        </div>
                        <div class="row blog_det_slider">
                            @foreach($more_blogs as $blogItem)
                                <div class="col-xl-3">
                                    <div class="wsus__single_blog wsus__single_blog_2">
                                        <a class="wsus__blog_img" href="{{route('blog.index', $blogItem->slug)}}">
                                            <img src="{{asset($blogItem->image)}}" alt="blog" class="img-fluid w-100">
                                        </a>
                                        <div class="wsus__blog_text">
                                            <a class="blog_top red" href="{{route('blog', ['category' => $blogItem->category->slug])}}">{{$blogItem->category->name}}</a>
                                            <div class="wsus__blog_text_center">
                                                <a href="{{route('blog.index', $blogItem->slug)}}">{{limitText($blogItem->title, 45)}}</a>
                                                <p class="date">{{date('M d Y', strtotime($blogItem->created_at))}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="wsus__comment_area">
                        <h4>comments <span>{{$comments->count()}}</span></h4>
                        @if($comments->count() === 0)
                            <p>No Comments Yet. Be the First To Comment!</p>
                        @endif
                        @foreach($comments as $comment)
                            <div class="wsus__main_comment">
                                <div class="wsus__comment_img">
                                    <img src="{{asset($comment->user->image? : asset('frontend/images/avatar.png'))}}" alt="user" class="img-fluid w-100">
                                </div>
                                <div class="wsus__comment_text replay">
                                    <h6>{{$comment->user->name}} <span>{{date('d M Y', strtotime($comment->created_at))}}</span></h6>
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div>
                        @endforeach
                        <div id="pagination">
                            <div class="mt-5">
                                @if($comments->hasPages())
                                    {{$comments->withQueryString()->links()}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="wsus__post_comment">
                        <h4>post a comment</h4>
                        @if(auth()->check())
                        <form action="{{route('user.blog.comment')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__single_com">
                                        <textarea name="comment" rows="5" placeholder="Your Comment"></textarea>
                                        <input name="blog_id" type="hidden" value="{{$blog->id}}">
                                    </div>
                                </div>
                            </div>
                            <button class="common_btn" type="submit">post comment</button>
                        </form>
                        @else
                            <p>Please Login To Post a Comment!</p>
                            <a href="{{route('login')}}" class="common_btn mt-4">Login</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-4">
                <div class="wsus__blog_sidebar" id="sticky_sidebar">
                    <div class="wsus__blog_search">
                        <h4>search</h4>
                        <form action="{{route('blog')}}" method="get">
                            @csrf
                            <input name="search" type="text" placeholder="Search">
                            <button type="submit" class="common_btn"><i class="far fa-search"></i></button>
                        </form>
                    </div>
                    <div class="wsus__blog_category">
                        <h4>Categories</h4>
                        <ul>
                            @foreach($categories as $category)
                                <li><a href="{{route('blog', ['category' => $category->slug])}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="wsus__blog_post">
                        <h4>Popular Posts</h4>
                        @foreach($popular_posts as $post)
                            <div class="wsus__blog_post_single">
                                <a href="{{route('blog.index', $post->slug)}}" class="wsus__blog_post_img">
                                    <img src="{{asset($post->image)}}" alt="blog" class="imgofluid w-100">
                                </a>
                                <div class="wsus__blog_post_text">
                                    <a href="{{route('blog.index', $post->slug)}}">{{limitText($post->title, 20)}}</a>
                                    <p> <span>{{date('M d Y', strtotime($post->created_at))}} </span> {{$post->comments->count()}} Comment </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    BLOGS DETAILS END
==============================-->
@endsection
