<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="order",
 *     type="object",
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="customer_id",type="integer")
 * )
 */
class Order extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
}
