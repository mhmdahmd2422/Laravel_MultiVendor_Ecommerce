@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Blog Post</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.blog.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Image</label>
                                <input name="image" type="file" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="title" type="text" class="form-control" value="{{old('title')}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="inputState">Blog Category</label>
                                        <select name="category_id" id="inputState" class="form-control main-category">
                                            <option>Select Category</option>
                                            @foreach($categories as $category)
                                                <option {{old('category_id') === $category->id? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Post Content</label>
                                <textarea name="post_content" class="summernote">{{old('post_content')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>SEO Title</label>
                                <input name="seo_title" type="text" class="form-control" value="{{old('seo_title')}}">
                            </div>
                            <div class="form-group">
                                <label>SEO Description</label>
                                <textarea name="seo_description" class="form-control">{{old('seo_description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{old('status') === 1? 'selected': ''}} value="1">Active</option>
                                    <option {{old('status') === 0? 'selected': ''}} value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')

@endpush

