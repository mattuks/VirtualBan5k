<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\OperationRequest;
use App\Jobs\CreateOperations;
use App\Notifications\OperationStatusNotification;
use App\Services\AccountService;
use App\Services\OperationService;
use App\Services\TransactionService;
use App\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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
        return view('transactions.create', ['account' => Account::where('id', $id)->firstOrFail()]);
    }

    /**
     * @param OperationRequest $request
     * @return RedirectResponse
     */
    public function store(OperationRequest $request)
    {
        $this->operationService->createOperation($request);


        return redirect()->back()->withInput($request->input());
    }


}
