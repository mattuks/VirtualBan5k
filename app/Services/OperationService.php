<?php


namespace App\Services;

use App\Account;
use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Factories\OperationFactory;
use App\Http\Requests\OperationRequest;
use App\Jobs\CreateOperations;
use App\Notifications\OperationCreatedNotification;
use App\Operation;
use Carbon\Carbon;
use Cknow\Money\Money;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
     * @param $request
     * @return RedirectResponse
     */

    public function checkAccountFunds($request)
    {
        if ($request['amount'] * 100 <= intval(Account::where('uuid', $request['sender_uuid'])->first()->getAmount()->getAmount())) {
            dispatch(new CreateOperations($request->all(), $request->user()))->delay(Carbon::now()->addSeconds(90));
            return back()->with('success', 'Transaction has been made check for status in the Notification page.');
        } else {
            return back()->with('failed', 'Insufficient account balance');
        }
    }
//
//    /**
//     * @param OperationRequest $request
//     */
//    public static function createOperation(OperationRequest $request): void
//    {
//        try {
//            DB::transaction(function () use ($request) {
//                $operation = $this->createAndSave([
//                    'sender_uuid' => $request['sender_uuid'],
//                    'receiver_uuid' => $request['receiver_uuid'],
//                    'amount' => new Money($request['amount'] * 100, new Currency($request['currency'])),
//                    'currency' => new Currency($request['currency']),
//                    'status' => new OperationStatus(OperationStatus::PENDING),
//                ]);
//                $request->user()->notify(new OperationCreatedNotification($operation));
//                event(new OperationCreated($operation));
//            });
//
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            logger($exception->getMessage());
//            $operation = $this->createAndSave([
//                'sender_uuid' => $request['sender_uuid'],
//                'receiver_uuid' => $request['receiver_uuid'],
//                'amount' => new Money($request['amount'] * 100, new Currency($request['currency'])),
//                'currency' => new Currency($request['currency']),
//                'status' => new OperationStatus(OperationStatus::FAILED),
//            ]);
//            $request->user()->notify(new OperationCreatedNotification($operation));
//        };
//    }
}
