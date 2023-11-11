@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Terms and Conditions</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Terms and Conditions Text</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.terms-and-conditions.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Terms and Conditions Content</label>
                                <textarea name="content" class="summernote">{!! @$terms->content !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
