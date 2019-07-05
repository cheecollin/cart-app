<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="order_line",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="job_ad_id", type="integer"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="discount", type="number", format="currency"),
 *     @OA\Property(property="price", type="number", format="currency")
 * )
 */
class OrderLine extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
}
