<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class CustomerTest extends TestCase
{

    use RefreshDatabase;    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_customers()
    {
        $response = $this->withoutExceptionHandling()->get('/api/customers');
        $response->assertStatus(200);
    }

    public function test_get_all_customers_location(){
        $response = $this->withoutExceptionHandling()->get('/api/locations');
        $response->assertStatus(200);
    }

    // public function test_create_a_customer(){
    //     $data = [
    //         "user_id" => "1",
    //         "location" => "Lagos",
    //         "country" => "Nigeria"
    //     ];

    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)
    //                     ->withExceptionHandling()
    //                     ->post('/api/customer/register', $data);

    //     $response->assertStatus(201);
    // }

    public function test_retrieve_a_customer(){
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                        ->withoutExceptionHandling()
                        ->get('/api/customer/'. $customer->id.'/details');
        $response->assertStatus(200);
    }

    public function test_update_a_customer_details(){
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $data = [
            "location" => "Mbem",
            "country" => "Kenya"
        ];

        $response = $this->actingAs($user)
                        ->withoutExceptionHandling()
                        ->put('/api/customer/'. $customer->id.'/update', $data);
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function test_delete_a_customer(){
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)
                        ->withoutExceptionHandling()
                        ->delete('/api/customer/'. $customer->id.'/delete');
        $response->assertStatus(200);
    }
}
