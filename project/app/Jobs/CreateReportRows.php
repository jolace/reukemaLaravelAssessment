<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\VisitReports;

class CreateReportRows implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $customer_ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer_ids)
    {
        //
        $this->customer_ids = $customer_ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach($this->customer_ids as $cid)
		{
			VisitReports::factory()->create(['customer_id'=>$cid]);
		}
    }
}
