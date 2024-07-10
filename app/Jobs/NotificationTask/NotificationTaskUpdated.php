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
     * Create a new job instance.
     */
    private $data;
    private int $id;
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->id = $data["id"];
    }

    /**
     * Execute the job.
     * @param NotificationTaskService $notificationTaskService
     * @param EmailService $emailService
     * @return void
     */
    public function handle(NotificationTaskService $notificationTaskService, EmailService $emailService): void
    {
        $data = $this->data;
        $notificationTaskService->update($data, $this->id);
        $emailService->update($data);
    }
}
