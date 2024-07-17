<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use App\Mail\NotificationEmail;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Skillz\Nnpcreusable\Service\UserService;

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
        $service = new  UserService();
        $user = $service->getUser($request['user_id']);
        $emailData = [
            "notification_task_id" =>  $request['id'],
            "receiver" => $user->name,              // company eg Dangoto Industry
            "message_body" => $request['message'],  // message_body details
            "subject" =>  $request['subject'],      // email subject
            "email" => $user->email,                // email address
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
        if ($emailNotification) {
            $service = new  UserService();
            $user = $service->getUser($request['user_id']);
            $emailData = [
                "notification_task_id" =>  $request['id'],
                "receiver" => $user->name,              // company eg Dangoto Industry
                "message_body" => $request['message'],  // message_body details
                "subject" =>  $request['subject'],      // email subject
                "email" => $user->email,                // email address
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
        if ($emailNotification) {
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
                    (array) $notificationRequest,
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
