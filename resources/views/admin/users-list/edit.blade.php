@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.user.update', $user->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Profile Photo</label>
                                @if($user?->image)
                                    <div>
                                        <img src="{{asset($user?->image)}}" class="mt-3 mb-3" style="width: 15rem; height: 10rem;" alt="Profile Photo">
                                    </div>
                                @else
                                    <h6>No Current Photo</h6>
                                @endif
                                <input name="banner" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" type="text" class="form-control" placeholder="{{$user->username === null? 'Not Provided': ''}}" value="{{$user?->username}}">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input name="phone" type="text" class="form-control phone-number" placeholder="{{$user->phone === null? 'Not Provided': ''}}" value="{{$user?->phone}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input name="email" type="email" class="form-control" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Role</label>
                                <select name="role" class="form-control role">
                                    <option value="">Select</option>
                                    <option {{$user->role == 'user' ? 'selected': ''}} value="user">User</option>
                                    <option {{$user->role == 'vendor' ? 'selected': ''}} value="vendor">Vendor</option>
                                    <option {{$user->role == 'admin' ? 'selected': ''}} value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select name="status" id="inputState" class="form-control">
                                    <option value="">Select</option>
                                    <option {{$user->status == 'active' ? 'selected': ''}} value="active">Active</option>
                                    <option {{$user->status == 'inactive' ? 'selected': ''}} value="inactive">Inactive</option>
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

@push('scripts')
    <script>
        $(document).ready(function (){
            $('body').on('change', '.role', function (){
                let value = $(this).val();
                if (value === 'vendor'){
                    window.location.href = '{{route('admin.vendor.create')}}';
                }
            })
        })
    </script>
@endpush
