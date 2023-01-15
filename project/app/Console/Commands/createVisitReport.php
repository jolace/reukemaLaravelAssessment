<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VisitReportService;


class createVisitReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visit-report:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creates a visit report for each customer who does not already have an unscheduled appointment or does have a scheduled appointment but scheduled longer than interval.';

    public function __construct(VisitReportService $vistReportService)
    {
        parent::__construct();
        $this->vistReportService = $vistReportService;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Create visit reports for customers that has not report at all ( new customers )
        $this->vistReportService->addReportsForNewCustomers();
        // Create visit reports for clients with expired reports
        $this->vistReportService->addReportsForExpiredInterval();

        return Command::SUCCESS;
    }
}
