@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Vendor</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Vendor Conditions</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.vendor-condition.update')}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Conditions</label>
                                <textarea name="content" class="summernote">{!! @$condition->content !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
