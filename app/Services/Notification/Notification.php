<?php

namespace App\Services\Notification;

use App\Jobs\SendNotificationJob;
use App\Services\Notification\Repositories\NotificationRepository;

/**
 * @method sendEmail(App\Models\User $user, Illuminate\Mail\Mailable $mailable)
 * @method sendTelegram(App\Models\User $user, String $text)
 */

class Notification
{
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    public function __call($name, $arguments):void
    {
        $type = substr($name,4);

        $notification = $this->notificationRepository->create([
            'type' => $type,
            'data' => json_encode($arguments),
            'status' => 'pending'
        ]);

        SendNotificationJob::dispatch($notification->id,$type,$arguments);
    }

}
