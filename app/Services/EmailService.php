<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use App\Mail\NotificationEmail;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EmailService
{

    /**
     * Create a communication event sent from notification.
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        //TODO transform to email data [receiver, message_body, subject, email, link]
        $emailData = [
            "notification_task_id" =>  $request['id'],
            "receiver" => "",    // company eg Dangoto Industry
            "message_body" => "",             // message_body details
            "subject" => "",     // email subject
            "email" => "",       // email address
            "link" => "",                // link for clicks
        ];
        $this->sendNotificationEmail($emailData);
    }

    /**
     * Updates a communication event sent from notification.
     *
     * @param array $request
     * @return void
     */
    public function update(array $request): void
    {
        $emailNotification = EmailNotification::where("notification_task_id", $request["id"]);
        if($emailNotification){
            // TODO UPDATE email data [receiver, message_body, subject, email, link]
            $emailData = [
                "notification_task_id" =>  $request['id'],
                "receiver" => "",    // company eg Dangoto Industry
                "message_body" => "",             // message_body details
                "subject" => "",     // email subject
                "email" => "",       // email address
                "link" => "",                // link for clicks
            ];
            $this->sendNotificationEmail($emailData);
        }
    }

    /**
     * Deletes a communication event.
     *
     * @param array $request
     * @return void
     */
    public function destroy(int $id): void
    {
        $emailNotification = EmailNotification::where("notification_task_id", $id);
        if($emailNotification){
            $emailNotification->delete();
        }
    }

    /**
     * Validate the email data.
     *
     * @param array $data
     * @return object
     * @throws ValidationException
     */
    public function validateEmailData(array $data): object
    {
        $validator = Validator::make($data, [
            "notification_task_id" => "required|integer|max:255",   // notification tasks id
            "receiver" => "required|string|max:255",    // company eg Dangoto Industry
            "message_body" => "required|string",             // message_body details
            "subject" => "required|string|max:255",     // email subject
            "email" => "required|string|max:255",       // email address
            "link" => "nullable|string",                // link for clicks
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return (object) $data;
    }


    /**
     * send an email notification
     *
     * @param array $notificationRequest
     * @return void
     */
    public function sendNotificationEmail(array $notificationRequest)
    {
        try {
            $notification = $this->validateEmailData($notificationRequest);
            Mail::to($notification->email)->send(new NotificationEmail($notification));

            // (Save record of sent mail to database)
            EmailNotification::create(array_merge((array) $notification));
        } catch (\Throwable $th) {
            // failed mail, save record and track record, probably retry sending after a while...
            EmailNotification::create(
                array_merge(
                    (array) $notification,
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
