<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Ecommerce</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">ECOM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
                <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="dropdown {{setActive(['admin.slider.*', 'admin.coupons.*', 'admin.shipping.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Website</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
                    <li class="{{setActive(['admin.coupons.*'])}}"><a class="nav-link" href="{{route('admin.coupons.index')}}">Coupons</a></li>
                    <li class="{{setActive(['admin.shipping.*'])}}"><a class="nav-link" href="{{route('admin.shipping.index')}}">Shipping Methods</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive([
                'admin.brand.*',
                'admin.product.*',
                'admin.products-image-gallery.*',
                'admin.seller-products.*',
                'admin.products-variant.*',
                'admin.product-variant-items.*',
                'admin.flash-sale.*'
                ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.brand.*'])}}"><a class="nav-link" href="{{route('admin.brand.index')}}">Brands</a></li>
                    <li class="{{setActive(['admin.product.*'])}}"><a class="nav-link" href="{{route('admin.product.index')}}">Products</a></li>
                    <li class="{{setActive(['admin.seller-products.index'])}}"><a class="nav-link" href="{{route('admin.seller-products.index')}}">Seller Products</a></li>
                    <li class="{{setActive(['admin.seller-products.pending'])}}"><a class="nav-link" href="{{route('admin.seller-products.pending')}}">Pending Products</a></li>
                    <li class="{{setActive(['admin.flash-sale.index'])}}"><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive(['admin.vendor.*',])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Traders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.vendor.*'])}}"><a class="nav-link" href="{{route('admin.vendor.index')}}">Vendors</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive(['admin.category.*', 'admin.sub-category.*', 'admin.child-category.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Categories</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.category.*'])}}"><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
                    <li class="{{setActive(['admin.sub-category.*'])}}"><a class="nav-link" href="{{route('admin.sub-category.index')}}">Sub-Category</a></li>
                    <li class="{{setActive(['admin.child-category.*'])}}"><a class="nav-link" href="{{route('admin.child-category.index')}}">Child-Category</a></li>
                </ul>
            </li>
            <li class="{{setActive(['admin.settings.*'])}}"><a class="nav-link" href="{{route('admin.settings.index')}}"><i class="fas fa-wrench"></i>Settings</a></li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{route('home')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> FrontEnd
            </a>
        </div>
    </aside>
</div>
