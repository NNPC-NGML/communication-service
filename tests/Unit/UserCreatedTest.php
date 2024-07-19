<?php

namespace Tests\Unit;

use App\Jobs\User\UserCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Mockery;
use Skillz\Nnpcreusable\Service\UserService;
use Tests\TestCase;

class UserCreatedTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function testUserCreatedJob(): void
    {
        // Sample data
        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'id' => 1
        ];

        // Mock the UserService
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('createUser')
            ->once()
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg instanceof Request && $arg->all() == $data;
            }));

        $this->app->instance(UserService::class, $mockUserService);

        // Create an instance of the job with the sample data
        $job = new UserCreated($data);

        // Execute the handle method directly with the mock
        $job->handle($mockUserService);

        // Verify that the UserService's createUser method was called with the expected data
        $mockUserService->shouldHaveReceived('createUser')
            ->once()
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg instanceof Request && $arg->all() == $data;
            }));

        // Explicit assertion to count as an assertion in PHPUnit
        $this->assertTrue(true);
    }
}
