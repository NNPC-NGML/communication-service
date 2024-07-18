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

class NotificationTaskDeleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The ID of the notification task to be deleted.
     *
     * @var mixed
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @param mixed $id The ID of the notification task to be deleted.
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job to handle deletion of notification task.
     *
     * @param NotificationTaskService $notificationTaskService The notification task service instance.
     * @param EmailService $emailService The email service instance.
     * @return void
     */
    public function handle(NotificationTaskService $notificationTaskService, EmailService $emailService): void
    {
        $id = $this->id;
        $notificationTaskService->destroy($id);
        $emailService->destroy($id);
    }
}
