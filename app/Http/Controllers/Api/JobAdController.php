<?php
namespace App\Http\Controllers\Api;

class JobAdController extends Controller
{
    /**
     * @OA\Get(
     *     path="/job-ads",
     *     description="get all job ads",
     *     operationId="getJobAds",
     *     tags={"job-ads"},
     *     @OA\Response(
     *         response=200,
     *         description="job_ads"
     *     ),
     *     @OA\Response(response=404, ref="#/components/responses/404")
     * )
     */
    public function GetJobAds()
    {
        
    }
}
