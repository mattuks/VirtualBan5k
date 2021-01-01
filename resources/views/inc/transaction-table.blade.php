<div class="card">
    <div class="card-header bg-white">
        <h2 class="text-center">Transactions</h2>
    </div>
    @if(count($transactions)>0)
        <div class="card-body">
            <table class="table border">
                <thead class="text-center">
                <tr>
                    <th scope="col">Transaction date</th>
                    <th scope="col">Operation ID</th>
                    <th scope="col">Receiver Account</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Type</th>
                    <th scope="col">Direction</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($transactions as $transaction)
                    <tr class="border">
                        <td>{{$transaction->created_at}}</td>
                        <td>{{$transaction->getOperationID()}}</td>
                        <td>{{$transaction->operation->getSenderUUID()}}</td>
                        <td>{{$transaction->getAmount()}}</td>
                        <td>{{$transaction->getStatus()->key}}</td>
                        <td>{{$transaction->getType()->key}}</td>
                        <td>{{$transaction->getDirection()->key}}</td>
                        <td>
                            <a href=""><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center p-4 text-muted">There is no transactions made yet</p>
    @endif
</div>

