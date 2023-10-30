@php
    $popular_cat_section = json_decode($popular_cat_section->value);
@endphp

<div class="tab-pane fade active show" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.popular-category-section.update')}}" method="post">
                @csrf
                @method('PUT')
                <h5>Category 1</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_one" class="form-control main-category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option {{$category->id == $popular_cat_section[0]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                            $sub_categories = \App\Models\SubCategory::where('category_id', $popular_cat_section[0]->category)->get();
                             @endphp
                            <label>Sub-Category</label>
                            <select {{$category->id == $popular_cat_section[0]->sub_category? 'selected': ''}} name="sub_cat_one" class="form-control sub-category">
                                <option value="">Select</option>
                                @foreach($sub_categories as $sub_category)
                                    <option {{$sub_category->id == $popular_cat_section[0]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                $child_categories = \App\Models\ChildCategory::where('sub_category_id', $popular_cat_section[0]->sub_category)->get();
                            @endphp
                            <label>Child-Category</label>
                            <select name="child_cat_one" class="form-control child-category">
                                <option value="">Select</option>
                                @foreach($child_categories as $child_category)
                                    <option {{$child_category->id == $popular_cat_section[0]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h5>Category 2</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_two" class="form-control main-category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option {{$category->id == $popular_cat_section[1]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                $sub_categories = \App\Models\SubCategory::where('category_id', $popular_cat_section[1]->category)->get();
                            @endphp
                            <label>Sub-Category</label>
                            <select {{$category->id == $popular_cat_section[1]->sub_category? 'selected': ''}} name="sub_cat_two" class="form-control sub-category">
                                <option value="">Select</option>
                                @foreach($sub_categories as $sub_category)
                                    <option {{$sub_category->id == $popular_cat_section[1]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                $child_categories = \App\Models\ChildCategory::where('sub_category_id', $popular_cat_section[1]->sub_category)->get();
                            @endphp
                            <label>Child-Category</label>
                            <select name="child_cat_two" class="form-control child-category">
                                <option value="">Select</option>
                                @foreach($child_categories as $child_category)
                                    <option {{$child_category->id == $popular_cat_section[1]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h5>Category 3</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_three" class="form-control main-category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option {{$category->id == $popular_cat_section[2]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sub-Category</label>
                            @php
                                $sub_categories = \App\Models\SubCategory::where('category_id', $popular_cat_section[2]->category)->get();
                            @endphp
                            <select name="sub_cat_three" class="form-control sub-category">
                                <option value="">Select</option>
                                @foreach($sub_categories as $sub_category)
                                    <option {{$sub_category->id == $popular_cat_section[2]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Child-Category</label>
                            @php
                                $child_categories = \App\Models\ChildCategory::where('sub_category_id', $popular_cat_section[2]->sub_category)->get();
                            @endphp
                            <select name="child_cat_three" class="form-control child-category">
                                <option value="">Select</option>
                                @foreach($child_categories as $child_category)
                                    <option {{$child_category->id == $popular_cat_section[2]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h5>Category 4</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_four" class="form-control main-category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option {{$category->id == $popular_cat_section[3]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sub-Category</label>
                            @php
                                $sub_categories = \App\Models\SubCategory::where('category_id', $popular_cat_section[3]->category)->get();
                            @endphp
                            <select name="sub_cat_four" class="form-control sub-category">
                                <option value="">Select</option>
                                @foreach($sub_categories as $sub_category)
                                    <option {{$sub_category->id == $popular_cat_section[3]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Child-Category</label>
                            @php
                                $child_categories = \App\Models\ChildCategory::where('sub_category_id', $popular_cat_section[3]->sub_category)->get();
                            @endphp
                            <select name="child_cat_four" class="form-control child-category">
                                <option value="">Select</option>
                                @foreach($child_categories as $child_category)
                                    <option {{$child_category->id == $popular_cat_section[3]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function (){
            $('body').on('change', '.main-category', function (e){
                let id = $(this).val();
                let row = $(this).closest('.row');
                $.ajax({
                    method: 'get',
                    url: '{{route('admin.get-subcategories')}}',
                    data: {
                        id: id,
                    },
                    success : function (data) {
                        let selector = row.find('.sub-category')
                        selector.html(`<option value="">Select</option>`)
                        $.each(data, function (i, item){
                            selector.append(`<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error : function (xhr, status, error) {
                        console.log(error);
                    }
                })
            })
            $('body').on('change', '.sub-category', function (e){
                let id = $(this).val();
                let row = $(this).closest('.row');
                $.ajax({
                    method: 'get',
                    url: '{{route('admin.get-childcategories')}}',
                    data: {
                        id: id,
                    },
                    success : function (data) {
                        let selector = row.find('.child-category')
                        selector.html(`<option value="">Select</option>`)
                        $.each(data, function (i, item){
                            selector.append(`<option value="${item.id}">${item.name}</option>`)
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
