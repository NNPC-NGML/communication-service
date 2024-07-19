<?php

namespace App\Jobs\User;

use Skillz\Nnpcreusable\Service\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;

class UserUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for updating the user.
     *
     * @var array
     */
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for updating the user.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job to handle user update.
     *
     * @param UserService $service The user service instance.
     * @return void
     */
    public function handle(UserService $service): void
    {
        $request = new Request($this->data);
        $service->updateUser($this->data["id"], $request);
    }

    /**
     * Get the data for updating the user.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
