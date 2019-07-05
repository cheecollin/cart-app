<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

/**
 *
 * @OA\OpenApi(
 *     openapi="3.0.0",
 *     @OA\Server(
 *         url=API_URL,
 *         description="API server",
 *     ),
 *     @OA\Info(
 *         version="1.0",
 *         title="Job Ads Checkout API",
 *         @OA\Contact(name="Chee Collin", email="chee_collin88@yahoo.com"),
 *     ),
 *     @OA\Components(
 *         @OA\Response(
 *             response=404,
 *             description="Not Found",
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                     schema="404_error",
 *                     @OA\Property(
 *                             property="code",
 *                             type="integer",
 *                             format="int32"
 *                     ),
 *                     @OA\Property(
 *                         property="message",
 *                         type="string"
 *                     )
 *                 )
 *             )
 *         ),
 *         @OA\Response(
 *             response=400,
 *             description="Bad Request",
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                     schema="400_error",
 *                     @OA\Property(
 *                             property="code",
 *                             type="integer",
 *                             format="int32"
 *                     ),
 *                     @OA\Property(
 *                         property="message",
 *                         type="string"
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class Controller extends BaseController
{
    
}
