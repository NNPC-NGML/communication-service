<?php

namespace Tests\Unit;

use App\Jobs\NotificationTask\NotificationTaskDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Skillz\Nnpcreusable\Service\NotificationTaskService;
use App\Services\EmailService;
use Tests\TestCase;

class NotificationTaskDeletedTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test the handle method of the NotificationTaskDeleted job.
     */
    public function testNotificationTaskDeletedJob(): void
    {
        // Sample ID
        $id = 1;

        // Mock the NotificationTaskService
        $mockNotificationTaskService = Mockery::mock(NotificationTaskService::class);
        $mockNotificationTaskService->shouldReceive('destroy')
            ->once()
            ->with($id);

        // Mock the EmailService
        $mockEmailService = Mockery::mock(EmailService::class);
        $mockEmailService->shouldReceive('destroy')
            ->once()
            ->with($id);

        $this->app->instance(NotificationTaskService::class, $mockNotificationTaskService);
        $this->app->instance(EmailService::class, $mockEmailService);

        // Create an instance of the job with the sample ID
        $job = new NotificationTaskDeleted($id);

        // Execute the handle method directly with the mocks
        $job->handle($mockNotificationTaskService, $mockEmailService);

        // Verify that the NotificationTaskService's destroy method was called with the expected ID
        $mockNotificationTaskService->shouldHaveReceived('destroy')
            ->once()
            ->with($id);

        // Verify that the EmailService's destroy method was called with the expected ID
        $mockEmailService->shouldHaveReceived('destroy')
            ->once()
            ->with($id);

        // Explicit assertion to count as an assertion in PHPUnit
        $this->assertTrue(true);
    }
}
