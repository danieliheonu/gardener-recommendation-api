<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Gardener;

class GardenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_gardeners()
    {
        $response = $this->withoutExceptionHandling()
                        ->get('/api/gardeners');

        $response->assertStatus(200);
    }

    public function test_create_a_gardener(){
        $data = [
            "user_id" => "1",
            "location" => "Lagos",
            "country" => "Nigeria"
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->withExceptionHandling()
                        ->post('/api/gardener/register', $data);
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function test_retrieve_a_gardener(){
        $user = User::factory()->create();
        $gardener = Gardener::factory()->create();

        $response = $this->actingAs($user)
                        ->withExceptionHandling()
                        ->get('/api/gardener/'.$gardener->id.'/details');
        $response->assertStatus(200);
    }

    public function test_update_a_gardener(){
        $data = [      
            "location" => "Mbem",      
            "country" => "Kenya"
        ];

        $user = User::factory()->create();
        $gardener = Gardener::factory()->create();

        $response = $this->actingAs($user)
                        ->withExceptionHandling()
                        ->put('/api/gardener/'.$gardener->id.'/update', $data);
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function test_delete_a_gardener(){
        $user = User::factory()->create();
        $gardener = Gardener::factory()->create();

        $response = $this->actingAs($user)
                        ->withExceptionHandling()
                        ->delete('/api/gardener/'.$gardener->id.'/delete');
        $response->assertStatus(200);
    }
}
