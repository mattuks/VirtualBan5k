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
use App\User;
use Carbon\Carbon;
use Cknow\Money\Money;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Money\Currency;

/**
 * Class OperationService
 * @package App\Services
 */
class OperationService extends MoneyService
{
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * OperationService constructor.
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

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
     * @param $operation
     */
    public function sendNotificationAboutOperationStatusToUser($operation)
    {
        $user = User::where('id', $operation->getUserId())->first();
        $user->notify(new OperationCreatedNotification($operation));
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
     * @return bool
     */

    private function checkAccountFunds($request)
    {
        if ($request['amount'] * 100 <= intval(Account::where('uuid', $request['sender_uuid'])->first()->getAmount()->getAmount())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $request
     * @return RedirectResponse
     */
    public function createOperation($request)
    {

        if (!$this->checkAccountFunds($request)) {

            return back()->with('failed', 'Insufficient account balance');

        } else {
            $this->createMoney($request['amount'], new Currency($request['currency']));

            $this->accountService->subtractFromAmount(Account::where('id', $request['account_id'])->first(), $this->createMoney($request['amount'], new Currency($request['currency'])));

            dispatch(new CreateOperations($request->all(), $request->user()))->delay(Carbon::now()->addSeconds(10));

            return back()->with('success', 'Transaction has been made check for status in the Notification page.');
        };
    }
}
