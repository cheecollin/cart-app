<?php
namespace App\Http\Controllers\Api;

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customers",
     *     description="get all customers",
     *     operationId="getCustomers",
     *     tags={"customer"},
     *     @OA\Response(
     *         response=200,
     *         description="customers"
     *     ),
     *     @OA\Response(response=404, ref="#/components/responses/404")
     * )
     */
    public function GetCustomers()
    {
        
    }
}
