{{--common scripts across pages--}}
<script>
    $(document).ready(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        {{--homepage only scripts--}}
        //newsletter request
        $('#newsletter_request').on('submit', function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            let subscribeBtn = $('.subscribe_btn');
            $.ajax({
                method: 'POST',
                url: '{{route('newsletter.request')}}',
                data: formData,
                beforeSend: function () {
                    subscribeBtn.css({'background' : '#0088CC'});
                    subscribeBtn.html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                },
                success: function (data) {
                    if(data.status === 'success'){
                        subscribeBtn.css({'background' : '#198754'});
                        subscribeBtn.html('Sent!');
                        toastr.success(data.message);
                        resetSubscribeBtn();
                    }else if(data.status === 'error'){
                        subscribeBtn.css({'background' : '#dc3545'});
                        subscribeBtn.html('Error');
                        toastr.error(data.message);
                        resetSubscribeBtn();
                    }
                },
                error: function (data) {
                    let errors = data.responseJSON.errors;
                    if(errors){
                        $.each(errors, function (key, value) {
                            toastr.error(value);
                        })
                    }
                    subscribeBtn.css({'background' : '#dc3545'});
                    subscribeBtn.html('Error');
                    resetSubscribeBtn();
                }
            })
        })


        {{--common scripts across pages--}}
        //add product to cart
        $('.shopping-cart-form').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                data: formData,
                url: '{{route('add-to-cart')}}',
                success: function (data) {
                    if(data.status == 'success'){
                        getCartCount();
                        fetchSidebarCartProducts();
                        getSidebarCartSubtotal();
                        toastr.success(data.message);
                        if(window.location.pathname === '/user/wishlist'){
                            location.reload();
                        }
                    }else if (data.status == 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            })
        })
        //update header cart counter
        function getCartCount() {
            $.ajax({
                method: 'GET',
                url: '{{route('cart-count')}}',
                success: function (data) {
                    $('#cart-count').text(data);
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }
        //update sidebar cart on change
        function fetchSidebarCartProducts(){
            $.ajax({
                method: 'GET',
                url: '{{route('cart-products')}}',
                success: function (data) {
                    let miniCart = $('.mini_cart_wrapper');
                    miniCart.html('');
                    var html = '';
                    for(let item in data){
                        let product = data[item];
                        html += `<li>
                                    <div class="wsus__cart_img">
                                    <a href="{{url('product-detail')}}/${product.options.slug}"><img src="{{asset('/')}}${product.options.image}" alt="product" class="img-fluid w-100"></a>
                                    <a id="${product.rowId}" class="wsis__del_icon remove-sidebar-item" href="#"><i class="fas fa-minus-circle"></i></a>
                                    </div>
                                    <div class="wsus__cart_text">
                                    <a class="wsus__cart_title" href="{{url('product-detail')}}/${product.options.slug}">
                                    ${product.name}
                                    (${product.qty} item)
                                    </a>
                                    <p>{{$settings->currency_icon}}${product.price}</p>
                                    <small>Variants Per Item: {{$settings->currency_icon}}${product.options.variants_totalPrice}</small>
                                    </div>
                                    </li>`
                    }
                    miniCart.html(html);
                    if(miniCart.find('li').length === 0){
                        $('.mini_cart_actions').addClass('d-none');
                        miniCart.html('<li class="text-center">Cart Is Empty!</li>');
                    }else{
                        $('.mini_cart_actions').removeClass('d-none');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }
        function getSidebarCartSubtotal(){
            $.ajax({
                method: 'GET',
                url: '{{route('cart-products-total')}}',
                success: function (data) {
                    $('#mini_cart_subtotal').text("{{$settings->currency_icon}}"+data);
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }
        //add product to wishlist
        $('.add-to-wishlist').on('click', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: '{{route('wishlist.store')}}',
                data: {
                    productId: id,
                },
                success: function (data) {
                    if(data.status === 'success'){
                        $('.wishlist_count').text(data.wishlistCount)
                        toastr.success(data.message);
                    }else if(data.status === 'error'){
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })
        //newsletter subs helper
        function resetSubscribeBtn() {
            setTimeout(
                function()
                {
                    let subscribeBtn = $('.subscribe_btn');
                    subscribeBtn.css({'background' : '#0088CC'});
                    subscribeBtn.html('Subscribe');
                },
                1500);
        }
        //remove item from sidebar cart
        $('body').on('click', '.remove-sidebar-item', function (e){
            e.preventDefault();
            let row_id = $(this).attr('id');
            $.ajax({
                url: '{{route('remove-item')}}',
                method: 'POST',
                data: {
                    row_id: row_id,
                },
                success: function (data) {
                    // Reload the Page
                    location.reload();
                },
                error: function (data) {
                }
            })
        })


        {{--cart details page only scripts--}}
        // Increment product quantity in cart details and calc total onclick
        $('.product-increment').on('click', function(e){
            e.preventDefault();
            let input = $(this).siblings('.product-qty');
            let qty = parseInt(input.val()) +1;
            let row_id = input.data('rowid');
            $.ajax({
                url: '{{route('update-quantity')}}',
                method: 'POST',
                data : {
                    row_id: row_id,
                    quantity: qty,
                },
                success: function (data) {
                    if(data.status === 'success'){
                        input.val(qty);
                        let productId = '#'+row_id;
                        let totalAmount = "{{$settings->currency_icon}}"+data.product_total;
                        $(productId).text(totalAmount);
                        getCartSubtotal();
                        calculateCouponDiscount();
                        getCartCount();
                        fetchSidebarCartProducts()
                        toastr.success(data.message);
                    }else if(data.status === 'error'){
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                }
            })
        })
        // decrement product quantity in cart details and calc total onclick
        $('.product-decrement').on('click', function(e){
            e.preventDefault();
            let input = $(this).siblings('.product-qty');
            let qty = parseInt(input.val()) -1;
            let row_id = input.data('rowid');
            if(qty > 0){
                input.val(qty);
            }else{
                return;
            }
            $.ajax({
                url: '{{route('update-quantity')}}',
                method: 'POST',
                data : {
                    row_id: row_id,
                    quantity: qty,
                },
                success: function (data) {
                    let productId = '#'+row_id;
                    let totalAmount = "{{$settings->currency_icon}}"+data.product_total;
                    $(productId).text(totalAmount);
                    getCartSubtotal();
                    calculateCouponDiscount();
                    getCartCount();
                    fetchSidebarCartProducts()
                    toastr.success(data.message);
                },
                error: function (data) {
                }
            })
        })
        //remove item from cart in cart details
        $('.remove-item').on('click', function (e){
            e.preventDefault();
            let row_id = $(this).attr('id');
            $.ajax({
                url: '{{route('remove-item')}}',
                method: 'POST',
                data: {
                    row_id: row_id,
                },
                success: function (data) {
                    fetchSidebarCartProducts();
                    calculateCouponDiscount();
                    Swal.fire(
                        'Removed',
                        data.message,
                        'success'
                    ).then((result) => {
                        // Reload the Page
                        location.reload();
                    });
                },
                error: function (data) {
                }
            })
        })
        //clear cart button in cart details
        $('body').on('click', '.clear-cart', function (event){
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Are You Sure You Want To Clear Cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'get',
                        url: '{{route('clear-cart')}}',
                        success: function (data) {
                            if(data.status == 'success'){
                                Swal.fire(
                                    'Cart Is Cleared!',
                                    data.message,
                                    'success'
                                ).then((result) => {
                                    // Reload the Page
                                    location.reload();
                                });
                            }else if (data.status == 'error'){
                                location.reload();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                        }
                    })
                }
            })
        })
        //add coupon to cart
        $('#coupon_form').on('submit', function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                data: formData,
                url: '{{route('apply-coupon')}}',
                success: function (data) {
                    if(data.status == 'success'){
                        calculateCouponDiscount();
                        $('#coupon_tag').html(
                            `<p>Coupon Applied: ${data.coupon_name}
                                <a class="remove-item" id="remove-coupon" href="">
                                <i class="far fa-times"></i></a>
                                </p>
                                `);
                        removeCoupon();
                        toastr.success(data.message);
                    }else if (data.status == 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            })
        })
        //remove coupon from cart
        function removeCoupon(){
            var removeTag = $('#coupon_tag').find('a');
            removeTag.on('click', function (e){
                e.preventDefault();
                $.ajax({
                    method: 'GET',
                    url: '{{route('remove-coupon')}}',
                    success: function (data) {
                        if(data.status == 'success'){
                            $('#coupon_tag').html('');
                            $('#coupon_code').val('');
                            $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                            $('#cart_total').text("{{$settings->currency_icon}}"+data.cart_total);
                            toastr.success(data.message);
                        }else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                        console.log(data.message);
                    }
                })
            })
        }
        var removeTag = $('#coupon_tag').find('a');
        removeTag.on('click', function (e){
            e.preventDefault();
            $.ajax({
                method: 'GET',
                url: '{{route('remove-coupon')}}',
                success: function (data) {
                    if(data.status == 'success'){
                        $('#coupon_tag').html('');
                        $('#coupon_code').val('');
                        $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                        $('#cart_total').text("{{$settings->currency_icon}}"+data.cart_total);
                        toastr.success(data.message);
                    }else if (data.status == 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                    console.log(data.message);
                }
            })
        })
        //get cart subtotal in cart details
        function getCartSubtotal(){
            $.ajax({
                method: 'GET',
                url: '{{route('cart-products-total')}}',
                success: function (data) {
                    $('.cart_subtotal').text("{{$settings->currency_icon}}"+data);
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }
        //calculate coupon discount in cart details
        function calculateCouponDiscount(){
            $.ajax({
                method: 'GET',
                url: '{{route('calculate-coupon')}}',
                success: function (data) {
                    if(data.status == 'success'){
                        $('#discount_total').text("-{{$settings->currency_icon}}"+data.discount_value);
                        $('#cart_total').text("{{$settings->currency_icon}}"+data.new_cart_total);
                    }else if (data.status == 'error') {
                        $.ajax({
                            method: 'GET',
                            url: '{{route('remove-coupon')}}',
                            success: function (data) {
                                if (data.status == 'success') {
                                    $('#coupon_tag').html('');
                                    $('#coupon_code').val('');
                                    $('#discount_total').text("{{$settings->currency_icon}}" + '0');
                                    $('#cart_total').text("{{$settings->currency_icon}}" + data.cart_total);
                                    toastr.success(data.message);
                                } else if (data.status == 'error') {
                                    toastr.error(data.message);
                                }
                            },
                            error: function (data) {
                                console.log(data.message);
                            }
                        })
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            })
        }

        {{--checkout page only scripts--}}
        //reset selectors and form values
        $('input[type="radio"]').prop('checked', false);
        $('#shipping_address_id').val("");
        $('#shipping_method_id').val("");

        //set chosen address
        $('.address-input').on('click', function (e) {
            $('#shipping_address_id').val($(this).data('id'));
        })
        // apply shipping method
        $('.shipping-input').on('click', function (e) {
            let shippingId = $(this).val();
            $.ajax({
                url: '{{route('user.apply-shipping')}}',
                method: 'POST',
                data: {
                    shipping_id: shippingId,
                },
                success: function (data) {
                    if (data.status === 'success') {
                        $('#shipping_method_id').val(shippingId);
                        $('#cart_subtotal').text('{{$settings->currency_icon}}'+data.cart_total);
                        $('#shipping_fee').text('+{{$settings->currency_icon}}'+data.shipping_cost);
                        $('#cart_total').text('{{$settings->currency_icon}}'+data.new_cart_total);
                    } else if (data.status === 'error') {
                        $('.shipping-input').prop('checked', false);
                        toastr.error(data.message);
                    }
                },
                error: function (data) {
                }
            })
        })
        //submit checkout form
        $('#submitCheckoutForm').on('click', function(event){
            event.preventDefault();
            if($('#shipping_address_id').val() == '') {
                toastr.error('Please Select Shipping Address');
            }else if(!$('.agree-terms').prop('checked')){
                toastr.error('Please Accept To Terms And Conditions');
            }else if($('#shipping_method_id').val() == ''){
                toastr.error('Please Select Shipping Method');
            }else{
                $.ajax({
                    url: '{{route('user.checkout-submit')}}',
                    method: 'POST',
                    data: $('#checkoutForm').serialize(),
                    beforeSend: function () {
                        $('#submitCheckoutForm').html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                    },
                    success: function (data){
                        if(data.status === 'success'){
                            $('#submitCheckoutForm').css({'background' : '#198754'});
                            $('#submitCheckoutForm').html('Going To Payment...');
                            //redirect user to payment page
                            window.location.href = data.redirect_url;
                        } else if (data.status == 'error') {
                            $('#submitCheckoutForm').css({'background' : '#dc3545'});
                            $('#submitCheckoutForm').html('Something Went Wrong');
                            toastr.error(data.message);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
            }
        })


        {{--contact page only scripts--}}
        //contact form send request
        $('#contact-form').on('submit', function(event){
            event.preventDefault();
            let data = $(this).serialize();
            let sendBtn = $('#contact-submit');
            $.ajax({
                method: 'POST',
                url: '{{route('contact.send')}}',
                data: data,
                beforeSend: function (){
                    sendBtn.css({'background' : '#0088CC'});
                    sendBtn.html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                    sendBtn.attr('disabled', true);
                },
                success: function (data) {
                    if(data.status === 'success'){
                        sendBtn.css({'background' : '#198754'});
                        sendBtn.html('Sent!');
                        toastr.success(data.message);
                        $('#contact-form')[0].reset();
                        resetSendBtn();
                    }else if(data.status === 'error'){
                        sendBtn.css({'background' : '#dc3545'});
                        sendBtn.html('Error');
                        toastr.error(data.message);
                        resetContactSendBtn();
                    }
                },
                error: function (data){
                    let errors = data.responseJSON.errors;
                    console.log(errors);
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    })
                    sendBtn.css({'background' : '#dc3545'});
                    sendBtn.html('Error');
                    resetContactSendBtn();
                }
            })
        })
        //contact form helper
        function resetContactSendBtn() {
            setTimeout(
                function()
                {
                    let sendBtn = $('#contact-submit');
                    sendBtn.attr('disabled', false);
                    sendBtn.css({'background' : '#0088CC', 'class' : 'common_btn'});
                    sendBtn.html('Send Now');
                }, 1500);
        }


        {{--track order page only scripts--}}
        $('#track-form').on('submit', function (event) {
            event.preventDefault();
            let formData = $(this).serialize();
            let sendBtn = $('#track-submit');
            $.ajax({
                method: 'POST',
                url: '{{route('order-track.track')}}',
                data: formData,
                beforeSend: function () {
                    $('.track-info').addClass('d-none');
                    sendBtn.css({'background' : '#0088CC'});
                    sendBtn.html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                    sendBtn.attr('disabled', true);
                },
                success: function (data) {
                    if(data.status === 'success'){
                        sendBtn.css({'background' : '#198754'});
                        sendBtn.html('<i class="fas fa-check"></i>');
                        resetTrackSendBtn();
                        $('.track-info').removeClass('d-none');
                        $('#order-date').text(data.order_at);
                        $('#order-name').text(data.order_by);
                        $('#order-status').text(data.order_status);
                        $('#order-payment').text(data.payment);
                        orderProgress(data.order_status);
                    }else{
                        sendBtn.css({'background' : '#dc3545'});
                        sendBtn.html('Error');
                        toastr.error('Something Went Wrong!');
                        resetTrackSendBtn();
                    }
                },
                error: function (data) {
                    let errors = data.responseJSON.errors;
                    console.log(errors);
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    })
                    sendBtn.css({'background' : '#dc3545'});
                    sendBtn.html('Error');
                    resetTrackSendBtn();
                }
            })
        })
        function orderProgress(orderStatus) {
            if(
                orderStatus === 'Processed and ready to ship' ||
                orderStatus === 'Dropped-Off' ||
                orderStatus === 'Out for delivery' ||
                orderStatus === 'Delivered' ||
                orderStatus === 'Shipped'
            ){
                $('.icon_two').addClass('check_mark');
            }
            if(
                orderStatus === 'Delivered' ||
                orderStatus === 'Out for delivery'
            ){
                $('.icon_three').addClass('check_mark');
            }
            if(
                orderStatus === 'Delivered'
            ){
                $('.icon_four').addClass('check_mark');
            }
        }
        function resetTrackSendBtn() {
            setTimeout(
                function()
                {
                    let sendBtn = $('#track-submit');
                    sendBtn.attr('disabled', false);
                    sendBtn.css({'background' : '#0088CC', 'class' : 'common_btn'});
                    sendBtn.html('Track');
                }, 1500);
        }


        {{--payment page only scripts--}}
        $('.pay_button').on('click', function (){
            $(this).css({'background' : '#198754'});
            $(this).html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
        })

        {{--product details page only scripts (page still include specefic scripts)--}}
        $('.info-view').on('click', function (event) {
            let style = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: '{{route('change-product-info-view')}}',
                data: {
                    style: style
                },
                success: function (data) {

                },
                error: function (data) {
                    console.log(data)
                }
            })
        })


        {{--products page only scripts (page still include specefic scripts)--}}
        $('.list-view').on('click', function (event) {
            let style = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: '{{route('change-product-view')}}',
                data: {
                    style: style
                },
                success: function (data) {

                },
                error: function (data) {
                    console.log(data)
                }
            })
        })


        {{--wishlist page only scripts--}}
        //remove item from wishlist
        $('.remove-wishlist-item').on('click', function (e){
            e.preventDefault();
            let wishItem_id = $(this).data('id');
            $.ajax({
                url: '{{route('user.wishlist.destroy')}}',
                method: 'POST',
                data: {
                    id: wishItem_id,
                },
                success: function (data) {
                    Swal.fire(
                        'Removed',
                        data.message,
                        'success'
                    ).then((result) => {
                        // Reload the Page
                        location.reload();
                    });
                },
                error: function (data) {
                }
            })
        })
        // Increment product quantity
        $('.wishlist-product-increment').on('click', function(e){
            e.preventDefault();
            let input = $(this).siblings('.product-qty');
            let qty = parseInt(input.val()) +1;
            input.val(qty);
        })
        // decrement product quantity
        $('.wishlist-product-decrement').on('click', function(e){
            e.preventDefault();
            let input = $(this).siblings('.product-qty');
            let qty = parseInt(input.val()) -1;
            if(qty > 0){
                input.val(qty);
            }else{
                return;
            }
        })
    })
</script>
