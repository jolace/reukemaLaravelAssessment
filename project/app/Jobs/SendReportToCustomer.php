<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\VisitReports;

class SendReportToCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $report_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($visitReportId)
    {
        //
        $this->report_id = $visitReportId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $vr = VisitReports::where('id',$this->report_id)->first(); 
        \Mail::send('email.visitreport', [
            'visitReport' => $vr
        ], function($message) use ($vr){
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->subject('Visit report');
            $message->to($vr->customer->email);
        });
    }
}
