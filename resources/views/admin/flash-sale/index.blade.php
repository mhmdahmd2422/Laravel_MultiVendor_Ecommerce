@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Flash Sale Products</h1>
        </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Flash Sale End-Date</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.flash-sale.update')}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sale End Date</label>
                                @if(isset($sale_date->end_date))
                                    <code>(Current date Is Displayed)</code>
                                @endif
                                <input name="end_date" type="text" class="form-control datepicker" value="{{$sale_date->end_date ?? \Carbon\Carbon::now()->toDateString()}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Flash Sale Product</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.flash-sale.add')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label style="display: block">Available Products</label>
                                <select name="product_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="row form-group">
                            <div class="col-6">
                                <label style="display: block">Show At Home?</label>
                                <select name="show_at_home" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label style="display: block">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add To Sale</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Flash Sale Products</h4>
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
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        $(document).ready(function (){
            $('body').on('click', '.change-checkbox', function (){
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{route('admin.flash-sale.change-status')}}',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
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

            $('body').on('click', '.change-show', function (){
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{route('admin.flash-sale.change-show')}}',
                    method: 'put',
                    data : {
                        show_at_home : isChecked,
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
