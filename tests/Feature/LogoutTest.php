<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * logout user who doesn't have authentication token or who doesn't login first
     */
    public function testLogoutWithUserWhoDoesNotLogin(){
        $response = $this->postJson('/api/logout/');
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $response->assertStatus(401);
    }

    /**
     * logout user who have authentication token or who login first
     */
    public function testLogoutWithUserWhoLogin(){
        $response = $this->postJson('/api/login/', ['user_name' => 'nani', 'password' => '12345678']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'Successfully logged in',
        ]);

        $user = User::where('user_name', 'nani')
            ->select(['id', 'user_name', 'first_name', 'last_name', 'email', 'phone', 'is_admin', 'is_active','created_at'])
            ->first();
        Sanctum::actingAs($user);
        $response = $this->postJson('/api/logout/');
        $response->assertJson([
            'status' => 200,
            'message' => 'successfully logged out',
        ]);
        $response->assertStatus(200);
    }
}
