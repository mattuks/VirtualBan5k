<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Events\OperationCreated;
use App\Factories\TransactionFactory;
use App\Services\AccountService;
use App\Services\ConversationService;
use App\Services\OperationService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;
class CreateTransactions
{
    /**
     * @var AccountService
     */
    private $accountService;
    /**
     * @var TransactionService
     */
    private $transactionService;
    /**
     * @var ConversationService
     */
    private $conversationService;
    /**
     * @var OperationService
     */
    private $operationService;

    /**
     * Create the event listener.
     *
     * @param OperationService $operationService
     * @param ConversationService $conversationService
     * @param AccountService $accountService
     * @param TransactionService $transactionService
     */
    public function __construct(OperationService $operationService, ConversationService $conversationService,AccountService $accountService, TransactionService $transactionService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
        $this->conversationService = $conversationService;
        $this->operationService = $operationService;
    }

    /**
     * @param OperationCreated $event
     */
    public function handle(OperationCreated $event)
    {
        try {
                DB::transaction(function () use ($event) {
                $this->transactionService->createOutTransaction(Account::where('uuid', $event->operation->getSenderUUID())
                    ->first(), $event);
                $this->transactionService->createInTransaction(Account::where('uuid', $event->operation->getReceiverUUID())
                    ->first(), $event);
                });
            } catch (\TypeError $typeError) {
                DB::rollBack();
                logger($typeError->getMessage());
            }
    }
}
