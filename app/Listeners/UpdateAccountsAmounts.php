<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
use App\Events\OperationCreated;
use App\Services\AccountService;
use App\Services\ConversationService;

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
        $this->accountService->addAmountAndConvert(Account::where('uuid', $event->operation->getReceiverUUID())->first(), $event->operation->getAmount());
    }
}
