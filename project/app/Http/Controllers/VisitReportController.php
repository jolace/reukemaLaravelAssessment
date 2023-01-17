<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VisitReportService;
use App\Services\VisitReportDatatable;
use App\Models\VisitReports;

class VisitReportController extends Controller
{
    public function __construct(VisitReportService $vistReportService, VisitReportDatatable $vistReportDatatableService)
    {
        $this->vistReportService = $vistReportService;
        $this->vistReportDatatableService = $vistReportDatatableService;
    }

    public function show($id)
    {
        $vr = VisitReports::where('id',$id)->count();
        if($vr)
        {
            $vr = $this->vistReportService->get($id);
            return response(['data'=>$vr]);
        }else {
            return response(['data'=>'Visit report not found'],404);
        }
    }

    public function update(Request $req,$id)
    {
        $validator_rules = [
            'appointment_date' => 'required'
        ];
        $validator_messages = [];

        if(\Auth::user()->hasRole('manager'))
        {
            $validator_rules['user_id'] = 'required';
            $validator_messages['user_id.required'] = 'You have to choose the Assignment';
        }

        $validator = \Validator::make($req->all(),$validator_rules,$validator_messages);
 
        if ($validator->fails()) {
            return response(['data' => $validator->getMessageBag()->toArray()],403);
        }

        $vr = VisitReports::where('id',$id)->count();
        if($vr)
        {
            $flag = $this->vistReportService->update($id,$req->all());
            return response(['data'=>$flag]);
        } else {
            return response(['data'=>'Visit report not found'],404);
        }
    }

    public function finalise(Request $req,$id)
    {
        $vr = VisitReports::where('id',$id)->first();
        if(!empty($vr) && !empty($vr->report_text))
        {
            $flag = $this->vistReportService->finalise($id);
            return response(['data'=>1]);
        } else {
            return response(['data'=>'Visit report not found'],404);
        }
    }

    public function datatable(Request $req)
    {
        $request = $req->all();
        if(\Auth::user()->hasRole('manager')){
            $request['userRole'] = 'manager';
        } else {
            $request['userRole'] = 'representative';
        }
        
        $response =  $this->vistReportDatatableService->prepareOutput($request);

        return $response;
    }
}
