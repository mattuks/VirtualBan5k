<?php

namespace App\Jobs;

use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Factories\OperationFactory;
use App\Notifications\OperationCreatedNotification;
use App\Operation;
use App\Services\OperationService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Cknow\Money\Money;
use Money\Currency;

class CreateOperations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Operation
     */
    private $operation;
    /**
     * @var
     */
    private $user;


    /**
     * CreateOperations constructor.
     * @param $operation
     * @param $user
     */
    public function __construct($operation, $user)
    {
        $this->operation = $operation;
        $this->user = $user;
    }

    /**
     *
     */
    public function handle()
    {
        $operation = new Operation();
        $operation->setSenderUUID($this->operation['sender_uuid']);
        $operation->setReceiverUUID($this->operation['receiver_uuid']);
        $operation->setAmount(new Money($this->operation['amount']*100, new Currency($this->operation['currency'])));
        $operation->setCurrency(new Currency($this->operation['currency']));
        $operation->setStatus(new OperationStatus(OperationStatus::PENDING));
        $operation->save();

        $this->user->notify(new OperationCreatedNotification($operation));
        event(new OperationCreated($operation));
    }
}
