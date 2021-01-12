<?php

namespace App\Listeners;

use App\Enums\OperationStatus;
use App\Enums\TransactionStatus;
use App\Events\OperationCreated;
use App\Notifications\OperationStatusNotification;
use App\Operation;
use App\Services\OperationService;
use App\Services\TransactionService;
use App\Transaction;
use http\Client\Curl\User;
use Illuminate\Support\Facades\DB;

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
    public function handle(OperationCreated $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $this->transactionService->setTransactionsStatusesToSuccess(Transaction::where('operation_id',
                    $event->operation->getId())->get());
                $this->operationService->changeStatusAndSave($event->operation,
                    new OperationStatus(OperationStatus::SUCCESS));
                $this->operationService->notifyOperationUser($event->operation);
            });
        } catch (\Exception $exception) {
            DB::rollBack();
            logger($exception);
        }
    }
}
