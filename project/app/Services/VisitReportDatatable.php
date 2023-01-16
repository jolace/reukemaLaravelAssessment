<?php
namespace App\Services;
use App\Models\VisitReports;

class VisitReportDatatable implements DatatableInterface
{
    public function prepareOutput($data)
    {
        if($data['userRole'] == 'manager'){
            $vreports = VisitReports::with('Customer');
        } else {
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
            'data' => $this->prepareResponse($vreports)
        ];

        return $response;
    
    }

    public function prepareResponse($data)
    {
        $r = [];
        foreach($data as $d)
        {
            $r[] = [$d->customer->name,$d->appointment_date,strlen(trim($d->report_text)),$d->id];
        }
        return $r;
    }
}