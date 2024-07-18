<?php

namespace App\Jobs\Customer;

use Illuminate\Bus\Queueable;
use Skillz\Nnpcreusable\Service\CustomerService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerDeleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The ID of the customer to be deleted.
     *
     * @var int
     */
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param int $id The ID of the customer to be deleted.
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job to handle deletion of customer.
     *
     * @return void
     */
    public function handle(): void
    {
        $service = new CustomerService();
        $service->destroyCustomer($this->id);
    }
}
