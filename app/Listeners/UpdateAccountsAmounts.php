<?php

namespace App\Listeners;

use App\Account;
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
        $accounts = [
            'sender' => Account::where('uuid', $event->operation->getSenderUUID())->first(),
            'receiver' => Account::where('uuid', $event->operation->getReceiverUUID())->first(),
        ];

        foreach ($accounts as $accountType => $account){
            if ($accountType == 'sender'){
                $this->accountService->addAmountAndSave($account, $account->getAmount()->subtract($event->operation->getAmount()));
            }elseif ($accountType == 'receiver'){
                if ($account->getAmount()->isSameCurrency($event->operation->getAmount())){
                    $this->accountService->addAmountAndSave($account,$account->getAmount()->add($event->operation->getAmount()));
                }else{
                   $converted = $this->conversationService->convert($event->operation->getAmount(), $account->getAmount());
                    $this->accountService->addAmountAndSave($account,$account->getAmount()->add($converted));
                }

            }
        }
    }
}
