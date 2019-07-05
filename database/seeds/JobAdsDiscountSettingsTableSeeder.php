<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JobAdsDiscountSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'customer_id' => 1,
                'job_ad_id' => 1,
                'discount_id'=> 1,
                'discount_value' => 3,
                'discounted_price' => 539.98,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'customer_id' => 2,
                'job_ad_id' => 2,
                'discount_id'=> 2,
                'discount_value' => null,
                'discounted_price' => 299.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'customer_id' => 3,
                'job_ad_id' => 3,
                'discount_id'=> 3,
                'discount_value' => 4,
                'discounted_price' => 379.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'customer_id' => 4,
                'job_ad_id' => 1,
                'discount_id'=> 1,
                'discount_value' => 5,
                'discounted_price' => 1079.96,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'customer_id' => 4,
                'job_ad_id' => 2,
                'discount_id'=> 2,
                'discount_value' => null,
                'discounted_price' => 309.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'customer_id' => 4,
                'job_ad_id' => 3,
                'discount_id'=> 3,
                'discount_value' => 3,
                'discounted_price' => 389.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
        ];
        
        DB::table('job_ads_discount_settings')->insert($data);
    }
}
