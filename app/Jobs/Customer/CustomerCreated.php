<?php

namespace App\Jobs\Customer;

use Skillz\Nnpcreusable\Models\Customer;
use Illuminate\Bus\Queueable;
use Skillz\Nnpcreusable\Service\CustomerService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the customer.
     *
     * @var array
     */
    public array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for creating the customer.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job to handle creation of customer.
     *
     * @return void
     */
    public function handle(): void
    {
        $service = new CustomerService();
        $service->createCustomer($this->data);
    }
}
