<?php

namespace App\Listeners;

use App\Factories\AccountFactory;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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

        AccountFactory::create([
            'user_id' => $user->getId(),
            'name' => 'EUR Account',
            'currency' => 'EUR',
        ])->save();
    }
}
