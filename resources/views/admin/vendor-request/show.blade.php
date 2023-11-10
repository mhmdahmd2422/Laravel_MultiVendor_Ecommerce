@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Vendor Request</h1>
        </div>
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">Submitted Form</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <td>User Name: </td>
                                        <td>{{$vendor->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>User Email: </td>
                                        <td>{{$vendor->user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Name: </td>
                                        <td>{{$vendor->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Phone: </td>
                                        <td>{{$vendor->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Address: </td>
                                        <td>{{$vendor->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Description: </td>
                                        <td>{{$vendor->description}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <div class="form-group banner">
                                        <label class="mb-4">Shop Banner</label>
                                        <img style="width: 15rem; height: 10rem;" class="bg-dark d-block" src="{{asset($vendor->banner)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-md-right">
                    <a href="{{route('admin.vendor-request.approve', ['activate' => $vendor->id])}}" class="btn btn-success btn-icon approve-item icon-left mr-5 text-white"><i class='fas fa-check-square' style='margin-right: 1rem'></i> Approve & Activate</a>
                    <a href="{{route('admin.vendor-request.approve', ['approve' => $vendor->id])}}" class="btn btn-primary btn-icon approve-item mr-5 text-white"><i class='fas fa-check-square' style='margin-right: 1rem'></i> Approve</a>
                    <button class="btn btn-warning btn-icon icon-left print-invoice"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('body').on('click', '.approve-item', function (event){
                event.preventDefault();

                let approveUrl = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: approveUrl,

                            success: function (data) {
                                if(data.status == 'success'){
                                    Swal.fire(
                                        'Approved!',
                                        data.message,
                                        'success'
                                    ).then((result) => {
                                        // Redirect
                                        window.location.href = data.page;
                                    });
                                }else if (data.status == 'error'){
                                    Swal.fire(
                                        'Failed To Approve',
                                        data.message,
                                        'error'
                                    ).then((result) => {
                                        // Redirect
                                        window.location.href = data.page;
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }
                        })
                    }
                })
            })
            $('.print-invoice').on('click', function (event){
                //before print
                let originalContents = $('body').html();
                $('.banner').addClass('d-none');
                let printBody = $('.invoice-print');
                $('body').html(printBody.html());
                window.print();
                $('body').html(originalContents);
            })
        })
    </script>
@endpush
