@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Admins</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Admins</h4>
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
                    url: '{{route('admin.admins-list.change-status')}}',
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
