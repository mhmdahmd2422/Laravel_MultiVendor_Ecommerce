@php
    $footer_contact = \App\Models\FooterData::first();
    $footer_socials = \App\Models\FooterSocial::where('status', 1)->get();
    $grid_title = \App\Models\FooterGridTitle::first();
    $grid_two_links = \App\Models\FooterGridTwo::where('status', 1)->get();
    $grid_three_links = \App\Models\FooterGridThree::where('status', 1)->get();
@endphp

    <!--============================
    FOOTER PART START
==============================-->
<footer class="footer_2">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                <div class="wsus__footer_content">
                    <a class="wsus__footer_2_logo" href="#">
                        <img src="{{asset($footer_contact?->logo)}}" alt="logo">
                    </a>
                    <a class="action" href="callto:{{$footer_contact?->phone}}"><i class="fas fa-phone-alt"></i>
                        {{$footer_contact?->phone}}</a>
                    <a class="action" href="mailto:{{$footer_contact?->email}}"><i class="far fa-envelope"></i>
                        {{$footer_contact?->email}}</a>
                    <p><i class="fal fa-map-marker-alt"></i> {{$footer_contact?->address}}</p>
                    <ul class="wsus__footer_social">
                        @foreach($footer_socials as $social)
                            <li><a class="social-link" href="{{$social->url}}"><i class="{{$social->icon}}"></i></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{@$grid_title->grid_two_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach($grid_two_links as $link)
                            <li><a href="{{$link->url}}"><i class="fas fa-caret-right"></i>{{$link->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{@$grid_title->grid_three_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach($grid_three_links as $link)
                            <li><a href="{{$link->url}}"><i class="fas fa-caret-right"></i>{{$link->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                <div class="wsus__footer_content wsus__footer_content_2">
                    <h3>Subscribe To Our Newsletter</h3>
                    <p>Get all the latest information on Events and Offers.
                    </p>
                    <form action="" method="" id="newsletter_request">
                        @csrf
                        <input name="email" type="text" placeholder="Email">
                        <button type="submit" class="common_btn subscribe_btn">subscribe</button>
                    </form>
                    <div class="footer_payment">
                        <p>We're using safe payment for :</p>
                        <img style="height: 4rem; width: 20rem;" src="{{asset('frontend/images/credit.png')}}" alt="card" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wsus__footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__copyright d-flex justify-content-center">
                        <p>{{$footer_contact?->copyrights}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--============================
    FOOTER PART END
==============================-->
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.social-link').on('click', function (event) {
                event.preventDefault();
                let url = $('.social-link').attr('href')
                window.open(url, '_blank');
            })
        })
    </script>
@endpush
