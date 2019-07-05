<?php
namespace App\Http\Controllers\Api;

use App\Models\Customer;

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
     *         description="array of customer",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/customer"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getCustomers()
    {
        return Customer::all();
    }
}
