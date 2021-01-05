<?php


namespace App\Services;

use App\Account;
use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Factories\OperationFactory;
use App\Operation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

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

    /**
     * @param Operation $operation
     * @param OperationStatus $operationStatus
     * @return bool
     */
    public function changeStatusAndSave(Operation $operation, OperationStatus $operationStatus)
    {
        $operation = $operation->setStatus($operationStatus)->save();

        return $operation;
    }

    /**
     * @param Operation $operation
     * @param $request
     */
    public function checkAccountAmount(Operation $operation, $request){
        if (Account::where('uuid',$request['sender_uuid'])->first()->getAmount()->lessThanOrEqual($operation->getAmount())){
            $this->changeStatusAndSave($operation, new OperationStatus(OperationStatus::FAILED));
            return back()->with('failed', 'Insufficient account balance');
        }else{
            $operation->save();
            event(new OperationCreated($operation));
            return back()->with('success', 'Money has been sent!');
        }
    }
}
