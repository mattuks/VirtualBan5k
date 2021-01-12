<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
use App\Events\OperationCreated;
use App\Services\AccountService;
use App\Services\ConversationService;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class UpdateAccountsAmounts
{
    /**
     * @var AccountService
     */
    private $accountService;
    /**
     * @var ConversationService
     */
    private $conversationService;

    /**
     * Create the event listener.
     *
     * @param AccountService $accountService
     * @param ConversationService $conversationService
     */
    public function __construct(AccountService $accountService, ConversationService $conversationService)
    {
        $this->accountService = $accountService;
        $this->conversationService = $conversationService;
    }

    /**
     * @param $event
     */
    public function handle(OperationCreated $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $this->accountService->subtractFromAmount(Account::where('uuid',
                    $event->operation->getSenderUUID())->first(), $event->operation->getAmount());
                $this->accountService->addAmountAndConvert(Account::where('uuid',
                    $event->operation->getReceiverUUID())->first(), $event->operation->getAmount());
            });}catch (\Exception $exception){
            DB::rollBack();
            logger($exception);
        }
    }
}
