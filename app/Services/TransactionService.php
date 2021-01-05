<?php


namespace App\Services;

use App\Enums\TransactionStatus;
use App\Factories\TransactionFactory;
use App\Transaction;

/**
 * Class TransactionService
 * @package App\Services
 */
class TransactionService
{
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
    public function changeStatusAndSave(Transaction $transaction, TransactionStatus $transactionStatus)
    {
        $transaction = $transaction->setStatus($transactionStatus)->save();

        return $transaction;
    }

    /**
     * @param $transactions
     */
    public function setTransactionsStatusesToSuccess($transactions): void
    {
        foreach ($transactions as $transaction) {

            if ($transaction->getDirection() == '1') {
                $this->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::RECEIVED));
            } else {
                $this->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::SENT));
            }
        }
    }
}


