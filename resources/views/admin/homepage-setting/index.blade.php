@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Homepage Settings</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action active show" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-selected="false">Popular Category Section</a>
                                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-selected="false">Single Category Slider Section One</a>
                                    <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-selected="false">Single Category Slider Section Two</a>
                                    <a class="list-group-item list-group-item-action" id="list-slider-three" data-toggle="list" href="#list-slider" role="tab" aria-selected="false">Product Slider Section</a>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="tab-content" id="nav-tabContent">
                                    @include('admin.homepage-setting.sections.popular-category-section')
                                    @include('admin.homepage-setting.sections.single-category-section')
                                    @include('admin.homepage-setting.sections.single-category-section-two')
                                    @include('admin.homepage-setting.sections.product-slider-section')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
