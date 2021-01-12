<?php


namespace App\Services;

use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Factories\TransactionFactory;
use App\Transaction;
use Illuminate\Support\Collection;

/**
 * Class TransactionService
 * @package App\Services
 */
class TransactionService
{
    /**
     * @var ConversationService
     */
    public $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    /**
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        return TransactionFactory::create($data);
    }

    /**
     * @param array $data
     * @return Transaction
     */
    public function createAndSave(array $data): Transaction
    {
        $transaction = TransactionFactory::create($data);
        $transaction->save();

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @param TransactionStatus $transactionStatus
     * @return bool
     */
    public function changeStatusAndSave(Transaction $transaction, TransactionStatus $transactionStatus): bool
    {
        $transaction = $transaction->setStatus($transactionStatus)->save();

        return $transaction;
    }

    /**
     * @param Collection $transactions
     */
    public function setTransactionsStatusesToSuccess(Collection $transactions): void
    {
        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getDirection()->value === TransactionDirectionType::IN) {
                $this->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::RECEIVED));
            } else{
                $this->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::SENT));
            }
        }
    }

    /**
     * @param $account
     * @param $event
     */
    public function createInTransaction($account, $event)
    {
        $this->createAndSave([
            'user_id' => $account->getUserId(),
            'operation_id' => $event->operation->getId(),
            'account_id' => $account->getId(),
            'currency' => $account->getCurrency(),
            'status' => new TransactionStatus(TransactionStatus::PENDING),
            'type' => new TransactionType(TransactionType::TRANSFER),
            'direction' => new TransactionDirectionType(TransactionDirectionType::IN),
            'amount' => $this->conversationService->convertMoney($event->operation->getAmount(), $account->getCurrency())
        ]);
    }

    /**
     * @param $account
     * @param $event
     */
    public function createOutTransaction($account, $event)
    {
        $this->createAndSave([
            'user_id' => $account->getUserId(),
            'operation_id' => $event->operation->getId(),
            'account_id' => $account->getId(),
            'currency' => $event->operation->getCurrency(),
            'status' => new TransactionStatus(TransactionStatus::PENDING),
            'type' => new TransactionType(TransactionType::TRANSFER),
            'direction' => new TransactionDirectionType(TransactionDirectionType::OUT),
            'amount' => $event->operation->getAmount()->negative()
        ]);
    }
}


