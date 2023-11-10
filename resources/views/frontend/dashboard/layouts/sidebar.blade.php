<div class="dashboard_sidebar">
        <span class="close_icon">
          <i class="far fa-bars dash_bar"></i>
          <i class="far fa-times dash_close"></i>
        </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="active" href="{{route('user.dashboard')}}"><i class="fas fa-tachometer"></i>{{auth()->user()->role === 'vendor'? 'User ': ''}}Dashboard</a></li>
        @if(auth()->user()->role === 'vendor')
            <li><a href="{{route('vendor.dashboard')}}"><i class="fas fa-tachometer"></i>Vendor Dashboard</a></li>
        @endif
        <li><a href="{{route('user.orders')}}"><i class="fas fa-list-ul"></i> Orders</a></li>
        <li><a href="dsahboard_download.html"><i class="far fa-cloud-download-alt"></i> Downloads</a></li>
        <li><a href="{{route('user.review.index')}}"><i class="far fa-star"></i> Reviews</a></li>
        <li><a href="dsahboard_wishlist.html"><i class="far fa-heart"></i> Wishlist</a></li>
        <li><a href="{{route('user.profile')}}"><i class="far fa-user"></i> My Profile</a></li>
        @if(auth()->user()->role === 'user')
            <li><a href="{{route('user.vendor-request.index')}}"><i class="fas fa-store"></i> Be A Vendor</a></li>
        @endif
        <li><a href="{{route('user.address.index')}}"><i class="fal fa-gift-card"></i> Addresses</a></li>
        <li><form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                    <i class="fas far fa-sign-out-alt"></i> Log out
                </a>
            </form>
        </li>

    </ul>
</div>
