@extends('layouts.app')
@section('content')
<div class="card mt-2">
    <div class="card-header">
        <h3 class="text-center">Open Account</h3>
    </div>
    <div class="card-body">
        <form action="{{route('account-store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="currency">Currency</label>
                <select class="form-control" id="currency" name="currency">
                    @foreach(config('currencies.available') as $currency)
                        <option>{{$currency}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary btn-block">Create Account</button>
        </form>
    </div>
</div>
@endsection
