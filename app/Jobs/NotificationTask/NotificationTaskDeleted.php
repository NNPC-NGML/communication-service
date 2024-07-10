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
     * Create a new job instance.
     */

    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @param NotificationTaskService $notificationTaskService
     * @param EmailService $emailService
     * @return void
     */
    public function handle(NotificationTaskService $notificationTaskService, EmailService $emailService): void
    {
        $id = $this->id;
        $notificationTaskService->destroy($id);
        $emailService->destroy($id);
    }
}
