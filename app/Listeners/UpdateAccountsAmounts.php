<?php

namespace App\Listeners;

use App\Account;
use App\Enums\TransactionDirectionType;
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
    public function handle($event)
    {
            $this->accountService->subtractFromAmount(Account::where('uuid', $event->operation->getSenderUUID())->first(), $event->operation->getAmount());
            $this->accountService->addAmountAndConvert(Account::where('uuid', $event->operation->getReceiverUUID())->first(), $event->operation->getAmount());
    }
}
