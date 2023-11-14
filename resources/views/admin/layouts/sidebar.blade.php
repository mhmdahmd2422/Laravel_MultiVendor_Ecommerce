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
            <li class="dropdown {{setActive(
                ['admin.slider.*',
                 'admin.homepage-settings.*',
                 'admin.coupons.*',
                  'admin.shipping.*',
                  'admin.payment-settings.*',
                  'admin.vendor-condition.*',
                  'admin.about.*',
                  'admin.terms-and-conditions.*'
                  ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Website</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
                    <li class="{{setActive(['admin.homepage-settings.*'])}}"><a class="nav-link" href="{{route('admin.homepage-settings.index')}}">Homepage Settings</a></li>
                    <li class="{{setActive(['admin.coupons.*'])}}"><a class="nav-link" href="{{route('admin.coupons.index')}}">Coupons</a></li>
                    <li class="{{setActive(['admin.shipping.*'])}}"><a class="nav-link" href="{{route('admin.shipping.index')}}">Shipping Methods</a></li>
                    <li class="{{setActive(['admin.payment-settings.*'])}}"><a class="nav-link" href="{{route('admin.payment-settings.index')}}">Payment Methods</a></li>
                    <li class="{{setActive(['admin.vendor-condition.*'])}}"><a class="nav-link" href="{{route('admin.vendor-condition.index')}}">Vendor Conditions</a></li>
                    <li class="{{setActive(['admin.about.*'])}}"><a class="nav-link" href="{{route('admin.about.index')}}">About Us</a></li>
                    <li class="{{setActive(['admin.terms-and-conditions.*'])}}"><a class="nav-link" href="{{route('admin.terms-and-conditions.index')}}">Terms And Conditions</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive(
                [
                    'admin.footer-data.*',
                    'admin.footer-social.*',
                    'admin.footer-grid-two.*',
                    'admin.footer-grid-three.*',
                ]
                )}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i><span>Footer Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.footer-data.*'])}}"><a class="nav-link" href="{{route('admin.footer-data.index')}}">Contact Info</a></li>
                    <li class="{{setActive(['admin.footer-social.*'])}}"><a class="nav-link" href="{{route('admin.footer-social.index')}}">Social Links</a></li>
                    <li class="{{setActive(['admin.footer-grid-two.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-two.index')}}">Grid Two</a></li>
                    <li class="{{setActive(['admin.footer-grid-three.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-three.index')}}">Grid Three</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive(['admin.order.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.order.index'])}}"><a class="nav-link" href="{{route('admin.order.index')}}">All Orders</a></li>
                    <li class="{{setActive(['admin.order.pending'])}}"><a class="nav-link" href="{{route('admin.order.pending')}}">Pending Orders</a></li>
                    <li class="{{setActive(['admin.order.processed'])}}"><a class="nav-link" href="{{route('admin.order.processed')}}">Processed Orders</a></li>
                    <li class="{{setActive(['admin.order.dropped'])}}"><a class="nav-link" href="{{route('admin.order.dropped')}}">Dropped-Off Orders</a></li>
                    <li class="{{setActive(['admin.order.shipped'])}}"><a class="nav-link" href="{{route('admin.order.shipped')}}">Shipped Orders</a></li>
                    <li class="{{setActive(['admin.order.delivery'])}}"><a class="nav-link" href="{{route('admin.order.delivery')}}">Out-For-Delivery Orders</a></li>
                    <li class="{{setActive(['admin.order.delivered'])}}"><a class="nav-link" href="{{route('admin.order.delivered')}}">Delivered Orders</a></li>
                    <li class="{{setActive(['admin.order.canceled'])}}"><a class="nav-link" href="{{route('admin.order.canceled')}}">Canceled Orders</a></li>
                    </ul>
            </li>
            <li class="dropdown {{setActive([
                'admin.brand.*',
                'admin.product.*',
                'admin.products-image-gallery.*',
                'admin.seller-products.*',
                'admin.products-variant.*',
                'admin.product-variant-items.*',
                'admin.flash-sale.*',
                'admin.reviews.*'
                ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.brand.*'])}}"><a class="nav-link" href="{{route('admin.brand.index')}}">Brands</a></li>
                    <li class="{{setActive(['admin.product.*'])}}"><a class="nav-link" href="{{route('admin.product.index')}}">Products</a></li>
                    <li class="{{setActive(['admin.seller-products.index'])}}"><a class="nav-link" href="{{route('admin.seller-products.index')}}">Seller Products</a></li>
                    <li class="{{setActive(['admin.reviews.index'])}}"><a class="nav-link" href="{{route('admin.reviews.index')}}">Pending Reviews</a></li>
                    <li class="{{setActive(['admin.seller-products.pending'])}}"><a class="nav-link" href="{{route('admin.seller-products.pending')}}">Pending Products</a></li>
                    <li class="{{setActive(['admin.flash-sale.index'])}}"><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive([
                'admin.admins-list.*',
                'admin.vendor.*',
                'admin.vendor-request.*',
                'admin.users.*',
                ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.admins-list.*'])}}"><a class="nav-link" href="{{route('admin.admins-list.index')}}">Admins</a></li>
                    <li class="{{setActive(['admin.vendor.*'])}}"><a class="nav-link" href="{{route('admin.vendor.index')}}">Vendors</a></li>
                    <li class="{{setActive(['admin.vendor-request.*'])}}"><a class="nav-link" href="{{route('admin.vendor-request.index')}}">Pending Vendors</a></li>
                    <li class="{{setActive(['admin.users.*'])}}"><a class="nav-link" href="{{route('admin.users.index')}}">Users</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive([
                'admin.category.*',
                'admin.sub-category.*',
                'admin.child-category.*',
                ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Categories</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.category.*'])}}"><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
                    <li class="{{setActive(['admin.sub-category.*'])}}"><a class="nav-link" href="{{route('admin.sub-category.index')}}">Sub-Category</a></li>
                    <li class="{{setActive(['admin.child-category.*'])}}"><a class="nav-link" href="{{route('admin.child-category.index')}}">Child-Category</a></li>
                </ul>
            </li>
            <li class="dropdown {{setActive([
                    'admin.blog-category.*',
                    'admin.blog.*',
                    'admin.blog-comment.*',
                ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.blog-category.*'])}}"><a class="nav-link" href="{{route('admin.blog-category.index')}}">Categories</a></li>
                    <li class="{{setActive(['admin.blog.*'])}}"><a class="nav-link" href="{{route('admin.blog.index')}}">Posts</a></li>
                    <li class="{{setActive(['admin.blog-comment.*'])}}"><a class="nav-link" href="{{route('admin.blog-comment.index')}}">Comments</a></li>
                </ul>
            </li>
            <li class="{{setActive(['admin.transactions.*'])}}"><a class="nav-link" href="{{route('admin.transactions.index')}}"><i class="fas fa-money-check-alt"></i>Transactions</a></li>
            <li class="{{setActive(['admin.newsletter.*'])}}"><a class="nav-link" href="{{route('admin.newsletter.index')}}"><i class="far fa-newspaper"></i>Newsletter Subscribers</a></li>
            <li class="{{setActive(['admin.advertisement.*'])}}"><a class="nav-link" href="{{route('admin.advertisement.index')}}"><i class="fab fa-font-awesome-flag"></i>Advertisement Banners</a></li>
            <li class="{{setActive(['admin.settings.*'])}}"><a class="nav-link" href="{{route('admin.settings.index')}}"><i class="fas fa-wrench"></i>Settings</a></li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{route('home')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> FrontEnd
            </a>
        </div>
    </aside>
</div>
