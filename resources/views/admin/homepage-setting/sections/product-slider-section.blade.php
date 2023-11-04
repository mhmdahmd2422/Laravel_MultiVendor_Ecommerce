<div class="tab-pane fade" id="list-slider" role="tabpanel" aria-labelledby="list-slider-three">
    <div class="card border">
        <div class="card-body">
            <h5 class="mb-3">Product Slider Section</h5>
            <form action="{{route('admin.product-slider-section.update')}}" method="post">
                @csrf
                @method('PUT')
                <h6>Part 1</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_one" class="form-control main-category">
                                <option value="">Select</option>
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <option {{$category->id == @$product_slider_section[0]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                if($product_slider_section){
                                    $sub_categories = \App\Models\SubCategory::where('category_id', $product_slider_section[0]->category)->active()->get();
                                }
                            @endphp
                            <label>Sub-Category</label>
                            <select name="sub_cat_one" class="form-control sub-category">
                                <option value="">Select</option>
                                @if(isset($sub_categories))
                                    @foreach($sub_categories as $sub_category)
                                        <option {{$sub_category->id == @$product_slider_section[0]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                if($product_slider_section){
                                    $child_categories = \App\Models\ChildCategory::where('sub_category_id', $product_slider_section[0]->sub_category)->active()->get();
                                }
                            @endphp
                            <label>Child-Category</label>
                            <select name="child_cat_one" class="form-control child-category">
                                <option value="">Select</option>
                                @if(isset($child_categories))
                                    @foreach($child_categories as $child_category)
                                        <option {{$child_category->id == @$product_slider_section[0]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <h6>Part 2</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_two" class="form-control main-category">
                                <option value="">Select</option>
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <option {{$category->id == @$product_slider_section[1]->category? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                if($product_slider_section){
                                    $sub_categories = \App\Models\SubCategory::where('category_id', $product_slider_section[1]->category)->active()->get();
                                }
                            @endphp
                            <label>Sub-Category</label>
                            <select name="sub_cat_two" class="form-control sub-category">
                                <option value="">Select</option>
                                @if(isset($sub_categories))
                                    @foreach($sub_categories as $sub_category)
                                        <option {{$sub_category->id == @$product_slider_section[1]->sub_category? 'selected': ''}} value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                if($product_slider_section){
                                    $child_categories = \App\Models\ChildCategory::where('sub_category_id', $product_slider_section[1]->sub_category)->active()->get();
                                }
                            @endphp
                            <label>Child-Category</label>
                            <select name="child_cat_two" class="form-control child-category">
                                <option value="">Select</option>
                                @if(isset($child_categories))
                                    @foreach($child_categories as $child_category)
                                        <option {{$child_category->id == @$product_slider_section[1]->child_category? 'selected': ''}} value="{{$child_category->id}}">{{$child_category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <input name="section" type="hidden" value="product_slider_section">
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
