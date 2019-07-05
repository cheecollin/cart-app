<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="job_ad",
 *     type="object",
 *     @OA\Property(property="id",type="integer"),
 *     @OA\Property(property="name",type="string"),
 *     @OA\Property(property="description",type="string"),
 *     @OA\Property(property="price",type="number", format="currency")
 * )
 */
class JobAd extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
}
