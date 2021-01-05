<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
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
     * @param object $event
     */
    public function handle(object $event)
    {
        DB::transaction(function () use ($event) {
            try {
                $this->createOutTransaction(Account::where('uuid', $event->operation->getSenderUUID())->first(), $event);
                $this->createInTransaction(Account::where('uuid', $event->operation->getReceiverUUID())->first(), $event);
            } catch (\TypeError $typeError) {
                DB::rollBack();
                logger($typeError->getMessage());
            }
        });
    }

    /**
     * @param $account
     * @param $event
     */
    public function createInTransaction($account, $event)
    {
        TransactionFactory::create([
            'user_id' => $account->getUserId(),
            'operation_id' => $event->operation->getId(),
            'account_id' => $account->getId(),
            'currency' => $account->getCurrency(),
            'status' => new TransactionStatus(TransactionStatus::PENDING),
            'type' => new TransactionType(TransactionType::TRANSFER),
            'direction' => new TransactionDirectionType(TransactionDirectionType::IN),
            'amount' => $this->conversationService->convertMoney($event->operation->getAmount(), $account->getCurrency())
        ])->save();
    }

    /**
     * @param $account
     * @param $event
     */
    public function createOutTransaction($account, $event)
    {
        TransactionFactory::create([
            'user_id' => $account->getUserId(),
            'operation_id' => $event->operation->getId(),
            'account_id' => $account->getId(),
            'currency' => $event->operation->getCurrency(),
            'status' => new TransactionStatus(TransactionStatus::PENDING),
            'type' => new TransactionType(TransactionType::TRANSFER),
            'direction' => new TransactionDirectionType(TransactionDirectionType::OUT),
            'amount' => $event->operation->getAmount()->negative()
        ])->save();
    }
}
