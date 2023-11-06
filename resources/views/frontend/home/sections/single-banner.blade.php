<!--============================
    SINGLE BANNER START
==============================-->
<section id="wsus__single_banner" class="wsus__single_banner_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content">
                    <div class="wsus__single_banner_img">
                        @if($banner_two->status ==1)
                        <a href="{{$banner_two->banner_url}}">
                            <img class="img-fluid w-100" src="{{asset($banner_two->banner_image)}}" alt="Banner">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content single_banner_2">
                    <div class="wsus__single_banner_img">
                        @if($banner_three->status ==1)
                        <a href="{{$banner_three->banner_url}}">
                            <img class="img-fluid w-100" src="{{asset($banner_three->banner_image)}}" alt="Banner">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    SINGLE BANNER END
==============================-->
