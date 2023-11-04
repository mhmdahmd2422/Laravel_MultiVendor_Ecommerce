@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grid Two Title</h4>
                </div>
                <div class="card-body">
                    <div class="col-4">
                        <form action="{{route('admin.footer-grid-two.change-title')}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Grid Two Title</label>
                                <input type="text" class="form-control" name="title" value="{{@$grid_title->grid_two_title}}">
                                <button type="submit" class="btn btn-primary mt-3">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Created Grid Two Links</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.footer-grid-two.create')}}" class="btn btn-primary" style="font-weight: bolder; font-size: 1rem"><i class="fas fa-plus mr-1"></i> Create</a>
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
                    url: '{{route('admin.footer-grid-two.change-status')}}',
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
