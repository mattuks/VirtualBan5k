<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use App\Factories\AccountFactory;
use App\User;
use Illuminate\Auth\Events\Registered;

/**
 * Class CreateAccount
 * @package App\Listeners
 */
class CreateAccount
{
    /**
     * @param Registered $event
     */
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $account = AccountFactory::create([
            'user_id' => $user->getId(),
            'name' => 'EUR Account',
            'currency' => 'EUR',
        ]);

        event(new AccountCreated($account));
    }
}
