<?php

namespace App\Listeners;

use App\Enums\OperationStatus;
use App\Enums\TransactionStatus;
use App\Operation;
use App\Services\OperationService;
use App\Services\TransactionService;
use App\Transaction;
use function Symfony\Component\String\s;

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
        $this->transactionService->setTransactionsStatusesToSuccess(Transaction::where('operation_id', $event->operation->getId())->get());
        $this->operationService->changeStatusAndSave(Operation::where('id',$event->operation->getId())->first(), new OperationStatus(OperationStatus::SUCCESS));
    }
}
