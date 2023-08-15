<!--============================
    BANNER PART 2 START
==============================-->
<section id="wsus__banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__banner_content">
                    <div class="row banner_slider">
                        @foreach($sliders as $slider)
                        <div class="col-xl-12">
                            <div class="wsus__single_slider" style="background: url({{asset($slider->banner)}});">
                                <div class="wsus__single_slider_text">
                                    <h3>{!! $slider->title !!}</h3>
                                    <h1>{!! $slider->type !!}</h1>
                                    <h6>start at ${{$slider->starting_price}}</h6>
                                    <a class="common_btn" href="{{$slider->button_url}}">shop now</a>
                                </div>
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
    BANNER PART 2 END
==============================-->

