@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Orders</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Today: {{$todayTotalOrders}}</span>
                        <span>All: {{$totalOrders}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Processing Orders</h4>
                    </div>
                    <div class="card-body">
                        <span>Today: {{$todayPendingOrders}}</span>
                        <span>All: {{$totalPendingOrders}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Complete Orders</h4>
                    </div>
                    <div class="card-body">
                        <span>Today: {{$todayDoneOrders}}</span>
                        <span>All: {{$totalDoneOrders}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Canceled Orders</h4>
                    </div>
                    <div class="card-body">
                        <span>Today: {{$todayCanceledOrders}}</span>
                        <span>All: {{$totalCanceledOrders}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>All Earnings</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>{{$settings->currency_icon}}{{$totalEarnings}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Today Earnings</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>{{$settings->currency_icon}}{{$totalTodayEarnings}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Month Earnings</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>{{$settings->currency_icon}}{{$totalMonthEarnings}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Year Earnings</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>{{$settings->currency_icon}}{{$totalYearEarnings}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveCategories}}</span>
                        <span>Banned: {{$totalInactiveCategories}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Products</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveProducts}}</span>
                        <span>Banned: {{$totalInactiveProducts}} ({{$totalUnapprovedProducts}} Requests)</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Blogs</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveBlogs}}</span>
                        <span>Banned: {{$totalInactiveBlogs}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Reviews</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveReviews}}</span>
                        <span>Pending: {{$totalPendingReviews}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Users</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveUsers}}</span>
                        <span>Banned: {{$totalInactiveUsers}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Brands</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveBrands}}</span>
                        <span>Banned: {{$totalInactiveBrands}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Vendors</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Active: {{$totalActiveVendors}}</span>
                        <span>Banned: {{$totalInactiveVendors}} ({{$totalUnapprovedVendors}} Requests)</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Newsletter Subs</h4>
                    </div>
                    <div class="card-body mb-2">
                        <span>Verified: {{$totalVerifiedSubs}}</span>
                        <span>Pending: {{$totalPendingSubs}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

@endsection
