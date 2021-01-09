<?php


namespace App\Services;

use App\Account;
use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Factories\OperationFactory;
use App\Operation;
use Cknow\Money\Money;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Money\Currency;

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
     * @return RedirectResponse
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

    /**
     * @param Request $request
     */
    public function createOperation(Request $request): void
    {
        try {
            DB::transaction(function () use ($request) {
                $operation = $this->create([
                    'sender_uuid' => $request['sender_uuid'],
                    'receiver_uuid' => $request['receiver_uuid'],
                    'amount' => new Money($request['amount'] * 100, new Currency($request['currency'])),
                    'currency' => new Currency($request['currency']),
                    'status' => new OperationStatus(OperationStatus::PENDING),
                ]);

                $this->checkAccountAmount($operation, $request);
            });

        } catch (\Exception $exception) {
            logger($exception->getMessage());
            db::rollBack();
        };
    }
}
