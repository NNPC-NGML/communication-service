<?php

namespace Tests\Unit;

use App\Jobs\User\UserUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Mockery;
use Skillz\Nnpcreusable\Service\UserService;
use Tests\TestCase;

class UserUpdatedTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function testUserUpdatedJob(): void
    {
        // Sample data
        $data = [
            'id' => 1,
            'name' => 'Updated User',
            'email' => 'updateduser@example.com'
        ];

        // Mock the UserService
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('updateUser')
            ->once()
            ->with($data['id'], Mockery::on(function ($arg) use ($data) {
                return $arg instanceof Request && $arg->all() == $data;
            }));

        $this->app->instance(UserService::class, $mockUserService);

        // Create an instance of the job with the sample data
        $job = new UserUpdated($data);

        // Execute the handle method directly with the mock
        $job->handle($mockUserService);

        // Verify that the UserService's updateUser method was called with the expected data
        $mockUserService->shouldHaveReceived('updateUser')
            ->once()
            ->with($data['id'], Mockery::on(function ($arg) use ($data) {
                return $arg instanceof Request && $arg->all() == $data;
            }));

        // Explicit assertion to count as an assertion in PHPUnit
        $this->assertTrue(true);
    }
}
