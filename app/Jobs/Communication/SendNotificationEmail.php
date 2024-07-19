<?php

namespace App\Jobs\Communication;

use App\Mail\NotificationEmail;
use App\Models\EmailNotification;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the email notification.
     *
     * @var array
     */
    public array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for creating the email notification.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job to send the notification email.
     *
     * @param EmailService $emailService The email service instance.
     * @return void
     */
    public function handle(EmailService $emailService): void
    {
        try {
            $notification = $emailService->validateEmailData($this->data);
            Mail::to($notification->email)->send(new NotificationEmail($notification));

            // Save record of sent mail to database
            EmailNotification::create(array_merge((array) $notification));
        } catch (\Throwable $th) {
            // If mail sending fails, save record with error details for tracking and possibly retrying
            EmailNotification::create(
                array_merge(
                    $this->data,
                    [
                        "error_message" => $th->getMessage(),
                        "error_stack_trace" => $th->getTraceAsString(),
                        "status" => false,
                    ]
                )
            );
        }
    }
}
