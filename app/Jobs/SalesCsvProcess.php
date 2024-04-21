<?php

namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SalesCsvProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    private $data;
    private $header;
    /**
     * Create a new job instance.
     */

    public function __construct($data, $header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Iterate through each row of the sales data and store it in the database
        foreach($this->data as $sale){
            $saleData = array_combine($this->header, $sale);
            Sale::create($saleData);
        }
    }
    public function failed(\Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
