<?php

namespace Tests\Feature;

use App\Jobs\NotificationTask\NotificationTaskCreated;
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
    public function test_handle(): void
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
        $mockService = Mockery::mock(NotificationTaskService::class);
        $mockService->shouldReceive('create')
            ->once()
            ->with($data);

        $this->app->instance(NotificationTaskService::class, $mockService);

        // Create an instance of the job with the sample data
        $job = new NotificationTaskCreated($data);

        // Dispatch the job
        Queue::fake();
        dispatch($job);

        // Execute the handle method
        $job->handle();

        // Verify that the NotificationTaskService's create method was called with the expected data
        $mockService->shouldHaveReceived('create')
            ->once()
            ->with($data);

        // Clean up the mock
        Mockery::close();
    }
}
