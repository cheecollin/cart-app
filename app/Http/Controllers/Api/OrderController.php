<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\JobAd;
use App\Models\JobAdsDiscountSettings;
use App\Models\Order;
use App\Models\OrderLine;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/order/calculate",
     *     description="calculate the total price for the job ads",
     *     operationId="calculateTotalPrice",
     *     tags={"order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 schema="order",
     *                 type="object",
     *                 @OA\Property(
     *                     property="customer_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="job_ads",
     *                     type="array",
     *                     @OA\Items(
     *                         ref="#/components/schemas/job_ads_order"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="price summary",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 schema="price_summary",
     *                 type="object",
     *                 @OA\Property(
     *                     property="customer_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="job_ads",
     *                     type="array",
     *                     @OA\Items(
     *                         ref="#/components/schemas/order_line"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="total_price",
     *                     type="number",
     *                     format="currency"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, ref="#/components/responses/400")
     * )
     */
    public function calculateTotalPrice(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $job_ads = $request->input('job_ads');
        
        if (is_null($customer_id) || is_null($job_ads)) {
            return response(['code' => 400, 'message' => 'Bad Request'], 400);
        }
        
        $pricing_summary = [
            'customer_id' => $customer_id,
            'job_ads' => [],
            'total_price' => 0
        ];
        
        foreach ($job_ads as $job_ad) {
            if (!isset($job_ad['job_ad_id']) || !isset($job_ad['quantity'])) {
                return response(['code' => 400, 'message' => 'Bad Request'], 400);
            }
            // Get job ads pricing
            $job_ad_data = JobAd::find($job_ad['job_ad_id']);
            
            // Get job ads discount settings for the customer
            $discount_settings = JobAdsDiscountSettings::where([
                'customer_id' => $customer_id,
                'job_ad_id' => $job_ad['job_ad_id']
            ])
            ->latest()
            ->first();
            
            $quantity = $job_ad['quantity'];
            $job_ad_price = $job_ad_data->price;

            if (!is_null($discount_settings)) {
                // process discount logic
                $discounted_price = $discount_settings->discounted_price;
                $discount_condition = $discount_settings->discount_value;
                
                switch ($discount_settings->discount_id) {
                    case 1:
                        $price = (
                            floor($quantity / $discount_condition) * $discounted_price
                        ) +
                        (
                            ($quantity % $discount_condition) * $job_ad_price
                        );

                        break;
                    case 2:
                        $price = $quantity * $discounted_price;
                        break;
                    case 3:
                        if ($quantity >= $discount_condition) {
                            $price = $quantity * $discounted_price;
                        } else {
                            $price = $quantity * $job_ad_price;
                        }
                        break;
                }
                
                $discount = ($quantity * $job_ad_price) - $price;
            } else {
                $price = $quantity * $job_ad_price;
                $discount = 0;
            }
            
            $pricing_summary['job_ads'][] = array_merge($job_ad, [
                'price' => $price,
                'discount' => $discount
            ]);
            
            $pricing_summary['total_price'] += $price;
        }
        
        $pricing_summary['total_price'] = round($pricing_summary['total_price'], 2);
        
        return $pricing_summary;
    }
    
    /**
     * @OA\Post(
     *     path="/orders/",
     *     description="create order",
     *     operationId="createOrder",
     *     tags={"order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 schema="order",
     *                 type="object",
     *                 @OA\Property(
     *                     property="customer_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="job_ads",
     *                     type="array",
     *                     @OA\Items(
     *                         ref="#/components/schemas/job_ads_order"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="order_created"
     *     ),
     *     @OA\Response(response=400, ref="#/components/responses/400")
     * )
     */
    public function createOrder(Request $request)
    {
        $price_summary = $this->calculateTotalPrice($request);
        
        if ($price_summary instanceof Response && $price_summary->status() == 400) {
            return $price_summary;
        }
        
        // Create order
        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->save();
        
        $order_lines = [];
        
        foreach ($price_summary['job_ads'] as $job_ad) {
            $order_lines[] = array_merge($job_ad, ['order_id' => $order->id]);
        }
        
        // Create order lines
        OrderLine::insert($order_lines);
        
        return response('', 201);
    }
}
