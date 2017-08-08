<!-- Feedback -->
@if (count($errors) > 0)
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger fade in">
            <b>Attention</b>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

@if (session('success') && !is_array(session('success')))
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-success fade in">
            <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! session('success') !!}
        </div>
    </div>
</div>
@endif

@if (session('error') && !is_array(session('error')))
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! session('error') !!}
        </div>
    </div>
</div>
@endif

@push('script')
<script type="text/javascript">
@if (session('success') && is_array(session('success')))
    swal("{!! session('success')['title'] !!}", "{!! session('success')['msg'] !!}", "success")
@endif

@if (session('error') && is_array(session('error')))
    swal("{!! session('error')['title'] !!}", "{!! session('error')['msg'] !!}", "error")
@endif

@if (session('success_toast'))
    toastr("{!! session('success_toast') !!}");
@endif

@if (session('error_toast'))
    toastr("{!! session('error_toast') !!}");
@endif

</script>
@endpush

<!-- End Feedback -->