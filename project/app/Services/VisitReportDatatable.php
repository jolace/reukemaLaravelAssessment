<?php
namespace App\Services;
use App\Models\VisitReports;

class VisitReportDatatable implements DatatableInterface
{
    /*
        Get data that we need for Datatable rows
    */
    public function prepareOutput($data)
    {
        
        if($data['userRole'] == 'manager'){
            $manager = true;
            $vreports = VisitReports::with('Customer');
        } else {
            $manager = false;
            $vreports = VisitReports::with('Customer')->where('user_id',\Auth::user()->id);
        }
            
        if(isset($data['dateInPast']) && $data['dateInPast'] == 'true')
        {
            $vreports = $vreports->where(function($query){
                $query->where('appointment_date','>',date('Y-m-d'))->orWhere('appointment_date',NULL);
            })
            ->orWhere(function($query){
                $query->where('appointment_date','<',date('Y-m-d'))->where(function($q){
                    $q->whereRaw('LENGTH(report_text) < 1')->orWhere('report_text',NULL);
                });
            }); 
        } else {
            $vreports = $vreports->where(function($query){
                $query->where('appointment_date','>',date('Y-m-d'))->orWhere('appointment_date',NULL);
            });
        }

        $vreportsCount = $vreports;
        $countVreports = $vreportsCount->count();

        $vreports = $vreports->orderBy('appointment_date')
                        ->offset($data['start'])
                        ->limit($data['length'])
                        ->get();
        
        $response = 
        [
            'recordsTotal' => $countVreports,
            'recordsFiltered' => $vreports->count(),
            'data' => $this->prepareResponse($vreports,$manager)
        ];

        return $response;
    
    }
    /*
        Prepare data how Datatable plugin expected
    */
    public function prepareResponse($data,$manager)
    {
        $r = [];
        foreach($data as $d)
        {
            $r[] = [$d->customer->name,$d->appointment_date,strlen(trim($d->report_text)),$d->id,[strlen(trim($d->report_text)),$d->closed,$d->id,$manager]];
        }
        return $r;
    }
}