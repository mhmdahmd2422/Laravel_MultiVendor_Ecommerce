<div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
     aria-labelledby="v-pills-settings-tab">
    <div class="row">
        <div class="col-xl-12 m-auto">
            <div class="wsus__payment_area">
                <a href="{{route('user.cod.payment')}}" class="nav-link common_btn text-center pay_button">Pay On Delivery</a>
            </div>
        </div>
    </div>
</div>
@php
    $stripe_settings = \App\Models\StripeSetting::first();
@endphp
@push('scripts')

@endpush
