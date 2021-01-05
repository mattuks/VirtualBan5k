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
                    <option>EUR</option>
                    <option>USD</option>
                    <option>GBP</option>
                </select>
            </div>
            <button class="btn btn-primary btn-block">Create Account</button>
            <a href="{{route('home')}}" class="btn btn-danger btn-block">Cancel</a>
        </form>
    </div>
</div>
@endsection
