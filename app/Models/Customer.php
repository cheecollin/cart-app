<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="customer",
 *     type="object",
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="name",type="string")
 * )
 */
class Customer extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
}
