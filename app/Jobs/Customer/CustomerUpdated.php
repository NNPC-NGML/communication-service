<?php

namespace App\Jobs\Customer;

use Illuminate\Bus\Queueable;
use Skillz\Nnpcreusable\Service\CustomerService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for updating the customer.
     *
     * @var array
     */
    private array $data;

    /**
     * The ID of the customer to be updated.
     *
     * @var int
     */
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for updating the customer.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->id = $data['id']; // Assuming 'id' is a key in the data array
    }

    /**
     * Execute the job to handle update of customer.
     *
     * @return void
     */
    public function handle(): void
    {
        $service = new CustomerService();
        $service->updateCustomer($this->data, $this->id);
    }
}
