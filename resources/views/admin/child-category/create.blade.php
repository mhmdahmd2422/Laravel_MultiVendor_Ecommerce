@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Child-Category</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Child-Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.child-category.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="inputState">Parent Category</label>
                                <select name="category_id" id="inputState" class="form-control main-category">
                                    <option>Select Parent</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Sub Category</label>
                                <select name="sub_category_id" id="inputState" class="form-control sub-category">
                                    <option>Select Sub Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Child-Category Name</label>
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

@push('scripts')
    <script>
        $(document).ready(function (){
            $('body').on('change', '.main-category', function (e){
                let id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: '{{route('admin.get-subcategories')}}',
                    data: {
                        id: id,
                    },
                    success : function (data) {
                        $('.sub-category').html(`<option>Select Sub Category</option>`)
                        $.each(data, function (i, item){
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error : function (xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
