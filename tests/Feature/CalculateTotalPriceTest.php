<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculateTotalPriceTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp() : void
    {
        parent::setUp();
        $this->artisan("db:seed");
    }
    
    /**
     * feature test for calculating order total price.
     * @dataProvider calculateTotalPriceProvider
     * @return void
     */
    public function testCalculateTotalPrice($inputs, $status, $outputs)
    {
        $response = $this->post('/api/order/calculate', $inputs);

        $response->assertStatus($status);
        $response->assertExactJson($outputs);
    }
    
    public function calculateTotalPriceProvider()
    {
        return [
            [
                'input' => [
                    'customer_id' => 5,
                    'job_ads' => [
                        [
                            'job_ad_id' => 1,
                            'quantity' => 1
                        ],
                        [
                            'job_ad_id' => 2,
                            'quantity' => 1
                        ],
                        [
                            'job_ad_id' => 3,
                            'quantity' => 1
                        ]
                    ]
                ],
                'status' => 200,
                'output' => [
                    'customer_id' => 5,
                    'job_ads' => [
                            [
                                'job_ad_id' => 1,
                                'price'=> 269.99,
                                'quantity' => 1,
                                'discount' => 0
                            ],
                            [
                                'job_ad_id' => 2,
                                'price' => 322.99,
                                'quantity' => 1,
                                'discount' => 0
                                
                            ],
                            [
                                'job_ad_id' => 3,
                                'price' => 394.99,
                                'quantity' => 1,
                                'discount' => 0
                            ]
                    ],
                    'total_price' => 987.97
                ]
            ],
            [
                'input' => [
                    'customer_id' => 1,
                    'job_ads' => [
                        [
                            'job_ad_id' => 1,
                            'quantity' => 3
                        ],
                        [
                            'job_ad_id' => 3,
                            'quantity' => 1
                        ]
                    ]
                ],
                'status' => 200,
                'output' => [
                    'customer_id' => 1,
                    'job_ads' => [
                        [
                            'job_ad_id' => 1,
                            'price'=> 539.98,
                            'quantity' => 3,
                            'discount' => 269.99
                        ],
                        [
                            'job_ad_id' => 3,
                            'price' => 394.99,
                            'quantity' => 1,
                            'discount' => 0
                            
                        ]
                    ],
                    'total_price' => 934.97
                ]
            ],
            [
                'input' => [
                    'customer_id' => 2,
                    'job_ads' => [
                        [
                            'job_ad_id' => 2,
                            'quantity' => 3
                        ],
                        [
                            'job_ad_id' => 3,
                            'quantity' => 1
                        ]
                    ]
                ],
                'status' => 200,
                'output' => [
                    'customer_id' => 2,
                    'job_ads' => [
                        [
                            'job_ad_id' => 2,
                            'price'=> 899.97,
                            'quantity' => 3,
                            'discount' => 69
                        ],
                        [
                            'job_ad_id' => 3,
                            'price' => 394.99,
                            'quantity' => 1,
                            'discount' => 0
                        ]
                    ],
                    'total_price' => 1294.96
                ]
            ],
            [
                'input' => [
                    'customer_id' => 3,
                    'job_ads' => [
                        [
                            'job_ad_id' => 3,
                            'quantity' => 4
                        ]
                    ]
                ],
                'status' => 200,
                'output' => [
                    'customer_id' => 3,
                    'job_ads' => [
                        [
                            'job_ad_id' => 3,
                            'price'=> 1519.96,
                            'quantity' => 4,
                            'discount' => 60
                        ]
                    ],
                    'total_price' => 1519.96
                ]
            ],
            [
                'input' => [],
                'status' => 400,
                'output' => ['code' => 400, 'message' => 'Bad Request']
            ]
            
        ];
    }
}
