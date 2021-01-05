<?php


namespace App\Factories;


use App\Operation;

/**
 * Class OperationFactory
 * @package App\Factories
 */
class OperationFactory
{
    /**
     * @param array $data
     * @return Operation
     */
    public static function create(array $data): Operation
    {
        $operation = new Operation();
        $operation->setSenderUUID($data['sender_uuid']);
        $operation->setReceiverUUID($data['receiver_uuid']);
        $operation->setAmount($data['amount']);
        $operation->setCurrency($data['currency']);
        $operation->setStatus($data['status']);

        return $operation;
    }

}
