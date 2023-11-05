@extends('admin.layouts.master')

@section('content')
<section class="section">
        <div class="section-header">
            <h1>Newsletter Subscribers</h1>
        </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Send Newsletter to {{\App\Models\NewsletterSubscriber::verified()->count()}} Subscribers</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.newsletter.send')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Subject</label>
                            <input name="subject" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="summernote editor"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Subscribers</h4>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $('.editor').summernote({
            height: 80,   //don't use px
        });
    </script>
@endpush
