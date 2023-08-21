@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Category</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.category.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Icon</label>
                                <div class="mt-2 mb-3">
                                    <button name="icon" class="btn btn-primary" role="iconpicker" data-selected-class="btn-primary"
                                            data-unselected-class="btn-warning">
                                    </button>
                                </div>
{{--                                <input name="icon" type="text" class="form-control" value="{{old('icon')}}">--}}
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label>Category Slug</label>--}}
{{--                                <input name="slug" type="text" class="form-control" value="{{old('slug')}}">--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
