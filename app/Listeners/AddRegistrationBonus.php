<?php declare(strict_types=1);

namespace App\Listeners;

use App\Enums\OperationType;
use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Events\AccountCreated;
use App\Services\AccountService;
use App\Services\OperationService;
use App\Services\TransactionService;
use Cknow\Money\Money;
use Illuminate\Support\Facades\DB;

/**
 * Class AddRegistrationBonus
 * @package App\Listeners
 */
class AddRegistrationBonus
{
    /**
     * @var OperationService
     */
    private $operationService;
    /**
     * @var TransactionService
     */
    private $transactionService;
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * AddRegistrationBonus constructor.
     * @param OperationService $operationService
     * @param TransactionService $transactionService
     */
    public function __construct(OperationService $operationService, TransactionService $transactionService, AccountService $accountService)
    {
        $this->operationService = $operationService;
        $this->transactionService = $transactionService;
        $this->accountService = $accountService;
    }

    /**
     * @param AccountCreated $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(AccountCreated $event)
    {

        DB::transaction(function () use ($event) {
            try {
                $event->account->save();
                $operation = $this->operationService->createAndSave([
                    'type' => new OperationType(OperationType::PENDING),
                ]);
                $transaction = $this->transactionService->createAndSave([
                    'user_id' => $event->account->getUserId(),
                    'operation_id' => $operation->getId(),
                    'account_id' => $event->account->getId(),
                    'currency' => $event->account->getCurrency(),
                    'status' => new TransactionStatus(TransactionStatus::PENDING),
                    'type' => new TransactionType(TransactionType::BONUS),
                    'direction' => new TransactionDirectionType(TransactionDirectionType::IN),
                    'amount' => new Money(100000, $event->account->getCurrency()),
                ]);
                $event->account->setAmount($transaction->getAmount())->save();
                $this->transactionService->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::SENT));
                $this->accountService->addAmountAndSave($event->account, $transaction->getAmount());
            } catch (\TypeError $typeError) {
                DB::rollBack();
                logger($typeError->getMessage());
            }
        });
    }
}
