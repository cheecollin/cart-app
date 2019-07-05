<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JobAdsTableSeeder extends Seeder
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
                'name' => 'classic',
                'description' => 'Classic Ad',
                'price' => 269.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'standout',
                'description' => 'Standout Ad',
                'price' => 322.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'premium',
                'description' => 'Premium Ad',
                'price' => 394.99,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        
        DB::table('job_ads')->insert($data);
    }
}
