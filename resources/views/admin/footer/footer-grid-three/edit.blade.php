@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Tab Link</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.footer-grid-three.update', $footer_grid_three->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tab Name</label>
                                        <input name="name" type="text" class="form-control" value="{{$footer_grid_three->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>URL</label>
                                        <input name="url" type="text" class="form-control" value="{{$footer_grid_three->url}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{$footer_grid_three->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                    <option {{$footer_grid_three->status == '1' ? 'selected' : ''}} value="1">Active</option>
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

