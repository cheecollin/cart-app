<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp() : void
    {
        parent::setUp();
        $this->artisan("db:seed");
    }
    
    /**
     * test create order.
     * @dataProvider createOrderProvider
     * @return void
     */
    public function testcreateOrder($inputs, $status, $database)
    {
        $response = $this->post('/api/orders', $inputs);

        $response->assertStatus($status);
        
        if ($status == 201) {
            // check database record
            $this->assertDatabaseHas('orders', [
                'customer_id' => $database['customer_id']
            ]);
            
            foreach ($database['job_ads'] as $job_ad) {
                $this->assertDatabaseHas('order_lines', [
                    'job_ad_id' => $job_ad['job_ad_id'],
                    'price'=> $job_ad['price'],
                    'quantity' => $job_ad['quantity'],
                    'discount' => $job_ad['discount']
                ]);
            }
        }
    }
    
    public function createOrderProvider()
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
                'status' => 201,
                'database' => [
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
                'status' => 201,
                'database' => [
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
                'status' => 201,
                'database' => [
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
                'status' => 201,
                'database' => [
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
                'database' => []
            ]
            
        ];
    }
}
