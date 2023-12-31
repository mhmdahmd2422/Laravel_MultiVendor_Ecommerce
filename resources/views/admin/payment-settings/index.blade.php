@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Payment Methods</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action active show" id="list-home-list"
                                       data-toggle="list" href="#list-home" role="tab" aria-selected="true">Paypal</a>
                                    <a class="list-group-item list-group-item-action" id="list-profile-list"
                                       data-toggle="list" href="#list-profile" role="tab"
                                       aria-selected="false">Stripe</a>
                                    <a class="list-group-item list-group-item-action" id="list-messages-list"
                                       data-toggle="list" href="#list-messages" role="tab" aria-selected="false">COD</a>
{{--                                    <a class="list-group-item list-group-item-action" id="list-settings-list"--}}
{{--                                       data-toggle="list" href="#list-settings" role="tab" aria-selected="false">Settings</a>--}}
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="tab-content" id="nav-tabContent">
                                    @include('admin.payment-settings.sections.paypal-setting')
                                    @include('admin.payment-settings.sections.stripe-setting')
                                    @include('admin.payment-settings.sections.cod-setting')

{{--                                    <div class="tab-pane fade" id="list-settings" role="tabpanel"--}}
{{--                                         aria-labelledby="list-settings-list">--}}
{{--                                        Lorem ipsum culpa in ad velit dolore anim labore incididunt do aliqua sit veniam--}}
{{--                                        commodo elit dolore do labore occaecat laborum sed quis proident fugiat sunt--}}
{{--                                        pariatur. Cupidatat ut fugiat anim ut dolore excepteur ut voluptate dolore--}}
{{--                                        excepteur mollit commodo.--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
