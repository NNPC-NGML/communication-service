<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class EmailService
{
    public function initialize(array $data): object
    {
        $validator = Validator::make($data, [
            "receiver" => "required|string|max:255",    // company eg Dangoto Industry
            "message" => "required|string",             // message details
            "subject" => "required|string|max:255",     // email subject
            "email" => "required|string|max:255",       // email address
            "link" => "nullable|string",                // link for clicks
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return (object) $data;
    }

    public function sendNotificationEmail(object $notification)
    {
        try {
            // $this->initialize((array) $notification);    // reconfirm validation
            Mail::to($notification->email)->send(new NotificationEmail($notification));

            // TODO (Save record of sent mail to database)

        } catch (\Throwable $th) {
            // TODO failed mail, save record and track record, probably retry sending after a while...

        }
    }

    // Add other email types as needed
}
