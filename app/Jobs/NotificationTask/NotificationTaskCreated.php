<?php

namespace App\Jobs\NotificationTask;

// use App\Models\Designation;

use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Skillz\Nnpcreusable\Service\NotificationTaskService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotificationTaskCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the designation.
     *
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for creating the designation
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $service = new NotificationTaskService();
        $data = $this->data;
        $service->create($data);
        //
        $emailService = new EmailService();
        $emailService->create($data);
    }
}
