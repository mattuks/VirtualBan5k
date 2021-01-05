@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header mb-2">
            <h2 class="text-center">Send Money</h2>
        </div>
        <div class="card-body pt-3">
            @if(session('failed'))
                <div class="alert alert-danger text-center">
                    {{session('failed')}}
                </div>
            @elseif(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @endif
            <form class="text-left" method="post" action="{{route('transaction-store')}}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="sender_uuid" value="{{$account->getUUID()}}" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon1">{{$account->getCurrency()}}</span>
                        <span class="input-group-text" id="basic-addon2">{{$account->getAmount()}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiver-account-number">Receiver account number</label>
                    <input type="text" class="form-control" id="receiver_uuid" name="receiver_uuid" value="{{old('receiver_uuid')}}">
                    @error('receiver_uuid')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <input type="hidden" value="{{$account->getCurrency()}}" name="currency" id="currency">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input class="form-control" type="number" id="amount" name="amount" value="{{old('amount')}}">
                    @error('amount')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="text-right">
                        <a href="{{route('home')}}" class="btn btn-danger mt-2">BACK</a>
                        <button type="submit" class="btn btn-success mt-2">SEND</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
