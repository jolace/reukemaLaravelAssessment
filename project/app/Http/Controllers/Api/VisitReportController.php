<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VisitReportService;

/**
 * @OA\Info(title="Reukema API", version="0.1")
 */
class VisitReportController extends Controller
{
    //
    public function __construct(VisitReportService $vistReportService)
    {
        $this->vistReportService = $vistReportService;
    }
    /**
     * @OA\Get(
     *      path="/api/visitreport",
     *      operationId="getVisitReportList",
     *      summary="Get list of visit reports with data for assigned user and customer",
     *      description="Returns list of visit reports",
     *      tags={"Visitreport"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Return list with visit reports with data for assigned user and customer",
     *          @OA\JsonContent(     *            
     *              @OA\Property(property="data",type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="appointment_date", type="datetime"),
     *                  @OA\Property(property="report_text", type="string", example="Big report text"),
     *                  @OA\Property(property="user_id", type="integer",example="7"),
     *                  @OA\Property(property="customer_id", type="integer",example="12"),
     *                  @OA\Property(property="assigned_employee", type="object",
     *                          @OA\Property(property="id", type="integer", example="7"),
     *                          @OA\Property(property="name", type="string", example="Jim"),
     *                          @OA\Property(property="email", type="email", example="Jim@reukema.com")
     *                  ),
     *                  @OA\Property(property="customer", type="object",
     *                          @OA\Property(property="id", type="integer", example="12"),
     *                          @OA\Property(property="name", type="string", example="My company"),
     *                          @OA\Property(property="email", type="string", example="company@mycompany.com"),
     *                          @OA\Property(property="address", type="string", example="3053 Jenkins Court Suite"),
     *                          @OA\Property(property="phone", type="string", example="559-404-4038")
     *                  ),
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(@OA\Property(property="error", type="string", example="Wrong api key"))
     *      ),
     *     )
     */
    public function index()
    {
        $reports = $this->vistReportService->getAll();
        return ['data' => $reports->toArray()];
    }
    
}
