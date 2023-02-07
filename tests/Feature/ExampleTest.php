<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $this->assertTrue(true);
    }
    public function test_add_item_shoping_cart()
    {
        // /api/v1/registerProductShoppingCart

        $response = $this->post('/api/v1/registerProductShoppingCart', ["filter"=>2,"shopping_cart_id"=>4,"typeFilter"=>"product_id"]);
        $response->assertJson([
            'created' => true,
        ]);
    
 
    }
}
