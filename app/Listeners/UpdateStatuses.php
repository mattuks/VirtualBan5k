<?php

namespace App\Listeners;

use App\Enums\OperationStatus;
use App\Enums\TransactionStatus;
use App\Services\OperationService;
use App\Services\TransactionService;
use App\Transaction;

class UpdateStatuses
{
    /**
     * @var TransactionService
     */
    private $transactionService;
    /**
     * @var OperationService
     */
    private $operationService;

    /**
     * Create the event listener.
     *
     * @param TransactionService $transactionService
     * @param OperationService $operationService
     */
    public function __construct(TransactionService $transactionService, OperationService $operationService)
    {
        $this->transactionService = $transactionService;
        $this->operationService = $operationService;
    }

    /**
     * @param $event
     */
    public function handle($event)
    {
        $this->operationService->changeStatusAndSave($event->operation, new OperationStatus(OperationStatus::SUCCESS));
        $this->transactionService->setTransactionsStatusesToSuccess(Transaction::where('operation_id', $event->operation->getId())->get());
    }
}
