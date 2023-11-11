@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Contact Us
@endsection
@section('content')
<!--============================
    CONTACT PAGE START
==============================-->
<section id="wsus__contact">
    <div class="container">
        <div class="wsus__contact_area">
            <div class="row">
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="fal fa-envelope"></i>
                                <h5>mail address</h5>
                                <a href="mailto:{{@$contact_data->email}}">{{@$contact_data->email}}</a>
                                <span><i class="fal fa-envelope"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="far fa-phone-alt"></i>
                                <h5>phone number</h5>
                                <a href="macallto:{{@$contact_data->phone}}">{{@$contact_data->phone}}</a>
                                <span><i class="far fa-phone-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="fal fa-map-marker-alt"></i>
                                <h5>Head Office Address</h5>
                                <p>{{@$contact_data->address}}</p>
                                <span><i class="fal fa-map-marker-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="wsus__contact_question">
                        <h5>Send Us a Message</h5>
                        <form id="contact-form">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input name="name" type="text" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input name="email" type="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input name="subject" type="text" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <textarea name="message" cols="3" rows="5" placeholder="Message"></textarea>
                                    </div>
                                    <button id="contact-submit" type="submit" class="common_btn">send now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    CONTACT PAGE END
==============================-->

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#contact-form').on('submit', function(event){
            event.preventDefault();
            let data = $(this).serialize();
            let sendBtn = $('#contact-submit');
            $.ajax({
                method: 'POST',
                url: '{{route('contact.send')}}',
                data: data,
                beforeSend: function (){
                    sendBtn.css({'background' : '#0088CC'});
                    sendBtn.html('<i class="fas fa-spinner fa-spin fa-1x"></i>');
                    sendBtn.attr('disabled', true);
                },
                success: function (data) {
                    if(data.status === 'success'){
                        sendBtn.css({'background' : '#198754'});
                        sendBtn.html('Sent!');
                        toastr.success(data.message);
                        $('#contact-form')[0].reset();
                        resetSendBtn();
                    }else if(data.status === 'error'){
                        sendBtn.css({'background' : '#dc3545'});
                        sendBtn.html('Error');
                        toastr.error(data.message);
                        resetSendBtn();
                    }
                },
                error: function (data){
                    let errors = data.responseJSON.errors;
                    console.log(errors);
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    })
                    sendBtn.css({'background' : '#dc3545'});
                    sendBtn.html('Error');
                    resetSendBtn();
                }
            })
        })
        function resetSendBtn() {
            setTimeout(
                function()
                {
                    let sendBtn = $('#contact-submit');
                    sendBtn.attr('disabled', false);
                    sendBtn.css({'background' : '#0088CC', 'class' : 'common_btn'});
                    sendBtn.html('Send Now');
                }, 1500);
        }
    })
</script>
@endpush
