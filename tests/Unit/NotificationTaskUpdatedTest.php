<?php
namespace Tests\Unit;

use App\Jobs\NotificationTask\NotificationTaskUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Skillz\Nnpcreusable\Service\NotificationTaskService;
use App\Services\EmailService;
use Tests\TestCase;

class NotificationTaskUpdatedTest extends TestCase
{
    /**
     * Test the handle method of the NotificationTaskUpdated job.
     */
    public function testNotificationTaskUpdatedJob(): void
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
            'title' => "update task",
            'route' => null,
            'start_time' => '1980-01-01',
            'end_time' => '1980-01-01',
            'task_status' => 1,
        ];

        // Mock the NotificationTaskService
        $mockNotificationTaskService = Mockery::mock(NotificationTaskService::class);
        $mockNotificationTaskService->shouldReceive('update')
            ->once()
            ->with($data, $data['id']);

        // Mock the EmailService
        $mockEmailService = Mockery::mock(EmailService::class);
        $mockEmailService->shouldReceive('update')
            ->once()
            ->with($data);

        $this->app->instance(NotificationTaskService::class, $mockNotificationTaskService);
        $this->app->instance(EmailService::class, $mockEmailService);

        // Create an instance of the job with the sample data
        $job = new NotificationTaskUpdated($data);

        // Execute the handle method directly with the mocks
        $job->handle($mockNotificationTaskService, $mockEmailService);

        // Verify that the NotificationTaskService's update method was called with the expected data
        $mockNotificationTaskService->shouldHaveReceived('update')
            ->once()
            ->with($data, $data['id']);

        // Verify that the EmailService's update method was called with the expected data
        $mockEmailService->shouldHaveReceived('update')
            ->once()
            ->with($data);

        // Explicit assertion to count as an assertion in PHPUnit
        $this->assertTrue(true);
    }
}
