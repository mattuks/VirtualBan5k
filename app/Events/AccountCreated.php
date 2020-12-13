<?php

namespace App\Events;

use App\Account;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class AccountCreated
 * @package App\Events
 */
class AccountCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * AccountCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
