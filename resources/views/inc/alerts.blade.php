@if (session()->has('failed'))
    <div class="alert alert-danger text-center">
        {!! session('failed') !!}
    </div>
@endif

@if (session()->has('success'))
        <div class="alert alert-success text-center">
            {!! session()->pull('success') !!}
        </div>
@endif
