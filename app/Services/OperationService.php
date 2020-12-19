<?php


namespace App\Services;

use App\Factories\OperationFactory;
use App\Operation;

/**
 * Class OperationService
 * @package App\Services
 */
class OperationService
{
    /**
     * @param array $data
     * @return Operation
     */
    public function create(array $data): Operation
    {
        return OperationFactory::create($data);
    }

    /**
     * @param array $data
     * @return Operation
     */
    public function createAndSave(array $data): Operation
    {
        $operation = OperationFactory::create($data);
        $operation->save();

        return $operation;
    }
}
