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
                        <h4>Edit Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.category.update', $category->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Icon</label>
                                <div class="mt-2 mb-3">
                                    <button name="icon" data-icon="{{$category->icon}}" class="btn btn-primary" role="iconpicker" data-selected-class="btn-primary"
                                            data-unselected-class="btn-warning">
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input name="name" type="text" class="form-control" value="{{$category->name}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option {{$category->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$category->status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
