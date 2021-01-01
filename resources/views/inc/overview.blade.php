<div class="row">
    @foreach($accounts as $account)
        <div class="col">
            <div class="card shadow">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5>{{$account->getName()}}</h5>
                        <p>{{$account->getUUID()}}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                            <h2>{{$account->getAmount()}}</h2>
                    </div>
                </div>
                <div class="text-right p-2">
                    <a href="{{route('account-transactions', $account->getId())}}" class="btn btn-outline-primary">Account Transactions</a>
                    <a href="{{route('transaction-create', $account)}}" class="btn btn-outline-primary">
                        Send Money
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

