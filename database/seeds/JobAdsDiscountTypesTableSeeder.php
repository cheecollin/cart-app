<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JobAdsDiscountTypeTableSeeder extends Seeder
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
                'id' => 1,
                'name' => 'x for y price',
                'description' => 'grouped discount for job ads',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'direct',
                'description' => 'direct discount for a job ads',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'x or more',
                'description' => 'discount for a job ads if order more than x',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        
        DB::table('job_ads_discount_types')->insert($data);
    }
}
