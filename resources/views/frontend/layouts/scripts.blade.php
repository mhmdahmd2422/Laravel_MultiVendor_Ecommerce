<script>
    $(document).ready(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                    }else if (data.status == 'error') {
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            })
        })
        //remove item from sidebar cart
        $('.remove-sidebar-item').on('click', function (e){
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
                    getSidebarCartSubtotal();
                    getCartCount()
                    toastr.success(data.message);
                },
                error: function (data) {
                }
            })
        })
        //update bag icon counter
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
    })
</script>
