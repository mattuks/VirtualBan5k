<?php

namespace App\Notifications;

use App\Operation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperationCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Operation
     */
    public $operation;

    /**
     * OperationCreatedNotification constructor.
     * @param Operation $operation
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * @param User $user
     * @return array
     */
    public function toDatabase(User $user)
    {
        return $this->operation->toArray();
    }
}
