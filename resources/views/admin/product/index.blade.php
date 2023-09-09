@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Created Products</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.product.create')}}" class="btn btn-primary" style="font-weight: bolder; font-size: 1rem"><i class="fas fa-plus mr-1"></i> Create New</a>
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
@endpush
