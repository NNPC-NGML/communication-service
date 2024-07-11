<?php

namespace Tests\Unit;

use App\Jobs\NotificationTask\NotificationTaskCreated;
use App\Services\EmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Skillz\Nnpcreusable\Service\NotificationTaskService;
use Tests\TestCase;

class NotificationTaskCreatedTest extends TestCase
{
    /**
     * Test the handle method of the NotificationTaskCreated job.
     */
    public function testNotificationTaskCreatedJob(): void
    {
        // Sample data
        $data = [
            'id' => 1,
            'processflow_history_id' => 2,
            'formbuilder_data_id' => 3,
            'entity_id' => 4,
            'entity_type' => "customer", //supplier
            'user_id' => 5,
            'processflow_id' => 6,
            'processflow_step_id' => 7,
            'title' => "create task",
            'route' => null,
            'start_time' => '1980-01-01',
            'end_time' => '1980-01-01',
            'task_status' => 1,
        ];

        // Mock the NotificationTaskService
        $mockNotificationTaskService = Mockery::mock(NotificationTaskService::class);
        $mockNotificationTaskService->shouldReceive('create')
            ->once()
            ->with($data);

        // Mock the EmailService
        $mockEmailService = Mockery::mock(EmailService::class);
        $mockEmailService->shouldReceive('create')
            ->once()
            ->with($data);

        $this->app->instance(NotificationTaskService::class, $mockNotificationTaskService);
        $this->app->instance(EmailService::class, $mockEmailService);

        // Create an instance of the job with the sample data
        $job = new NotificationTaskCreated($data);

        // Execute the handle method directly with the mocks
        $job->handle($mockNotificationTaskService, $mockEmailService);

        // Verify that the NotificationTaskService's create method was called with the expected data
        $mockNotificationTaskService->shouldHaveReceived('create')
            ->once()
            ->with($data);

        // Verify that the EmailService's create method was called with the expected data
        $mockEmailService->shouldHaveReceived('create')
            ->once()
            ->with($data);

        // Explicit assertions to count as assertions in PHPUnit
        $this->assertTrue(true);  // This is just to satisfy PHPUnit
    }
}
