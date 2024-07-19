<?php

namespace Tests\Unit;

use App\Jobs\User\UserDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Skillz\Nnpcreusable\Service\UserService;
use Tests\TestCase;

class UserDeletedTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function testUserDeletedJob(): void
    {
        // Sample ID
        $id = 1;

        // Mock the UserService
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('deleteUser')
            ->once()
            ->with($id);

        $this->app->instance(UserService::class, $mockUserService);

        // Create an instance of the job with the sample ID
        $job = new UserDeleted($id);

        // Execute the handle method directly with the mock
        $job->handle($mockUserService);

        // Verify that the UserService's deleteUser method was called with the expected ID
        $mockUserService->shouldHaveReceived('deleteUser')
            ->once()
            ->with($id);

        // Explicit assertion to count as an assertion in PHPUnit
        $this->assertTrue(true);
    }
}
