@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Product Variants</h1>
        </div>
    <div class="mb-3">
        <a href="{{route('admin.product.index')}}" class="btn btn-warning">Back</a>
    </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Created Product Variants For: {{$product->name}}</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.products-variant.create', ['product_id' => $product->id])}}" class="btn btn-primary" style="font-weight: bolder; font-size: 1rem"><i class="fas fa-plus mr-1"></i> Create New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
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
                    url: '{{route('admin.product-variant.change-status')}}',
                    method: 'put',
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
