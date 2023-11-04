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
                        <h4>Edit Social Link</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.footer-social.update', $footer_social->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Icon</label>
                                <div>
                                    <button name="icon" data-icon="{{$footer_social->icon}}" class="btn btn-primary" role="iconpicker" data-selected-class="btn-primary"
                                            data-unselected-class="btn-warning">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Social Name</label>
                                        <input name="name" type="text" class="form-control" value="{{$footer_social->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>URL</label>
                                        <input name="url" type="text" class="form-control" value="{{$footer_social->url}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{$footer_social->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                    <option {{$footer_social->status == '1' ? 'selected' : ''}} value="1">Active</option>
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

