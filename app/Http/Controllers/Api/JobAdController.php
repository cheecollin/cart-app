<?php
namespace App\Http\Controllers\Api;

use App\Models\JobAd;

class JobAdController extends Controller
{
    /**
     * @OA\Get(
     *     path="/job-ads",
     *     description="get all job ads",
     *     operationId="getJobAds",
     *     tags={"job-ad"},
     *     @OA\Response(
     *         response=200,
     *         description="array of job ad",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/job_ad"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getJobAds()
    {
        return JobAd::all();
    }
}
