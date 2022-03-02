<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_user_details()
    {
        $user = User::factory()->create();
        $data = [
            "name" => "John Doe",
            "email" => "johndoe@gmail.com"
        ];

        $response = $this->actingAs($user)
                        ->withoutExceptionHandling()
                        ->put('/api/user/'.$user->id.'/update', $data);
            
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "full_name" => "John Doe",
            "email" => "johndoe@gmail.com"
        ]);
    }

    public function test_delete_user_details()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                        ->withoutExceptionHandling()
                        ->get('/api/user/'.$user->id.'/details');
        $response->assertStatus(200);
    }
}
