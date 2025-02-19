<?php

namespace App\Jobs;

use App\Services\Notification\Factories\NotificationFactory;
use App\Services\Notification\Repositories\NotificationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $id;
    protected $type;
    protected $data;
    protected $notificationRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id,String $type, array $data, NotificationRepository $notificationRepository)
    {
        $this->id = $id;
        $this->type = $type;
        $this->data = $data;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationHandler = NotificationFactory::create($this->type, $this->data);

        $notificationHandler->send();

        $this->notificationRepository->update($this->id,['status' => 'sent']);
    }
}
