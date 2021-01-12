<?php declare(strict_types=1);

namespace App\Listeners;

use App\Enums\OperationStatus;
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
     * @return void
     */
    public function handle(AccountCreated $event): void
    {

            try {
                DB::transaction(function () use ($event) {
                    $event->account->save();
                $operation = $this->operationService->createAndSave([
                    'sender_uuid' => 'admin',
                    'receiver_uuid' => $event->account->getUUID(),
                    'amount' => new Money(100000, $event->account->getCurrency()),
                    'status' => new OperationStatus(OperationStatus::PENDING),
                    'currency' => $event->account->getCurrency(),
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

                $this->transactionService->changeStatusAndSave($transaction, new TransactionStatus(TransactionStatus::RECEIVED));

                $this->accountService->addAmountAndSave($event->account, $transaction->getAmount());

                messageUser('bonus', 'We added a bonus of 1000EUR for joining us!');
                });
            } catch (\TypeError $typeError) {
                DB::rollBack();
                logger($typeError->getMessage());
            }
    }
}
