@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sub-Category</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Sub-Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.sub-category.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="inputState">Parent Category</label>
                                <select name="category_id" id="inputState" class="form-control">
                                    <option>Select Parent</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub-Category Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
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
