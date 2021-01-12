@extends('layouts.app')
@section('content')
    <h1 class="text-center">Notifications</h1>
    <div class="container pt-2">
        @forelse($notifications as $notification)
            @if($notification->data['status'] === \App\Enums\OperationStatus::SUCCESS)
                <div class="alert alert-success" role="alert">
                    Your transfer of {{$notification->data['amount'] / 100}}{{$notification->data['currency']}} to {{$notification->data['receiver_uuid']}} was successful.
                </div>
            @elseif($notification->data['status'] === \App\Enums\OperationStatus::FAILED)
                <div class="alert alert-danger" role="alert">
                    Your transfer of {{$notification->data['amount'] / 100}}{{$notification->data['currency']}} to {{$notification->data['receiver_uuid']}} had failed try again later.
                </div>
            @elseif($notification->data['status'] === \App\Enums\OperationStatus::PENDING)
                <div class="alert alert-warning" role="alert">
                    Your transfer of {{$notification->data['amount'] / 100}}{{$notification->data['currency']}} to {{$notification->data['receiver_uuid']}} is pending.
                </div>
            @endif
        @empty
            <div class="alert alert-light" role="alert">
                You have no notifications!
            </div>
        @endforelse
    </div>

@endsection
