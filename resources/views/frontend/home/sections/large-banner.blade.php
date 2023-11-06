<!--============================
    LARGE BANNER  START
==============================-->
<section id="wsus__large_banner">
    <div class="container">
        <div class="row">
            <div class="cl-xl-12">
{{--                <div class="wsus__large_banner_content" style="background: url({{asset($banner_seven->banner_image)}});">--}}
{{--                    <div class="wsus__large_banner_content_overlay">--}}
{{--                        <div class="row">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                @if($banner_seven->status ==1)
                <a href="{{$banner_seven->banner_url}}">
                    <img class="img-fluid w-100" src="{{asset($banner_seven->banner_image)}}" alt="Banner">
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
<!--============================
    LARGE BANNER  END
==============================-->
