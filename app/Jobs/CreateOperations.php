<?php

namespace App\Jobs;

use App\Enums\OperationStatus;
use App\Events\OperationCreated;
use App\Notifications\OperationStatusNotification;
use App\Operation;
use Cknow\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Money\Currency;

class CreateOperations
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Operation
     *
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
        try {
        $operation = new Operation();
        $operation->setUserId($this->user->getId());
        $operation->setAccountId($this->operation['account_id']);
        $operation->setSenderUUID($this->operation['sender_uuid']);
        $operation->setReceiverUUID($this->operation['receiver_uuid']);
        $operation->setAmount(new Money($this->operation['amount']*100, new Currency($this->operation['currency'])));
        $operation->setCurrency(new Currency($this->operation['currency']));
        $operation->setStatus(new OperationStatus(OperationStatus::PENDING));
        $operation->save();

        $this->user->notify(new OperationStatusNotification($operation));
        event(new OperationCreated($operation));

        }catch (\Exception $exception){
            logger($exception);
        }
    }
}
