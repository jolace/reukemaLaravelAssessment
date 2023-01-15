<?php

namespace App\Services;

interface VisitReportInterface
{
    public function countCustomersWithOutReport();
	public function countCustomersWithExpiredReport();
    public function addReportsForExpiredInterval();
    public function addReportsForNewCustomers();
    public function getCustomerIdsWithExpiredReport($offset,$limit);
    public function getCustomerIdsWithOutReport($offset,$limit);
}