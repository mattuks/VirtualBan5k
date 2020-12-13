<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use App\Factories\AccountFactory;
use Cknow\Money\Money;
use Money\Currency;

/**
 * Class AddRegistrationBonus
 * @package App\Listeners
 */
class AddRegistrationBonus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @param AccountCreated $event
     */
    public function handle(AccountCreated $event)
    {
        $event->account->setAmount(new Money(500, new Currency('EUR')))->save();
    }
}
