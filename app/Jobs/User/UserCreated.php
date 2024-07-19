<?php

namespace App\Jobs\User;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Skillz\Nnpcreusable\Service\UserService;

class UserCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the user.
     *
     * @var array
     */
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for creating the user.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job to handle user creation.
     *
     * @param UserService $service The user service instance.
     * @return void
     */
    public function handle(UserService $service): void
    {
        Log::info('Handling UserCreated job with data: ', ['data' => $this->data]);

        $request = new Request($this->data);
        $service->createUser($request);
    }

    /**
     * Get the data for creating the user.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
