@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Shipping Methods</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Shipping</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.shipping.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Shipping Name</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Shipping Type</label>
                                <select name="type" id="inputState" class="form-control shipping-type">
                                    <option value="">Select</option>
                                    <option {{old('type') == 'flat_cost' ? 'selected' : ''}} value="flat_cost">Flat Cost</option>
                                    <option {{old('type') == 'min_cost' ? 'selected' : ''}} value="min_cost">Minimum Order Amount</option>
                                </select>
                            </div>
                            <div class="form-group min-cost {{old('type') == 'min_cost'? '' : 'd-none'}}">
                                <label>Minimum Amount</label>
                                <input name="min_cost" type="number" class="form-control" value="{{old('min_cost')}}">
                            </div>
                            <div class="form-group">
                                <label>Cost</label>
                                <input name="cost" type="number" class="form-control" value="{{old('cost')}}">
                                <input name="currency" type="text" class="form-control d-none" value="{{$settings->currency_icon}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{old('status') == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                    <option {{old('status') == '1' ? 'selected' : ''}} value="1">Active</option>
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
            $('body').on('change', '.shipping-type', function (){
                let value = $(this).val();

                if (value !== 'min_cost'){
                    $('.min-cost').addClass('d-none')
                }else{
                    $('.min-cost').removeClass('d-none')
                }
            })
        })
    </script>
@endpush

