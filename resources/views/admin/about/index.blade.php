@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>About Page</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>About Page Content</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.about.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>About Image</label>
                                @if($about?->image)
                                    <img class="form-control" style="width: 20rem; height: 15rem" src="{{asset($about->image)}}">
                                @endif
                                <input name="image" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>About Content</label>
                                <textarea name="content" class="summernote">{!! @$about->content !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
