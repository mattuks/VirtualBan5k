<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Services\AccountService;
use App\Services\TransactionService;
use App\Transaction;
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
     * Create the event listener.
     *
     * @param AccountService $accountService
     * @param TransactionService $transactionService
     */
    public function __construct(AccountService $accountService, TransactionService $transactionService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    /**
     * @param object $event
     */
    public function handle(object $event)
    {
        DB::transaction(function () use ($event) {
            try {
                $event->operation->save();
                $accounts = [
                    'sender' => Account::where('uuid', $event->operation->getSenderUUID())->first(),
                    'receiver' => Account::where('uuid', $event->operation->getReceiverUUID())->first(),
                ];

                foreach ($accounts as $accountType => $account) {
                    $transaction = new Transaction();
                    $transaction->setUserId($account->getUserId());
                    $transaction->setOperationId($event->operation->getId());
                    $transaction->setAccountId($account->getId());
                    $transaction->setCurrency($event->operation->getCurrency());
                    if ($accountType == 'sender') {
                        $transaction->setStatus(new TransactionStatus(TransactionStatus::PENDING));
                        $transaction->setType(new TransactionType(TransactionType::TRANSFER));
                        $transaction->setDirection(new TransactionDirectionType(TransactionDirectionType::OUT));
                        $transaction->setAmount($event->operation->getAmount()->negative());
                    } elseif ($accountType == 'receiver') {
                        $transaction->setStatus(new TransactionStatus(TransactionStatus::PENDING));
                        $transaction->setType(new TransactionType(TransactionType::TRANSFER));
                        $transaction->setDirection(new TransactionDirectionType(TransactionDirectionType::IN));
                        $transaction->setAmount($event->operation->getAmount());
                    }
                    $transaction->save();
                };


            } catch (\TypeError $typeError) {
                DB::rollBack();
                logger($typeError->getMessage());
            }
        });
    }
}
