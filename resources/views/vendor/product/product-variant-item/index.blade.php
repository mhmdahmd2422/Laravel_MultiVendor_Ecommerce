@extends('vendor.layouts.master')

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="mb-3">
                            <a href="{{route('vendor.products-variant.showTable', $product->id)}}" class="btn btn-warning" ><i class="fas fa-chevron-left"  style="margin-right: 0.8rem"></i>Back</a>
                        </div>
                        <h3><i class="fal fa-gift-card"></i>Product Variant Items</h3>
                        <div class="create_button mb-3" style="text-align: right;">
                            <a href="{{route('vendor.product-variant-items.create' , ['product_id' => $product->id, 'variant_id' => $variant->id])}}" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 0.75rem"></i>Create New</a>
                        </div>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <div class="card-header mb-3">
                                    <h4>Selected Product: {{$variant->name}}</h4>
                                </div>
                            {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function (){
            $('body').on('click', '.change-checkbox', function (){
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{route('vendor.product-variant-items.change-status')}}',
                    method: 'put',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data : {
                        status : isChecked,
                        id : id,
                    },
                    success: function (data){
                        toastr.success(data.message)
                    },
                    error: function (xhr, status, error){
                        console.log(error);
                    },
                })
            })
        })
    </script>
@endpush

