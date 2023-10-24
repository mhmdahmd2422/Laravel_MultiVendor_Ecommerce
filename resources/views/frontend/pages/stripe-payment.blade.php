<div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
     aria-labelledby="v-pills-messages-tab">
    <div class="row">
        <div class="col-xl-12 m-auto">
            <div class="wsus__payment_area">
                <div class="wsus__pay_caed_header">
                    <h5>Stripe Payment</h5>
                    <img style="height: 3rem; width: 3rem;" src="{{asset('frontend/images/stripe.svg')}}" alt="payment" class="img-=fluid">
                </div>
                <form action="{{route('user.stripe.payment')}}" method="post" id="checkout-form">
                    @csrf
                    <input type="hidden" name="stripe_token" id="stripe-token-id">
                    <div id="card-element" class="form-control mb-1">

                    </div>
                    <br>
                    <button type="button" onclick="createToken()" id="stripe_btn" class="nav-link common_btn pay_button">Pay With Stripe</button>
                </form>
            </div>
        </div>
    </div>
</div>
@php
    $stripe_settings = \App\Models\StripeSetting::first();
@endphp
@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{$stripe_settings->client_id}}');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        function createToken(){
            document.getElementById('stripe_btn').disabled = true;
            stripe.createToken(cardElement).then(function(result){
                if(typeof result.error != 'undefined'){
                    document.getElementById('stripe_btn').disabled = false;
                    toastr.error(result.error.message);
                    let payButton = $('.pay_button');
                    payButton.css({'background' : '#dc3545'});
                    payButton.html('Something Went Wrong');
                }

                //create token success
                if(typeof result.token != 'undefined'){
                    document.getElementById('stripe-token-id').value = result.token.id;
                    document.getElementById('checkout-form').submit();

                }
            })


        }
    </script>
@endpush
