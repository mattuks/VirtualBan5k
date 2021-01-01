<?php

namespace App\Http\Controllers;

use App\Account;
use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Factories\TransactionFactory;
use App\Services\AccountService;
use App\Services\OperationService;
use App\Services\TransactionService;
use App\Transaction;
use Cknow\Money\Money;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Money\Currency;

class TransactionController extends Controller
{
    /**
     * @var OperationService
     */
    private $operationService;
    /**
     * @var AccountService
     */
    private $accountService;
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * Create a new controller instance.
     *
     * @param OperationService $operationService
     * @param AccountService $accountService
     * @param TransactionService $transactionService
     */
    public function __construct(OperationService $operationService, AccountService $accountService, TransactionService $transactionService)
    {
        $this->middleware('auth');
        $this->operationService = $operationService;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('transactions.transactions', ['transactions' => Transaction::all()->where('user_id', auth()->id())]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('transactions.show', ['transactions' => Transaction::all()->where('account_id', $id)]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function create($id)
    {
        return view('transactions.create', ['account' => Account::where('id',$id)->firstOrFail()]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $operation = $this->operationService->create([
            'sender_uuid' => $request['sender_uuid'],
            'receiver_uuid' => $request['receiver_uuid'],
            'amount' => new Money($request['amount']*100,new Currency($request['currency'])),
            'currency' => new Currency($request['currency']),
            'status' => new OperationStatus(OperationStatus::PENDING),
        ]);
        event(new OperationCreated($operation));
    }
}
