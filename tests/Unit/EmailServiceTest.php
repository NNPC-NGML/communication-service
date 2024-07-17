<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\EmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;

class EmailServiceTest extends TestCase
{
    protected $emailService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->emailService = new EmailService();
    }

    public function testValidateEmailDataSuccess()
    {
        $data = [
            "notification_task_id" => 10,
            "receiver" => "Dangoto Industry",
            "message_body" => "This is a test message.",
            "subject" => "Test Subject",
            "email" => "test@example.com",
        ];

        $result = $this->emailService->validateEmailData($data);
        $this->assertIsObject($result);
        $this->assertEquals($data['notification_task_id'], $result->notification_task_id);
        $this->assertEquals($data['receiver'], $result->receiver);
        $this->assertEquals($data['message_body'], $result->message_body);
        $this->assertEquals($data['subject'], $result->subject);
        $this->assertEquals($data['email'], $result->email);
    }

    public function testValidateEmailDataValidationError()
    {
        $data = [
            "notification_task_id" => 10,
            "receiver" => "",
            "message_body" => "This is a test message.",
            "subject" => "Test Subject",
            "email" => "test@example.com",
        ];

        try {
            $result = $this->emailService->validateEmailData($data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertTrue($e->validator->errors()->has('receiver'));
            return;
        }

        $this->fail('Expected ValidationException was not thrown.');
    }

    public function testSendNotificationEmail()
    {
        $notification = [
            "notification_task_id" => 10,
            "receiver" => "Dangote Cement",
            'message_body' => "Your application has been approved and is awaiting pending confirmation, please kindly exercise some patience while your requests are been addressed properly. Thank you!",
            "subject" => "Test Subject",
            "email" => "akubueaugustutuskc@gmail.com",
        ];

        Mail::fake();

        $this->emailService->sendNotificationEmail($notification);

        Mail::assertSent(NotificationEmail::class, function ($mail) use ($notification) {
            return $mail->hasTo($notification["email"]);
        });
    }
}
