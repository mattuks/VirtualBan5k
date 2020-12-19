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
        $operation->setType($data['type']);

        return $operation;
    }

}
