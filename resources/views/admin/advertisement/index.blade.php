@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action active show" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-selected="true">Homepage Banner Section One</a>
                                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-selected="false">Homepage Banner Section Two</a>
                                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-selected="false">Homepage Banner Section three</a>
                                    <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-selected="false">Homepage Banner Section four</a>
                                    <a class="list-group-item list-group-item-action" id="list-products-list" data-toggle="list" href="#list-products" role="tab" aria-selected="false">Products Banner</a>
                                    <a class="list-group-item list-group-item-action" id="list-cart-list" data-toggle="list" href="#list-cart" role="tab" aria-selected="false">Cart View Banner</a>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="tab-content" id="nav-tabContent">
                                    @include('admin.advertisement.homepage-section-one')
                                    @include('admin.advertisement.homepage-section-two')
                                    @include('admin.advertisement.homepage-section-three')
                                    @include('admin.advertisement.homepage-section-four')
                                    @include('admin.advertisement.products')
                                    @include('admin.advertisement.cart_view')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
