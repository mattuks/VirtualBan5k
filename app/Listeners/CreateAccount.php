<?php

namespace App\Listeners;

use App\Account;
use App\Events\AccountEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class CreateAccount
 * @package App\Listeners
 */
class CreateAccount
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(AccountEvent $event)
    {
        //Create account
        $account = new Account();
        $account->user_id = $event->user->id;
        $account->name =  'EUR Account';
        $account->currency = 'EUR';
        $account->amount = 0;
        $account->save();
    }
}
