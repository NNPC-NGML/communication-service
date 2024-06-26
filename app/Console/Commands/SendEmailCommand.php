<?php

namespace App\Console\Commands;

use App\Services\EmailService;
use Illuminate\Console\Command;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $emailService = new EmailService();
        $emailData = $emailService->initialize([
            "receiver" => "Dangote Cement",
            'message_body' => "Your application has been approved and is awaiting pending confirmation, please kindly exercise some patience while your requests are been addressed properly. Thank you!",
            "subject" => "Test Subject",
            "email" => "mederel156@cutxsew.com",
            "link" => "http://example.com"
        ]);
        $emailService->sendNotificationEmail($emailData);
    }
}
