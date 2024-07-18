<?php

namespace App\Jobs\NotificationTask;

use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Skillz\Nnpcreusable\Service\NotificationTaskService;

class NotificationTaskUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for updating the notification task.
     *
     * @var array
     */
    private array $data;

    /**
     * The ID of the notification task to be updated.
     *
     * @var int
     */
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for updating the notification task.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->id = $data["id"]; // Assuming 'id' is a key in the data array
    }

    /**
     * Execute the job to handle update of notification task.
     *
     * @param NotificationTaskService $notificationTaskService The notification task service instance.
     * @param EmailService $emailService The email service instance.
     * @return void
     */
    public function handle(NotificationTaskService $notificationTaskService, EmailService $emailService): void
    {
        $data = $this->data;
        $notificationTaskService->update($data, $this->id);
        $emailService->update($data);
    }
}
