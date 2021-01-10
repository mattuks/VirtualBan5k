<?php

namespace App\Providers;

use App\Events\AccountCreated;
use App\Events\OperationCreated;
use App\Events\TransactionCreated;
use App\Listeners\CreateAccount;
use App\Listeners\AddRegistrationBonus;
use App\Listeners\CreateTransactions;
use App\Listeners\MoneyTransferred;
use App\Listeners\SendTransactionSentNotification;
use App\Listeners\UpdateAccountsAmounts;
use App\Listeners\UpdateStatuses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateAccount::class,
        ],
        AccountCreated::class => [
            AddRegistrationBonus::class,

        ],
        OperationCreated::class => [
            CreateTransactions::class,
            UpdateAccountsAmounts::class,
            UpdateStatuses::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
