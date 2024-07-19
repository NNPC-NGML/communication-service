<?php

namespace App\Jobs\User;

use Skillz\Nnpcreusable\Service\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UserDeleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The ID of the user to be deleted.
     *
     * @var int
     */
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param int $id The ID of the user to be deleted.
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job to delete the user.
     *
     * @param UserService $service The user service instance.
     * @return void
     */
    public function handle(UserService $service): void
    {
        $service->deleteUser($this->id);
    }

    /**
     * Get the ID of the user to be deleted.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
