<?php

namespace App\Services;
use App\Models\Customer;
use App\Models\VisitReports;
use Database\Factories\VisitReportsFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Jobs\CreateReportRows;

class VisitReportService implements VisitReportInterface
{
	public function __construct()
	{

	}
	/*
		Count Customers that have not report on Visit report table
	*/
	public function countCustomersWithOutReport()
	{
		return Customer::has('VisitReports','<',1)->count();
	}
	/*
		Count Customers that have report on Visit report table but it is expired. 
		Ignore Customers that already have created report with NULL value for appoitment date 
	*/
	public function countCustomersWithExpiredReport()
	{
		$date = $this->calculateDateInterval();
		$notFilledCustomerIds = Customer::whereHas('VisitReports',function (Builder $query) use ($date) {
			$query->whereNull('appointment_date');
		})
		->get()
		->pluck('id');

		$customer_count = Customer::whereHas('VisitReports',function (Builder $query) use ($date) {
			$query->where('appointment_date','<',$date);
		})->whereNotIn('id',$notFilledCustomerIds)->count();

		return $customer_count;
	}
	/*
		Create new report for customers for the first time
	*/
	public function addReportsForNewCustomers()
	{

        $count = $this->countCustomersWithOutReport();
		$iterations = $this->calculateQueryIteration($count);
		$offset = 0;
		$limit = env('COMMAND_QUERY_LIMIIT');
		
        for($i = 0; $i < $iterations; $i++)
        {
			$customer_ids = $this->getCustomerIdsWithOutReport($offset,$limit);
			$this->createReportsForCustomerIds($customer_ids);
			$offset = $offset + $limit;
        }
	}
	/*
		Create new report for customers with expired reports. 
		Ignore Customers that already have created report with NULL value for appoitment date 
	*/
	public function addReportsForExpiredInterval()
	{
		
		$count = $this->countCustomersWithExpiredReport();
		$iterations = $this->calculateQueryIteration($count);
		$offset = 0;
		$limit = env('COMMAND_QUERY_LIMIIT');

        for($i = 0; $i < $iterations; $i++)
        {
			$customer_ids = $this->getCustomerIdsWithExpiredReport($offset,$limit);
			$this->createReportsForCustomerIds($customer_ids);
			$offset = $offset + $limit;
        }

	}
	/*
		Get customers ids for customer with expired reports. 
		Ignore Customers that already have created report with NULL value for appoitment date 
	*/
	public function getCustomerIdsWithExpiredReport($offset = 0,$limit)
	{
		
		$date = $this->calculateDateInterval();

		$notFilledCustomerIds = Customer::whereHas('VisitReports',function (Builder $query) use ($date) {
			$query->whereNull('appointment_date');
		})
		->get()
		->pluck('id');

		$customer_ids = Customer::whereHas('VisitReports',function (Builder $query) use ($date) {
			$query->where(function($q) use ($date){
				$q->where('appointment_date','<',$date);
			});
		
		})->whereNotIn('id',$notFilledCustomerIds)
			->offset($offset)
			->limit($limit)
			->get()
			->pluck('id');
		
		return $customer_ids;
	}
	/*
		Get customers ids for customer with no reports in table. 
	*/
	public function getCustomerIdsWithOutReport($offset = 0,$limit)
	{
		$customer_ids = Customer::has('VisitReports','<',1)->offset($offset)->limit($limit)->get()->pluck('id');
		return $customer_ids;
	}
	/*
		Create new rows in reports table for customers ids array. 
	*/
	private function createReportsForCustomerIds($customer_ids)
	{
		CreateReportRows::dispatch($customer_ids);
	}
	/*
		Calculate Date interval. 
		We need to insert new row in visit report table for Customers that have report older than this interval 
	*/
	private function calculateDateInterval()
	{
		$intervalInMonths = env('MONTH_INTERVAL');
		$date = new \DateTime("-$intervalInMonths months");
		$date = $date->format('Y-m-d');
		return $date;
	}
	/*
		Calculate Query iteration. 
		To prevent big load in memorry - for our report calculation we get/insert chunk of data   
	*/
	private function calculateQueryIteration($count)
	{
		$limit = env('COMMAND_QUERY_LIMIIT');
        $iterations =  $count / $limit;
		$iterations = ceil($iterations);
		return (int) $iterations;
	}
}