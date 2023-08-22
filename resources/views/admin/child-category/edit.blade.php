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
                        <form action="{{route('admin.sub-category.update', $sub_category->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="inputState">Parent Category</label>
                                <select name="category_id" id="inputState" class="form-control">
                                    <option>Select Parent</option>
                                    @foreach($categories as $category)
                                        <option {{$category->id == $sub_category->category_id ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub-Category Name</label>
                                <input name="name" type="text" class="form-control" value="{{$sub_category->name}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option {{$sub_category->status == 1 ? 'selected': ''}} value="1">Active</option>
                                    <option {{$sub_category->status == 0 ? 'selected': ''}} value="0">Inactive</option>
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
