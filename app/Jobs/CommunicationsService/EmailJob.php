<?php

namespace App\Jobs\CommunicationsService;

use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $emailService = new EmailService();
        $emailData = $emailService->initialize($this->data);
        $emailService->sendNotificationEmail($emailData);
    }
}
