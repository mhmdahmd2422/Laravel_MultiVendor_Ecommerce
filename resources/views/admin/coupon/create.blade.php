@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupons</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Coupon</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.coupons.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Name</label>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Code</label>
                                        <input name="code" type="text" class="form-control" value="{{old('code')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Quantity</label>
                                        <input name="quantity" type="number" class="form-control" value="{{old('quantity')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Max Use Per User</label>
                                        <input name="max_use" type="number" class="form-control" value="{{old('max_use')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Start-Date</label>
                                        <input name="start_date" type="text" class="form-control datepicker" value="{{old('start_date')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon End-Date</label>
                                        <input name="end_date" type="text" class="form-control datepicker" value="{{old('end_date')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputState">Discount Type</label>
                                        <select name="discount_type" id="inputState" class="form-control">
                                            <option value="">Select</option>
                                            <option {{old('discount_type') == 'percent' ? 'selected' : ''}} value="percent">Percentage (%)</option>
                                            <option {{old('discount_type') == 'amount' ? 'selected' : ''}} value="amount">Amount ({{$settings->currency_icon}})</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Discount Value</label>
                                        <input name="discount_value" type="number" class="form-control" value="{{old('discount_value')}}">
                                    </div>
                                </div>
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

