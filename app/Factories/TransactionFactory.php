<?php


namespace App\Factories;


use App\Transaction;
use Psy\Exception\FatalErrorException;

/**
 * Class TransactionFactory
 * @package App\Factories
 */
class TransactionFactory
{
    /**
     * @param array $data
     * @return Transaction
     */
    public static function create(array $data): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUserId($data['user_id']);
        $transaction->setOperationId($data['operation_id']);
        $transaction->setAccountId($data['account_id']);
        $transaction->setCurrency($data['currency']);
        $transaction->setStatus($data['status']);
        $transaction->setType($data['type']);
        $transaction->setDirection($data['direction']);
        $transaction->setAmount($data['amount']);
        return $transaction;
    }

}
